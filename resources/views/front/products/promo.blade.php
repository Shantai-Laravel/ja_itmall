@extends('front.app')
@section('content')
<div class="fullWidthHeader ">
    @include('front.partials.header')
</div>
<main>
    <div class="productsPageContent sale">
        <div class="titleFixed">
            <span>{{ trans('vars.PagesNames.pagePromotions') }}</span>
        </div>
        <div class="productsPageHeader">
            <div class="headerText text-center">
                <div><span>{{ trans('vars.PagesNames.pagePromotions') }}</span></div>
            </div>
        </div>
        <section class="promoGalery">
            @if ($promotions->count() > 0)
            @foreach ($promotions as $key => $promotion)
            <div class="row promoItem">
                <h4 class="col-12 title">
                    {{ $promotion->translation->name }}
                </h4>
                @if (isMobile())
                    <div class="col-12 promoBanner">
                        @if ($promotion->img)
                            <img src="/images/promotions/{{ $promotion->img_mobile }}" alt="{{ $promotion->translation->name }}">
                        @endif
                    </div>
                @else
                    <div class="col-12 promoBanner">
                        @if ($promotion->img)
                            <img src="/images/promotions/{{ $promotion->img }}" alt="{{ $promotion->translation->name }}">
                        @endif
                    </div>
                @endif

                @if ($promotion->products->count() > 0)
                <h5 class="col-12">{{ trans('vars.DetailsProductSet.productsFrom') }} {{ $promotion->translation->name }}</h5>
                @foreach ($promotion->products as $key => $product)
                <div class="col-xl-3 col-lg-4 col-sm-6 col-12 oneProductBlock">
                    <a href="{{ url('/' . $lang->lang . '/catalog/' . $product->category->alias. '/'. $product->alias) }}">
                        <img src="/images/products/md/{{ $product->mainImage->src }}"/>
                    </a>
                    <product :product="{{ $product }}" :id="{{ $product->id }}"></product>
                </div>
                @endforeach
                @endif
            </div>
            @endforeach
            @endif
        </section>
    </div>
</main>
@include('front.partials.footer')
@stop
