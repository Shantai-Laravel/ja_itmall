@extends('front.app')
@section('content')

    @include('front.partials.header')
    <main>
        <div class="productsPageContent mainPage">
          <div class="titleFixed">
            <span>{{ $category->translation->name }}</span>
          </div>
            <div class="productsPageHeader">
                <div class="headerText">
                    <div><span>{{ $category->translation->name }}</span></div>
                    <div><span id="filterWord">{{ trans('vars.General.filter') }}</span></div>
                </div>
                <div class="btnFilter"></div>
                <parameters-filter :category="{{ $category }}"></parameters-filter>
            </div>
            <category :category="{{ $category }}" :product="0"></category>
        </div>
    </main>
    @include('front.partials.footer')

@stop
