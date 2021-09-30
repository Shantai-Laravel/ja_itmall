<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PagesController as PageItem;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Models\SetGallery;
use App\Models\SetProductImage;
use App\Models\ProductImage;

class ReziseImagesController extends Controller
{
    public function index()
    {
        $setImages = SetGallery::get();
        $setProductImages = SetProductImage::get();
        $productImages = ProductImage::get();

        // Set Product Images 240 px;
        // foreach ($setProductImages as $key => $setProductImage) {
        //     $image_resize = Image::make(public_path('images/products/set/' .$setProductImage->image));
        //
        //     $image_resize->resize(240, null, function ($constraint) {
        //                     $constraint->aspectRatio();
        //                 })->save(public_path('images/products/set/' .$setProductImage->image), 85);
        // }
        //
        // // Product Images 480 px;
        // foreach ($productImages as $key => $productImage) {
        //     $image_resize = Image::make(public_path('images/products/sm/' .$productImage->src));
        //
        //     $image_resize->resize(480, null, function ($constraint) {
        //                     $constraint->aspectRatio();
        //                 })->save(public_path('images/products/sm/' .$productImage->src), 85);
        // }

        // Sets Images 480 px;
        foreach ($setImages as $key => $setImage) {
            $image_resize = Image::make(public_path('images/sets/sm/' .$setImage->src));

            $image_resize->resize(480, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(public_path('images/sets/sm/' .$setImage->src), 85);
        }


    }
}
