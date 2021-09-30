@extends('front.app')
@section('content')
<div class="fullWidthHeader">
    @include('front.partials.header')
</div>
<main>
    <div class="cabinet">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>{{ trans('vars.Cabinet.orderHistory') }}</h5>
                </div>
                <div class="col-lg-4 col-md-5">
                    <div class="cabinetNavBloc">
                        <div class="cabNavTitle">
                            {{ trans('vars.General.hello') }}, {{ $userdata->name }}
                        </div>
                        @include('front.account.accountMenu')
                    </div>
                    <div id="selectCabinet" class="selectOption">
                        {{ trans('vars.Wishlist.wishTitle') }} <span></span>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="cartCabinet">
                        @if (count($wishs['products']) > 0)
                        @foreach ($wishs['products'] as $key => $wishProduct)
                        <div class="itemCart">
                            <div class="descrBloc">
                                <a href="{{ url('/' . $lang->lang . '/catalog/'. $wishProduct->product->category->alias . '/' . $wishProduct->product->alias) }}">
                                @if ($wishProduct->product->mainImage)
                                <img src="/images/products/sm/{{ $wishProduct->product->mainImage->src }}" alt="{{ $wishProduct->product->translation->name }}" />
                                @else
                                <img src="/fronts/img/product.jpg" alt="" />
                                @endif
                                </a>
                                <div>
                                    <div class="name">{{ $wishProduct->product->translation->name }}</div>
                                    <div class="priceBloc priceBlocMobile">
                                        <div>{{ $wishProduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="priceBloc">
                                <div>{{ $wishProduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                @if ($wishProduct->product->discount)
                                <div>{{ $wishProduct->product->mainPrice->old_price }} {{ $mainCurrency->abbr }}</div>
                                @else
                                <div></div>
                                @endif
                            </div>
                            {{--<div class="delete"></div>--}}
                        </div>
                        @endforeach
                        @endif
                        @if (count($wishs['sets']) > 0)
                        @foreach ($wishs['sets'] as $key => $wishSet)
                        <div class="itemCart cartSet">
                            <div class="descrBloc">
                                <a href="oneProductPage.html">
                                @if ($wishSet->set->mainPhoto)
                                <img src="/images/sets/sm/{{ $wishSet->set->mainPhoto->src }}" alt=""/>
                                @else
                                <img src="/fronts/img/product.jpg" alt=""/>
                                @endif
                                </a>
                                <div>
                                    <div class="name">{{ $wishSet->set->translation->name }} {{ trans('vars.DetailsProductSet.setOneHint') }}</div>
                                    <div class="size">
                                    </div>
                                    <div class="functionalOptions">
                                        <div class="edit">{{ trans('vars.Cart.edit') }}</div>
                                        <div class="optionsOpen">
                                            @if ($wishSet->set->products)
                                            @foreach ($wishSet->set->products as $key => $wishProduct)
                                            <div class="itemCart">
                                                <div class="descrBloc">
                                                    <a href="oneProductPage.html">
                                                    @if ($wishProduct->mainImage)
                                                    <img src="/images/products/sm/{{ $wishProduct->mainImage->src }}" alt="{{ $wishProduct->translation->name }}" />
                                                    @else
                                                    <img src="/fronts/img/product.jpg" alt="" />
                                                    @endif
                                                    </a>
                                                    <div>
                                                        <div class="name">{{ $wishProduct->translation->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="priceBloc">
                                                    <div>{{ $wishProduct->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                                    @if ($wishProduct->discount > 0)
                                                    <div>{{ $wishProduct->mainPrice->old_price }} {{ $mainCurrency->abbr }}</div>
                                                    @else
                                                    <div></div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                            <div class="saveupdateBloc">
                                                <div class="butt cancel">{{ trans('vars.TehButtons.btnClose') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="priceBloc">
                                <div>{{ $wishSet->set->mainPrice->price  }} {{ $mainCurrency->abbr }}</div>
                                <div></div>
                            </div>
                            {{--<div class="delete"></div>--}}
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <a href="#" class="butt">{{ trans('vars.TehButtons.btnViewAllFavorites') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>
@include('front.partials.footer')
@stop
