<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Translation;
use App\Models\TranslationLine;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Mollie\Laravel\Facades\Mollie;

use View;

class Controller extends BaseController
{
    use AuthorizesRequests,  DispatchesJobs, ValidatesRequests;

    protected $langs;

    protected $lang;

    public function __construct()
    {
        $MD = 140; // Moldova ID

        $this->langs    = Lang::all();
        $this->lang     = Lang::where('lang', session('applocale') ?? 'ro')->first();

        $this->country  = Country::where('id', @$_COOKIE['country_id'])->first();
        if (is_null($this->country)) {
            $this->country  = Country::first();
        }

        $this->currency = Currency::where('id', @$_COOKIE['currency_id'])->first();
        if (is_null($this->currency)) {
            $this->currency = Currency::first();
        }

        if (!Auth::check()) {
            return redirect('/auth/login');
        }
    }

    public function dhl()
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://wsbexpress.dhl.com/rest/sndpt/ShipmentRequest";

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjE2MTExIiwiYWNjZXNzVG9rZW4iOiJmYmE5ZTJkNTZhOWQwNGU5MDA2ODhiYmIiLCJ0b2tlbklkIjoiMjA4Iiwid2FsbGV0SWQiOiI4MjY0IiwidGltZSI6MTU3Nzc4NjkxNSwiZXhwaXJlZEF0IjoxNTg1Njg4NDAwLCJyb2xlcyI6W119.toEBTY107EeiAAnXz1KEYiMf-q7RcBUS0LiwDPYOcNM";

        $username    = 'itmalles@gmail.com'; // dhl developer account name, not email
        $password    = 'Parola123@'; // dhl developer account pass
        $request = $client->post($url, [
            'headers' => [
                    'Authorization' =>  "Basic " . base64_encode( $username.':'.$password ),
                    'Content-Type' => 'application/json',
                ],
            'json' => [
                'username' => $username,
                'password' => $username,

            ],
            ]);

       echo "<pre>";
       dd(json_decode($request->getBody()->getContents()));


        $mode        = 'sandbox'; // sandbox or production

