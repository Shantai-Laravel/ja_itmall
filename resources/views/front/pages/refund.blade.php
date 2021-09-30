@extends('front.app')
@section('content')
<div id="cover">
    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>
    <main>
        <div class="contactPageContent">
            <ul class="crumbs">
                <li>
                    <a href="{{ url('/'.$lang->lang) }}">Home</a>
                </li>
                <li>
                    <a href="#">{{ $page->translation->title }}</a>
                </li>
            </ul>
            <div class="productsPageHeader">
                <div class="headerText text-center">
                    <div><span>{{ $page->translation->title }}</span></div>
                </div>
            </div>
            <div class="container editorPage">
                {!! $page->translation->body !!}
            </div>
        </div>
    </main>
    @include('front.partials.footer')
</div>
@stop
