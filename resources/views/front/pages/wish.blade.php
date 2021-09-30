@extends('front.app')
@section('content')

    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>

    <main>
        <div class="cartContent wishContent">
            <div class="container">
                <h3>{{ trans('vars.Wishlist.wishTitle') }}</h3>

                <div class="cartBloc row">
                    <div class="bagFromFirefox col-md-12">
                        <wish-block :products="{{ $data['products'] }}"
                                    :sets="{{ $data['sets'] }}">
                        </wish-block>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('front.partials.footer')
@stop
