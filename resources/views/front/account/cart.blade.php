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
                        <div id="selectCabinet" class="selectOption">
                            {{ trans('vars.Cart.cart') }} <span></span>
                        </div>
                        @include('front.account.accountMenu')
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="cartCabinet">
                        @if ($carts['subproducts'])
                        @foreach ($carts['subproducts'] as $key => $cart)
                        <div class="itemCart">
                            <div class="descrBloc">
                                <a href="{{ url('/'.$lang->lang.'/catalog/'.$cart->subproduct->product->category->alias.'/'.$cart->subproduct->product->alias) }}">
                                    @if ($cart->subproduct->product->mainImage)
                                        <img src="/images/products/sm/{{ $cart->subproduct->product->mainImage->src }}" alt="" />
                                    @else
                                        <img src="/fronts/img/product.jpg" alt="" />
                                    @endif
                                </a>
                                <div>
                                    <div class="name">{{ $cart->subproduct->product->translation->name }}</div>
                                    <div class="priceBloc priceBlocMobile">
                                        <div>{{ $cart->subproduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                    </div>
                                    <div class="size">
                                        <span>{{ trans('vars.DetailsProductSet.size') }}: {{ $cart->subproduct->parameterValue->translation->name }}</span> <span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $cart->qty }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="priceBloc">
                                    <div>{{ $cart->subproduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                @if ($cart->subproduct->product->discount > 0)
                                    <div>{{ $cart->subproduct->product->mainPrice->old_price }} {{ $mainCurrency->abbr }}</div>
                                @else
                                    <div></div>
                                @endif
                            </div>
                            {{--<div class="delete"></div>--}}
                        </div>
                        @endforeach
                        @endif
                        @if ($carts['sets'])
                        @foreach ($carts['sets'] as $key => $cartSet)
                        <div class="itemCart cartSet">
                            <div class="descrBloc">
                                <a href="{{ url('/'. $lang->lang . '/collection/' . $cartSet->set->collection->alias . '?order='. $cartSet->set->id) }}">
                                    @if ($cartSet->set->mainPhoto)
                                        <img src="/images/sets/sm/{{ $cartSet->set->mainPhoto->src }}" alt="" />
                                    @else
                                        <img src="/fronts/img/product.jpg" alt="" />
                                    @endif
                                </a>
                                <div>
                                    <div class="name">{{ $cartSet->set->translation->name }} {{ trans('vars.DetailsProductSet.setOneHint') }}</div>
                                    <div class="size"><span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $cartSet->qty }}</span>
                                    </div>
                                    <div class="functionalOptions">
                                        <div class="edit">{{ trans('vars.Cart.edit') }}</div>
                                        <div class="optionsOpen">
                                            @if ($cartSet->children)
                                            @foreach ($cartSet->children as $key => $child)
                                            <div class="itemCart">
                                                <div class="descrBloc">
                                                    <a href="{{ url('/'. $lang->lang . '/catalog/' . $child->subproduct->product->category->alias .'/'. $child->subproduct->product->alias) }}">
                                                        @if ($child->subproduct->product->mainImage)
                                                            <img src="/images/products/sm/{{ $child->subproduct->product->mainImage->src }}" alt="" />
                                                        @else
                                                            <img src="/fronts/img/product.jpg" alt="" />
                                                        @endif
                                                    </a>
                                                    <div>
                                                        <div class="name">{{ $child->subproduct->product->translation->name }}</div>
                                                    </div>
                                                </div>
                                                <div class="priceBloc">
                                                    <div>{{ $child->subproduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                                    @if ($child->subproduct->product->discount > 0)
                                                        <div>{{ $child->subproduct->product->mainPrice->old_price }} {{ $mainCurrency->abbr }}</div>
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
                                <div>{{ $cartSet->set->mainPrice->price }} {{ $mainCurrency->abbr }}</div>
                                <div></div>
                            </div>
                            {{--<div class="delete"></div>--}}
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <a href="{{ url('/'.$lang->lang.'/cart') }}" class="butt">{{ trans('vars.TehButtons.btnViewAllCarts') }}</a>
                </div>
            </div>
        </div>
    </div>
</main>
@include('front.partials.footer')
@stop
