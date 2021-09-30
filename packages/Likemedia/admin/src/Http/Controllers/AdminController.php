<?php

namespace Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\Parameter;
use App\Models\Lang;
use App\Models\TranslationLine;
use App\Models\ParameterValueProduct;

class AdminController extends Controller
{
    public function index()
    {

        // $langs = Lang::pluck('id')->toArray();
        //
        // // dd($langs);
        // $translations = TranslationLine::whereNotIn('lang_id', $langs)->limit(500)->delete();
        //
        // dd($translations);
        // foreach ($translations as $key => $value) {
        //     // code...
        // }

        $products = Product::get();

        if ($products->count() > 0) {
            foreach ($products as $key => $product) {
                $mainPrice = $product->mainPrice->price;
                $product->update([
                    'price' => $mainPrice,
                    'actual_price' => $mainPrice,
                ]);
            }
        }

        // $parameters = Parameter::where('type', '!=', 'select')->where('type', '!=', 'checkbox')->get();
        // foreach ($parameters as $key => $parameter) {
        //     if ($parameter->type == 'text' || $parameter->type == 'textarea') {
        //         // $productParam = ParameterValueProduct::where('parameter_id', $parameter->id)->delete();
        //     }
        // }

        return view('admin::admin.dashbord');
    }
}
