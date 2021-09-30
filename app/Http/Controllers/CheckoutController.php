<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
// use Mollie\Laravel\Facades\Mollie;
use App\Http\Controllers\Controller;
use App\FrontUser;
use App\Models\Cart;
use App\Models\FrontUserUnlogged;
use App\Models\FrontUserAddress;
use App\Models\Promocode;
use App\Models\PromocodeType;
use App\Models\Set;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\CRMOrders;
use App\Models\CRMOrderItem;
use Session;


class CheckoutController extends Controller
{
    public function order(Request $request)
    {
        $user = $this->checkIfLogged();

        // step 1
        $preOrder = $this->orderShipping($request, $user);

        // step 2
        $this->createPayment($request, $preOrder, $user);

        return $request->all();
    }

    public function orderShipping($request, $user)
    {
         $userAddress = 0;

         $country    = Country::find($request->get('country'));
         $currency   = Currency::where('abbr', $request->get('cartData')['currency'])->first();
         $delivery   = Delivery::find($request->get('cartData')['delivery']);
         $payment    = Payment::find($request->get('payment'));
         $promocode  = Promocode::where('name', @$request->get('cartData')['promocode'])->first();

         // set empty data of users
         if ($user['status'] == 'auth') {
             $frontUser = FrontUser::find($user['user_id']);
             FrontUser::where('id', $frontUser->id)->update([
                 'name'     => $frontUser->name ? $frontUser->name : $request->get('name'),
                 'email'    => $frontUser->email ? $frontUser->email : $request->get('email'),
                 'phone'    => $frontUser->phone ? $frontUser->phone : $request->get('phone'),
                 'code'     => $frontUser->code ? $frontUser->code : $request->get('code'),
             ]);
         }else{
             $frontGuest = FrontUserUnlogged::where('user_id', $user['user_id'])->first();
             FrontUserUnlogged::where('id', $frontGuest->id)->update([
                 'name'     => $frontGuest->name ? $frontGuest->name : $request->get('name'),
                 'email'    => $frontGuest->email ? $frontGuest->email : $request->get('email'),
                 'phone'    => $frontGuest->phone ? $frontGuest->phone : $request->get('phone'),
                 'code'     => $frontGuest->code ? $frontGuest->code : $request->get('code'),
             ]);
         }

         // set default address
         if ($request->get('saveAddress') && $user['status'] !== 'guest'){
             if ($request->get('defaultPayment')){
                 FrontUser::where('id', $user['user_id'])->update([
                     'payment_id' => $request->get('payment')
                 ]);
             }else{
                 FrontUser::where('id', $user['user_id'])->update([
                     'payment_id' => 0
                 ]);
             }

             FrontUserAddress::where('front_user_id', $user['user_id'])->delete();
             $userAddress = FrontUserAddress::create([
                 'front_user_id' => $user['user_id'],
                 'country'       => $request->get('country'),
                 'region'        => $request->get('region'),
                 'location'      => $request->get('city'),
                 'address'       => $request->get('address'),
                 'code'          => $request->get('zip'),
                 'homenumber'    => $request->get('apartment'),
                 'phone_code'    => $request->get('phone_code'),
                 'phone'         => $request->get('phone'),
             ]);
         }

         // create order
         $ordersCount = CRMOrders::get();
         $order = CRMOrders::create([
             'order_hash'        => 1000 + $ordersCount->count(),
             'user_id'           => $user['status'] == 'auth' ? $user['user_id'] : 0,
             'guest_user_id'     => $user['status'] == 'guest' ? $user['guest_id'] : 0,
             'address_id'        => $userAddress ? $userAddress->id : 0,
             'promocode_id'      => !is_null($promocode) ? $promocode->id : null,
             'currency_id'       => !is_null($currency) ? $currency->id : null,
             'payment_id'        => $request->get('payment'),
             'delivery_id'       => $request->get('cartData')['delivery'],
             'country_id'        => $request->get('country'),
             'amount'            => $request->get('cartData')['amount'],
             'main_status'       => 'pendding',
             'change_status_at'  => date('Y-m-d'),
             'step'              => 1,
             'label'             => 'With shipping details',
         ]);

         // create order details
         $order->details()->create([
             'contact_name'      => $request->get('name'),
             'email'             => $request->get('email'),
             'promocode'         => !is_null($promocode) ? $promocode->name : null,
             'code'              => $request->get('phone_code'),
             'phone'             => $request->get('phone'),
             'currency'          => @$currency->abbr,
             'payment'           => @$payment->translation->name,
             'delivery'          => @$delivery->translation->name,
             'country'           => @$country->translation->name,
             'region'            => $request->get('region'),
             'city'              => $request->get('city'),
             'address'           => $request->get('address'),
             'apartment'         => $request->get('apartment'),
             'zip'               => $request->get('zip'),
             'delivery_price'    => @$delivery->price,
             'tax_price'         => $request->get('cartData')['tax'],
         ]);

         return $order->id;
     }

