@extends('front.app')
@section('content')

<div class="fullWidthHeader">
    @include('front.partials.header')
</div>

@php
    $images = [];
    if ($product->images()->get()){
        foreach ($product->images()->get() as $key => $photo){
            $images[] = $photo->src;
        }
    }
    if ($product->setImages()->get()){
        foreach ($product->setImages()->get() as $key => $photoset){
            $images[] = $photoset->image;
        }
    }
    if (isMobile()) {
        $device = 'sm';
    }else{
        $device = 'og';
    }
@endphp


<main class="oneProdToFooter">
  <div class="titleFixed">
    <span>{{ $product->category->translation->name }}</span>
    <div class="imageAbsolute"></div>
  </div>
    <div class="oneProductContent">
        <ul class="crumbs">
            <li>
                <a href="{{ url('/' . $lang->lang) }}">Home</a>
            </li>
            <li>
                <a href="{{ url('/' . $lang->lang . '/catalog/' . $product->category->alias) }}">{{ $product->category->translation->name }}</a>
            </li>
            <li>
                <a href="{{ url('/' . $lang->lang. '/catalog/' . $product->category->alias .'/'. $product->alias) }}">{{ $product->translation->name }}</a>
            </li>
        </ul>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row galleryProduct">
                        @if ($images)
                            @foreach ($images as $key => $photo)
                                @if (($key == 0) || ($key == 1))
                                    <div class="col-md-6 col-12 ">
                                        @php
                                            $fileExists = file_exists(public_path('/images/products/'. $device .'/'.$photo));
                                        @endphp
                                        @if ($fileExists)
                                            <img src="/images/products/{{ $device }}/{{ $photo }}" class="mainImg"/>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif


                        @php
                            $issetParam = [];
                        @endphp
                        @if (count($product->propertyValues) >  0)

                        <p>
                            @foreach ($product->propertyValues as $key => $productValue)
                                @if (count($productValue->parametersAdditional) > 0)
                                    @if ($productValue->parameter->type == 'select' || $productValue->parameter->type == 'checkbox')
                                        @if (!is_null($productValue->value))
                                            <b>{{ $productValue->parameter->translation->name }}</b>:
                                            {{ $productValue->value->translation->name }}
                                        @endif
                                    @else
                                        @if (!in_array($productValue->parameter_id, $issetParam))
                                            @php
                                                $issetParam[] = $productValue->parameter_id;
                                            @endphp
                                            @if ($productValue->translation)
                                                @if ($productValue->translation->value !== null)
                                                    <b>{{ $productValue->parameter->translation->name }}</b>:
                                                    {{ $productValue->translation->value }}{{ $productValue->parameter->translation->unit }}
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        </p>
                        @else
                            <p></p>
                        @endif

                        @if ($images)
                            @foreach ($images as $key => $photo)
                                @if (($key == 2))
                                    <div class="col-md-6 col-12">
                                        @php
                                            $fileExists = file_exists(public_path('/images/products/'. $device .'/'.$photo));
                                        @endphp
                                        @if ($fileExists)
                                            <img src="/images/products/{{ $device }}/{{ $photo }}" class="mainImg"/>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="col-md-6 col-12 videoCont">
                            <div id="buttSoundOneProduct" class="buttSound">
                                <div class="iconSound">
                                </div>
                            </div>
                            {{-- @if ($product->video) --}}
                                <video id="videoOneProduct" width="100%" height="100%" src="/videos/{{ $product->video }}" poster="/images/products/{{ $device }}/{{ $product->mainImage->src }}" autoplay muted  loop ></video>
                            {{-- @else
                                <img src="{{ asset('/images/default.jpg' ) }}" alt="">
                            @endif --}}
                        </div>

                            @if ($images)
                                @foreach ($images as $key => $photo)
                                    @if (($key == 3))
                                        @php
                                            $fileExists = file_exists(public_path('/images/products/'. $device .'/'.$photo));
                                        @endphp
                                        @if ($fileExists)
                                        <div class="col-md-6 col-12">
                                            <img src="/images/products/{{ $device }}/{{ $photo }}" class="mainImg"/>
                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                        @if ($images)
                            @foreach ($images as $key => $photo)
                                @if (($key == 4) || ($key == 5))
                                    <div class="col-md-6 col-12 ">
                                        @php
                                            $fileExists = file_exists(public_path('/images/products/'. $device .'/'.$photo));
                                        @endphp
                                        @if ($fileExists)
                                            <img src="/images/products/{{ $device }}/{{ $photo }}" class="mainImg"/>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        <div class="col-12">
                          <div data-toggle="modal" data-target="#modalShipping" class="sizeGide shippingPopMobile">
                              Shipping, Payment and Returns
                          </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 posRelative">
                    <div class="descrItem">
                        <div>
                            <div class="name">
                                {{ $product->translation->name }}
                            </div>
                            <div class="price">{{ $product->personalPrice->price }} {{ $currency->abbr }}</div>

                            @if (count($product->propertyValues) >  0)
                                @foreach ($product->propertyValues as $key => $productValue)
                                    @if (count($productValue->parametersMain) > 0)
                                        @if ($productValue->parameter->type == 'select' || $productValue->parameter->type == 'checkbox')
                                            @if (!is_null($productValue->value))
                                                <div class="color">{{ $productValue->parameter->translation->name }}:
                                                    <span>{{ $productValue->value->translation->name }}</span>
                                                </div>
                                            @endif
                                        @else
                                            @if ($productValue->translation->value !== null)
                                                <div class="color">{{ $productValue->parameter->translation->name }}:
                                                    <span>{{ $productValue->translation->value }} </span>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @endif

                        </div>

                        <add-to-cart-button :product="{{ json_encode($product) }}"></add-to-cart-button>

                    </div>
                    <div class="textSlide">
                        <img src="/fronts/img/icons/verticalSlide.png" alt="" />
                        <img src="/fronts/img/icons/verticalSlide.png" alt="" />
                        <img src="/fronts/img/icons/verticalSlide.png" alt="" />
                    </div>
                </div>
                @if ($wearWith->count() > 0)
                {{-- <div class="col-12">
                    <h3>lifestyluri recomadate</h3>
                </div>
                <div class="col-12 setsRecomandations">
                    <div class="slideItems">
                        @foreach ($wearWith as $key => $productWearn)
                        <div class="oneProductBlock">
                            <a href="oneSetPage.html"><img src="/fronts/img/product.jpg" alt=""/></a>
                            <div class="productDescr">
                                <a href="{{ url($lang->lang.'/catalog/'.getProductLink($productWearn->category_id).$productWearn->alias) }}">
                                    @if ($productWearn->mainImage()->first())
                                        <img src="{{ asset('/images/products/og/'.$productWearn->mainImage()->first()->src ) }}" alt="">
                                    @else
                                        <img src="/images/no-image.png">
                                    @endif
                                </a>
                                <div class="price">
                                    <span>{{ $productWearn->personalPrice->price }} {{ $currency }}</span>
                                    <span>{{ $productWearn->personalPrice->old_price }} {{ $currency }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> --}}
                @endif
            </div>
        </div>

        <view-recently><view-recently/>

    </div>
</main>
@include('front.partials.footer')
@stop
