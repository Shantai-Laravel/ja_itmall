@extends('front.app')
@section('content')
    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>
    <main>
        <div class="productsPageContent sale">
          <div class="titleFixed">
            <span>outlet</span>
          </div>
            <div class="productsPageHeader">
                <div class="headerText text-center">
                    <div><span>{{ trans('vars.PagesNames.pageNameOutletTitle') }}</span></div>
                </div>
            </div>
            <sale :wish="{{ json_encode($wishListIds) }}"></sale>
            <view-recently><view-recently/>
        </div>
    </main>
@include('front.partials.footer')
@stop
