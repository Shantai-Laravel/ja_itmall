@extends('front.app')
@section('content')
    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>
    <main>
        <div class="cartContent">
            <div class="container">
                <h3>{{ trans('vars.Cart.cart') }}</h3>
                <div class="row deliveryCart">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea1') }}</div>
                            <p>{{ trans('vars.General.textArea1') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea2') }}</div>
                            <p>{{ trans('vars.General.textArea2') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea3') }}</div>
                            <p>{{ trans('vars.General.textArea3') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea4') }}</div>
                            <p>{{ trans('vars.General.textArea4') }}</p>
                        </div>
                    </div>
                </div>
                @if (Auth::guard('persons')->user())
                    <cart-block :items="{{ $cartProducts }}"
                                :mode="'cart'"
                    ></cart-block>
                @else
                    @if (!is_null($unloggedUser))
                        <cart-block :items="{{ $cartProducts }}"
                                    :mode="'guest'"
                        ></cart-block>
                    @else
                        <cart-block :items="{{ $cartProducts }}"
                                :mode="'auth'"
                        ></cart-block>
                    @endif
                @endif
            </div>
            <view-recently><view-recently/>
        </div>
    </main>
    @include('front.partials.footer')
@stop
