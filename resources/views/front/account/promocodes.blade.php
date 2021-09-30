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
                            {{ trans('vars.Cabinet.myPromocodes') }} <span></span>
                        </div>
                        @include('front.account.accountMenu')
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    @if ($promocodes->count() > 0)
                    @foreach ($promocodes as $key => $promocode)
                        @php
                            $promocodeClass = "promocodeAvailable";
                            if ($promocode->times <= $promocode->to_use) $promocodeClass = "promocodeUsed";
                            if ($promocode->valid_to <= date('Y-m-d')) $promocodeClass = "promocodeExpired";
                        @endphp
                        <div class="promocodeItem {{ $promocodeClass }}">
                            <div class="starPromocode">
                                <span>{{ trans('vars.Cabinet.discount') }}</span>
                                <span>{{ $promocode->discount }}%</span>
                            </div>
                            <div class="promocodeInner">
                                <div class="bloc">
                                    {{ trans('vars.Cabinet.validTill') }} <span>{{ $promocode->valid_to }}</span>
                                </div>
                                <div class="bloc">
                                    {{ trans('vars.Cabinet.canBeUsedOn') }} <span>{{ trans('vars.Cabinet.promocodeTrashhold') }} {{ $promocode->treshold }} {{ $mainCurrency->abbr }}</span>
                                </div>
                                <div class="bloc">
                                    {{ trans('vars.Cabinet.couponStatus') }} <span>{{ $promocode->status }}</span>
                                </div>
                                <div class="bloc butt">
                                    {{ trans('vars.Cabinet.vaucherCode') }} <span>{{ $promocode->name }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@include('front.partials.footer')
@stop
