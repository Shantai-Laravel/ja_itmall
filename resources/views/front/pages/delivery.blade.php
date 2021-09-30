@extends('front.app')
@section('content')
<div id="cover">
    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>
    <main>
        <div class="productsPageContent">
            <div class="productsPageHeader">
                <div class="headerText text-center">
                    <div><span>{{ $page->translation->title }}</span></div>
                </div>
            </div>
            <div class="editorPage">
                {!! $page->translation->body !!}
            </div>
        </div>
    </main>
    @include('front.partials.footer')
</div>
@stop
