@extends('front.app')
@section('content')
<div class="fullWidthHeader">
    @include('front.partials.header')
</div>
<main>
    <div class="setPageContent">
        <ul class="crumbs">
            <li>
                <a href="{{ url('/' . $lang->lang) }}">Home</a>
            </li>
            <li>
                <a href="{{ url('/' . $lang->lang . '/collection/' . $collection->alias) }}">{{ $collection->translation->name }}</a>
            </li>
        </ul>
        <div class="titleFixed">
          <span>{{ $collection->translation->name }}</span>
        </div>
        @if ($collection->sets()->count() > 0)
            @if (!is_null($mainSet))
                <section>
                    <div class="container">
                        <div class="row setBlock">
                            <div class="col-12 text-center">
                                <h3>{{ $mainSet->translation->name }}</h3>
                            </div>
                            <div class="col-lg-7 col-md-6 mainSlides">
                                <div class="slideNav">
                                    @if ($mainSet->photos()->count() > 0)
                                        @foreach ($mainSet->photos as $key => $photo)
                                            <div class="itemBox">
                                                <div class="itemNav">
                                                    <img src="/images/sets/sm/{{ $photo->src }}"/>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="slideSet">
                                    @if ($mainSet->photos()->count() > 0)
                                        @foreach ($mainSet->photos as $key => $photo)
                                            <div class="itemBox">
                                                <div class="item">
                                                    <img src="/images/sets/sm/{{ $photo->src }}" alt="{{ $mainSet->translation->name }}" />
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <set :set="{{ $mainSet }}"></set>
                        </div>
                    </div>
                </section>
            @endif

            @foreach ($collection->sets as $key => $set)
                @if ($set->id != Request::get('order'))
                    <section>
                        <div class="container">
                            <div class="row justify-content-center setBlock">
                                <div class="col-12 text-center">
                                    <h3>{{ $set->translation->name }}</h3>
                                </div>
                                <div class="col-lg-7 col-md-6 mainSlides">
                                    <div class="slideNav">
                                        @if ($set->photos()->count() > 0)
                                            @foreach ($set->photos as $key => $photo)
                                                <div class="itemBox">
                                                    <div class="itemNav">
                                                        <img src="/images/sets/sm/{{ $photo->src }}"/>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="slideSet">
                                        @if ($set->photos()->count() > 0)
                                            @foreach ($set->photos as $key => $photo)
                                                <div class="itemBox">
                                                    <div class="item">
                                                        <img src="/images/sets/sm/{{ $photo->src }}" alt="{{ $set->translation->name }}" />
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <set :set="{{ $set }}"></set>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
        @endif
        <view-recently><view-recently/>
    </div>
</main>
@include('front.partials.footer')
@stop