     public function createPayment($request, $orderId, $user)
     {
         $amount = number_format((float)$request->get('cartData')['amount'], 2, '.', '');

         $client = new Client();
         $token = "";

         $order = CRMOrders::find($orderId);

         $url = "https://checkout.pay.g2a.com/index/createQuote";

         $secret = 'IyC=WR71dT4*Nl$_Kj4HzG%rKOKC%-oFm-45FB6sfBr=wnq3KvL7*GyJf6Wb@7pg';

         $hash = $order->order_hash.uniqid().$amount.'EUR'.$secret;

         $secretKey = 'cbd990f042dff3a2aa18886c';
         $orderH = ['id' => $order->order_hash, 'amount' => $amount, 'currency' => 'EUR', 'secret' => $secret];
         ksort($orderH, SORT_STRING);
         $dataSet = array_values($orderH);
         $dataSet[] = $secretKey;

         $signature = hash('sha256', implode(':', $dataSet));

         $guzzle = $client->post($url,[
             'headers' => [
                     // 'Authorization' =>  "Bearer {$token}",
                     'Content-Type' => 'application/json'
             ],
            'json' => [
                    "api_hash" => "5c2a35f6-3e4d-4e93-b8b0-134bc7903865",
                    "hash" => $signature,
                    "order_id" => $order->order_hash,
                    "amount" => $amount,
                    "currency" => "EUR",
                    "email" => $order->details->email,
                    "url_failure" => "http://my-test-store.com/order/fail",
                    "url_ok" => "http://my-test-store.com/order/success",
                    "items" => [
                        [   "sku" => "450",
                            "name" => "Test Item",
                            "amount" => "15",
                            "type" => "item_type",
                            "qty" => "1",
                            "price" => 15,
                            "id" => "5619",
                            "url" => "http://example.com/products/item/example-item-name-5619"
                        ],
                    ]
                 ]
            ]);

            $res = json_decode($guzzle->getBody()->getContents());

            dd($res);
     }

     public function failPayment($orderId, $userId)
     {
         dd('fail');
     }

