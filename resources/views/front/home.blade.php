@extends('front.app')
@section('content')
<div class="homeHeaderRet">
  @include('front.partials.header')
</div>

<main>
    <div class="homeContent">
        <div class="homeLeft">
            <ul class="socialNetworks">
                <li class="f"><a href="{{ trans('vars.Contacts.facebook') }}" target="_blank"></a></li>
                <li class="i"><a href="{{ trans('vars.Contacts.instagram') }}" target="_blank"></a></li>
                <li class="p"><a href="{{ trans('vars.Contacts.printerest') }}" target="_blank"></a></li>
                <li class="in"><a href="{{ trans('vars.Contacts.linkedin') }}" target="_blank"></a></li>
                <li class="t"><a href="{{ trans('vars.Contacts.twitter') }}" target="_blank"></a></li>
                <li class="y"><a href="{{ trans('vars.Contacts.youtube') }}" target="_blank"></a></li>
            </ul>
            <div class="imgBloc">
                <img src="/fronts/img/icons/breaking.png" alt="" />
                <div class="butts">
                    <div class="">
                      <a href="{{ url('/'.$lang->lang.'/sale') }}" class="butt buttBanner">{{ trans('vars.PagesNames.pageNameOutletTitle') }}</a>
                    </div>
                    <div class="">
                      <a href="{{ url('/'. $lang->lang . '/new') }}" class="butt buttBanner">{{ trans('vars.PagesNames.pageNameNewTitle') }}</a>
                    </div>
                </div>
                <div class="deliveryBloc">
                    <a href="{{ url('/'.$lang->lang.'/catalog/outwear') }}" class="item">
                        <img src="/fronts/img/banner13.jpg" alt="">
                        <div class="buttBloc">
                         <div class="butt"><span>{{ trans('vars.PagesNames.pageNameOutwears') }}</span></div>
                        </div>
                    </a>
                    <a href="{{ url('/'.$lang->lang.'/catalog/dresses') }}" class="item">
                        <img src="/fronts/img/banner23.jpg" alt="">
                        <div class="buttBloc">
                         <div  class="butt"><span>{{ trans('vars.PagesNames.pageNameDresses') }}</span></div>
                        </div>
                    </a>
                </div>
                <div class="deliveryBloc">
                    <a href="{{ url('/'.$lang->lang.'/catalog/cardigans-jackets') }}" class="item">
                        <img src="/fronts/img/blazere3.jpg" alt="">
                        <div class="buttBloc">
                         <div class="butt"><span>{{ trans('vars.PagesNames.pageNameCardigans') }}</span></div>
                        </div>
                    </a>
                    <a href="{{ url('/'.$lang->lang.'/catalog/skirts') }}" class="item">
                        <img src="/fronts/img/fuste2.jpg" alt="">
                        <div class="buttBloc">
                         <div  class="butt"><span>{{ trans('vars.PagesNames.pageNameSkirts') }}</span></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="slideHome">
            @if (count($sets) > 0)
                @foreach ($sets as $key => $set)
                    @if ((!is_null($set->mainPhoto()->first())) || (!is_null($set->collection())))
                    <div class="item">
                        <a href="{{ url('/'.$lang->lang.'/collection/'.$set->collection()->first()->alias.'?order='.$set->id) }}">
                            @if (isMobile())
                                <img src="/images/sets/sm/{{ $set->mainPhoto()->first()->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
                            @else
                                <img src="/images/sets/md/{{ $set->mainPhoto()->first()->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
                            @endif
                        </a>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>
        <div class="buttsMobile">
          <div class="butts">
              <div class="">
                <a href="{{ url('/'.$lang->lang.'/sale') }}" class="butt buttBanner2">{{ trans('vars.PagesNames.pageNameOutletTitle') }}</a>
              </div>
              <div class="">
                <a href="{{ url('/'. $lang->lang . '/new') }}" class="butt buttBanner2">{{ trans('vars.PagesNames.pageNameNewTitle') }}</a>
              </div>
          </div>
        </div>
    </div>
</main>

@include('front.partials.footer')
@stop