        $appname     = 'zt12345'; // sandbox app
        $apppass     = 'geheim'; // sandbox app
        // $endpoint    = 'https://cig.dhl.de/services/' . $mode . '/rest/sendungsverfolgung';
        $endpoint    = 'https://wsbexpress.dhl.com/sndpt/expressRateBook?WSDL';
        $payload     = simplexml_load_string( '<?xml version="1.0" encoding="UTF-8" standalone="no"?><data appname="' . $appname . '" language-code="de" password="' . $apppass . '" piece-code="" request="d-get-piece-detail"/>' );
        $shipmentids = array(
            '00340434161094015902' // in sandbox only special numbers are allowed
        );


        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Authorization: Basic " . base64_encode( "$username:$password" )
            )
        );

        // dd($opts);

        $context = stream_context_create( $opts );


        foreach ( $shipmentids as $shipmentid ) {
            $payload->attributes()->{'piece-code'} = $shipmentid;
            $response                              = file_get_contents( $endpoint . '?' . http_build_query( array( 'xml' => $payload->saveXML() ) ), false, $context );
            $responseXml                           = simplexml_load_string( $response );
            $status                                = null;

            // get last state
            foreach ( $responseXml->data->data->data as $event ) {
                $status = $event->attributes()->{'event-short-status'};
            }

            echo "Shipment " . $shipmentid . " is in state: " . $status . "\n";
        }
    }

    public function paydo()
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://payop.com/v1/instrument-settings/payment-methods/available-for-user";

        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjE2MTExIiwiYWNjZXNzVG9rZW4iOiJmYmE5ZTJkNTZhOWQwNGU5MDA2ODhiYmIiLCJ0b2tlbklkIjoiMjA4Iiwid2FsbGV0SWQiOiI4MjY0IiwidGltZSI6MTU3Nzc4NjkxNSwiZXhwaXJlZEF0IjoxNTg1Njg4NDAwLCJyb2xlcyI6W119.toEBTY107EeiAAnXz1KEYiMf-q7RcBUS0LiwDPYOcNM";

        $request = $client->get($url, [
            'headers' => [
                    'Authorization' =>  "Bearer {$token}",
                    'Content-Type' => 'application/json',
                ]
            ]);

       echo "<pre>";
       dd(json_decode($request->getBody()->getContents()));
    }

    public function translations()
    {
        $translations = TranslationLine::where('lang_id', 2)->get();

        foreach ($translations as $key => $translation) {
            // echo $translation->line;

            echo $translation->trans->group->key . ' -#- ' . $translation->trans->key . ' -*- ' . $translation->line;
            echo "<br>";
        }
    }

    public function apiFrisbo()
    {
        $client = new \GuzzleHttp\Client();
        $url = "https://api.frisbo.ro/v1/organizations/183/products";

        $token ="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6IlFqRTROa00zTnprNFJVSTROalU0UVVSRFFUUkNOak13UVRBd1JrVXhRamxDT1RRNU1rWTJNdyJ9.eyJpc3MiOiJodHRwczovL2ZyaXNiby1yby5ldS5hdXRoMC5jb20vIiwic3ViIjoiYXV0aDB8Mjc2IiwiYXVkIjpbImh0dHBzOi8vYXBpLmZyaXNiby5ybyIsImh0dHBzOi8vZnJpc2JvLXJvLmV1LmF1dGgwLmNvbS91c2VyaW5mbyJdLCJpYXQiOjE1NzM2NDM3MTksImV4cCI6MTU3MzczMDExOSwiYXpwIjoiMkNoeUgyeXNRYThOdHdEV0tFem1oekpfa2p5cHlkMk0iLCJzY29wZSI6Im9wZW5pZCBwcm9maWxlIGVtYWlsIiwiZ3R5IjoicGFzc3dvcmQifQ.KPG1WsME-OFFhcbGksHNigGYPZynvC91pnSA5vg3EDscrpM4pSyHkOZfWAJSaHM8mwOrLCORK_BOPF7IJAaYAIXivy2GdcVg0UN5AMnPW872T4_P-LbjgDmpAIfK59j9Mwq-pvOifKvHnfhGSePIgW2zMG8HU3e7rcBx4xsRsbN_8s9u86Oifh5_QvQy_hqm7YTEmX3xBFkwlNokfxS9kxhN9Z5kj38W8R40r7NuoKvYTffU5Vwq3qU0FmQvAKEafgzU3O53PUG-v8jHUsXda5wF7eBCPy1YF3H80L8ZHOkJZPDDBSCY8diFdwrV2AsFzAmGsD5e3czjMYkNlo2YqQ";
        $request = $client->get($url, [
            'headers' => [
                    'Authorization' =>  "Bearer {$token}"
                ]
            ]);

       echo "<pre>";
       dd(json_decode($request->getBody()->getContents()));
    }

    public function adyen()
    {
        $token = 'AQEjhmfuXNWTK0Qc+iSZpkk5q+i0fRahjooxzd4/Dgob/UCYvTkQwV1bDb7kfNy1WIxIIkxgBw==-2jepkBaywcknnvngmUEtHxuagEHnL+8nOXGdQuv7bLw=-838md9FTt2SJCecU';

        $client = new \GuzzleHttp\Client();
        $url = "https://checkout-test.adyen.com/v51/payments";

        $request = $client->post($url, [
            'headers' => [
                    'X-API-Key' => $token,
                    'Content-Type' => 'application/json',
                ],
            'json' => [
                "amount"=> [
                "currency" => "EUR",
                "value" => 0.1
            ],
              "reference" => "100200",
              "paymentMethod" => [
                "type"=> "scheme",
                "number" => "4111111111111111",
                "expiryMonth" => "10",
                "expiryYear" => "2020",
                "holderName" => "John Smith",
                "cvc" => "737"
            ],
              "returnUrl" => "https://juliaallert.com",
              "merchantAccount" => "ITMallOUECOM"
            ],
        ]);

        dd(json_decode($request->getBody()->getContents()));
    }


    // Mollie methods
    public function mollie()
    {
        $methods = Mollie::api()->methods()->allActive(['include' => 'pricing']);

        // $mollie = Mollie::api()->methods()->get("creditcard", ["include" => "issuers,pricing"]);
        // dd($mollie);

        return view('front.mollie.index', compact('methods'));
    }

    public function molliePayment($id)
    {
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => '30.00', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'method' => $id,
            'description' => 'Test payment',
            'webhookUrl' => route('webhooks.mollie'),
            'redirectUrl' => route('order.success', ['method' => $id]),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function webhooks()
    {
        dd('webhooks');
    }

    public function redirectUrl($method)
    {
        $method = Mollie::api()->methods()->get($method, ["include" => "issuers,pricing"]);

        return view('front.mollie.callBack', compact('method'));
    }

    public function getCountriesList(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipDetails = @json_decode(file_get_contents("https://ipinfo.io/{$ip}"));

        if ($ipDetails->country) {
            $data['selected'] = Country::with(['translation', 'lang', 'currency'])->where('iso', $ipDetails->country)->first();
        }else{
            $data['selected'] = Country::with(['translation', 'lang', 'currency'])->where('active', 1)->first();
        }
        $data['countries'] = Country::with(['translation', 'lang'])->orderBy('iso', 'asc')->get();
        $data['languages'] = Lang::get();
        $data['currencies'] = Currency::where('id', 5)->get();

        return $data;
    }

    public function saveCountryUser(Request $request)
    {
        // return $request->all();
        $country = Country::where('id', $request->get('countryId'))->first();
        $lang = Lang::where('id', $request->get('langId'))->first();
        $currency = Currency::where('id', $request->get('currencyId'))->first();

        // if (!is_null($country)) {
            setcookie('cookie', 1, time() + 10000000, '/');

            // setcookie('country_id', $country->id, time() + 10000000, '/');
            // setcookie('lang_id', $lang->lang, time() + 10000000, '/');
            // setcookie('currency_id', $currency->id, time() + 10000000, '/');
        // }

        // return $lang->lang;
    }

    public function dismissCountryUser(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipDetails = @json_decode(file_get_contents("https://ipinfo.io/{$ip}"));

        $country = Country::where('active', 1)->where('iso', $ipDetails->country)->first();
        $lang = Lang::where('id', $country->lang_id)->first();

        if (!is_null($country) && !is_null($lang)) {
            setcookie('country_id', $country->id, time() + 10000000, '/');
            setcookie('lang_id', $lang->lang, time() + 10000000, '/');
            setcookie('currency_id', $country->currency_id, time() + 10000000, '/');
        }

        return $lang->lang;
    }

    public function setUserSettings(Request $request)
    {
        $url = str_replace(url('/'), '', url()->previous());
        $previousLang = $this->lang->lang;

        $country = Country::where('id', $request->get('country_id'))->first();
        $lang = Lang::where('id', $request->get('lang_id'))->first();
        $currency = Currency::where('id', $request->get('currency_id'))->first();

        if (!is_null($country)) {
            setcookie('country_id', $country->id, time() + 10000000, '/');
        }

        if (!is_null($lang)) {
            setcookie('lang_id', $lang->lang, time() + 10000000, '/');
            $url =  str_replace('/'.$previousLang, '/'.$lang->lang, $url);
        }

        if (!is_null($currency)) {
            setcookie('currency_id', $currency->id, time() + 10000000, '/');
        }

        return redirect($url);
    }

}