     public function successPayment($orderId, $user)
     {
         $order = CRMOrders::where('id', $orderId)->where('step', 1)->first();
         $carts = $this->getAllCarts($user['user_id']);
         $order = CRMOrders::find($orderId);
         $currency = Currency::where('abbr', 'EUR')->first();

         if (count($carts['subproducts']) > 0) {
             foreach ($carts['subproducts'] as $key => $product) {
                 if ($product->stock_qty > 0) {
                     CRMOrderItem::create([
                         'order_id'      => $order->id,
                         'subproduct_id' => $product->subproduct_id,
                         'product_id'    => 0,
                         'qty'           => $product->qty,
                         'discount'      => $product->subproduct->discount,
                         'code'          => $product->subproduct->code,
                         'old_price'     => $product->subproduct->product->mainPrice->old_price,
                         'price'         => $product->subproduct->product->mainPrice->price,
                         'currency'      => $currency->abbr,
                     ]);
                     SubProduct::where('id', $product->subproduct_id)->update(['stoc' => $product->subproduct->stoc - $product->qty]);
                 }
             }
         }

         if (count($carts['sets']) > 0) {
             foreach ($carts['sets'] as $key => $set) {
                 if ($set->stock_qty > 0) {
                     $list = CRMOrderItem::create([
                                 'order_id'  => $order->id,
                                 'set_id'    => $set->set_id,
                                 'product_id'=> 0,
                                 'qty'       => $set->qty,
                                 'code'      => $set->set->code,
                                 'old_price' => $set->set->mainPrice->old_price,
                                 'price'     => $set->set->mainPrice->price,
                                 'currency'  => $currency->abbr,
                             ]);

                     Set::where('id', $set->set_id)->update(['stock' => $set->set->stock - $set->qty]);

                     if ($set->children()->get()) {
                         foreach ($set->children()->get() as $key => $chid) {
                             CRMOrderItem::create([
                                 'order_id'  => $order->id,
                                 'parent_id' => $list->id,
                                 'set_id'    => $chid->set_id,
                                 'product_id' => 0,
                                 'subproduct_id' => $chid->subproduct_id,
                                 'qty'       => $chid->qty,
                                 'currency'  => $currency->abbr,
                             ]);
                             if (!is_null($chid->subproduct)) {
                                 SubProduct::where('id', $chid->subproduct_id)->update(['stoc' => $chid->subproduct->stoc - $chid->qty]);
                             }else{
                                 Product::where('id', $chid->product_id)->update(['stock' => $chid->product->stock - $chid->qty]);
                             }
                         }
                     }
                 }
             }
         }

         // set promocode
         $promocode = Promocode::where('name', @$_COOKIE['promocode'])->first();

         $this->checkPromocode($promocode, $user);
         setcookie('promocode', '', time() + 10000000, '/');

         if(Auth::guard('persons')->user()) {
             $user = FrontUser::find(Auth::guard('persons')->id());
             $user_id = $user->id;
             $promoType = PromocodeType::where('name', 'user')->first();
         } else {
             $user_id = 0;
             $promoType = PromocodeType::where('name', 'repeated')->first();
         }

         $this->createPromocode($promoType, $user_id);

         $user = $this->checkIfLogged();
         Cart::where('user_id', $user['user_id'])->delete();

         //  send emails
         $email = $order->details->email;
         if($user['status'] == 'guest') {
             $data['user'] = FrontUserUnlogged::where('user_id', @$_COOKIE['user_id'])->first();
             $data['promocode'] = Promocode::where('user_id', 0)
                                         ->whereRaw('to_use < times')
                                         ->where('valid_to', '>', date('Y-m-d'))
                                         ->orderBy('id', 'desc')->first();

             Mail::send('mails.order.guest', $data, function($message) use ($email){
                 $message->to($email, 'Order succesefully placed on juliaallert.com.')->from('julia.allert.fashion@gmail.com')->subject('Order succesefully placed on juliaallert.com.');
             });
         }else{
             $data['user'] = FrontUser::find(Auth::guard('persons')->id());
             $data['promocode'] = Promocode::where('user_id', $data['user']->id)
                                         ->whereRaw('to_use < times')
                                         ->where('valid_to', '>', date('Y-m-d'))
                                         ->orderBy('id', 'desc')->first();

             Mail::send('mails.order.user', $data, function($message) use ($email){
                 $message->to($email, 'Order succesefully placed on juliaallert.com.')->from('julia.allert.fashion@gmail.com')->subject('Order succesefully placed on juliaallert.com.');
             });
         }

         $order->update([
             'step' => 2,
             'label' => 'With payment details',
         ]);

         // frisbo sinchornizate
         // TEMP:
         // $this->sentOrderToFrisbo($order);
         return $order->id;
     }

     /**
      **************************************************************************
      *
      * Private additional Methods
      *
      **************************************************************************
      */

      // post: validate stocks
      public function validateStocks($userId)
      {
          $data['sets'] = Cart::where('user_id', $userId)
                            ->where('parent_id', null)
                            ->where('set_id', '!=', 0)
                            ->orderBy('id', 'desc')
                            ->get();

          $data['products'] = Cart::where('user_id', $userId)
                                ->where('parent_id', null)
                                ->where('product_id', '!=', null)
                                ->orderBy('id', 'desc')
                                ->get();

          $data['subproducts'] = Cart::where('user_id', $userId)
                                  ->where('parent_id', null)
                                  ->where('subproduct_id', '!=', null)
                                  ->orderBy('id', 'desc')
                                  ->get();


          foreach ($data['products'] as $key => $product) {
              $this->validateProductStock($product);
          }
          // foreach ($data['subproducts'] as $key => $subproduct) {
          //     $this->validateSubproductStock($subproduct);
          // }
          // foreach ($data['sets'] as $key => $set) {
          //     $this->validateSetStock($set);
          // }
      }

      // post: validate products stocks
      public function validateProductStock($productCart)
      {
          $productStock = $productCart->qty;

          $prodCartsSum = Cart::where('user_id', $productCart->user_id)
                              ->where('id', '!=', $productCart->id)
                              ->where('product_id', $productCart->product_id)
                              ->get()->sum('qty');

          $prodStock = Product::find($productCart->product_id)->stock;
          $stock_qty = ($prodStock - $prodCartsSum) > 0 ? $prodStock - $prodCartsSum : 0;
          $qty       = $productCart->qty >= $stock_qty ? $stock_qty : $productCart->qty;

          $productCart->update(['stock_qty' => $stock_qty, 'qty' => $qty]);
      }

      // get updated carts of user
      private function getAllCarts($userId)
      {
          $this->validateStocks($userId);

          $data['products'] = Cart::with(['product.mainPrice', 'product.translation', 'product.mainImage'])
                                        ->where('user_id', $userId)
                                        ->where('parent_id', null)
                                        ->where('product_id', '!=', null)
                                        ->orderBy('id', 'desc')
                                        ->get();

          $data['sets'] = Cart::with(['children', 'set.price', 'set.translation', 'set.mainPhoto', 'set.products.translation', 'set.products.mainImage', 'set.products.firstSubproduct', 'set.products.subproducts.parameterValue.translation'])
                                        ->where('user_id', $userId)
                                        ->where('parent_id', null)
                                        ->where('set_id', '!=', 0)
                                        ->orderBy('id', 'desc')
                                        ->get();

          $data['subproducts'] = Cart::with(['subproduct.price', 'subproduct.product.translation', 'subproduct.product.mainImage', 'subproduct.parameterValue.translation'])
                                      ->where('user_id', $userId)
                                      ->where('parent_id', null)
                                      ->where('subproduct_id', '!=', null)
                                      ->orderBy('id', 'desc')
                                      ->get();

          return $data;
      }

     /**
      *   Private:: check promocode
      */
     private function checkPromocode($promocode, $user)
     {
         if (!is_null($promocode)) {
             if ($promocode->status == 'valid') {
                 $promocode->update([
                     'status' => 'used',
                     'to_use' => $promocode->to_use + 1,
                 ]);
             }
         }

         setcookie('promocode', '', time() + 10000000, '/');
     }

     /**
      *  private method
      *  Create promocode
      */
     private function createPromocode($promoType, $userId) {
         if (!is_null($promoType)) {
             $promocode = Promocode::create([
                'user_id' => $userId,
                'name' => $promoType->name.''.str_random(5),
                'type_id' => $promoType->id,
                'discount' => $promoType->discount,
                'valid_from' => date('Y-m-d'),
                'valid_to' => date('Y-m-d', strtotime(' + '.$promoType->period.' days')),
                'period' => $promoType->period,
                'treshold' => $promoType->treshold,
                'to_use' => 0,
                'times' => $promoType->times,
                'status' => 'valid',
                'user_id' => $userId
             ]);

             return $promocode;
         }
     }

     private function checkIfLogged()
     {
         if(auth('persons')->guest()) {
             $guest = FrontUserUnlogged::where('user_id', @$_COOKIE['user_id'])->first();
             if (!is_null($guest)) {
                 return array('is_logged' => 1, 'user_id' => @$_COOKIE['user_id'], 'status' => 'guest', 'guest_id' => $guest->id);
             }else{
                 return array('is_logged' => 0, 'user_id' => @$_COOKIE['user_id'], 'status' => 'user');
             }
         }else{
             return array('is_logged' => 1, 'user_id' => auth('persons')->id(), 'status' => 'auth');
         }
     }
}
