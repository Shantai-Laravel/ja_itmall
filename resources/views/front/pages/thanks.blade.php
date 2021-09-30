@extends('front.app')
@section('content')
<div class="fullWidthHeader">
    @include('front.partials.header')
</div>
<main>
    <div class="cartContent thanks">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-md-6">
                  @if (!is_null($user))
                      <h4>{{ trans('vars.PagesThankYou.thankMessage') }} {{ $user->name }}!</h4>
                  @endif
                  @if (!is_null($order))


                @if ($order->fbq === 0)
                    <div id="_purchase" data="{{ $order->amount }}"></div>
                @endif

                  <h5>{{ trans('vars.PagesThankYou.ourOrder') }}:</h5>
                  <div class="productsInCart">

                      @if ($order->orderSubproducts()->count() > 0)
                          @foreach ($order->orderSubproducts as $key => $subproduct)
                              @if (!is_null($subproduct->subproduct->product))
                                  <div class="itemCart">
                                      <div class="descrBloc">
                                          <a href="{{ url('/'.$lang->lang.'/catalog/'.$subproduct->subproduct->product->category->alias.'/'.$subproduct->subproduct->product->alias) }}">
                                          @if ($subproduct->subproduct->product->mainImage)
                                          <img src="/images/products/og/{{ $subproduct->subproduct->product->mainImage->src }}" alt="" />
                                          @else
                                          <img src="" alt="" />
                                          @endif
                                          </a>
                                          <div>
                                              <div class="name">{{ $subproduct->subproduct->product->translation->name }}</div>
                                              <div class="size">
                                                  <span>{{ trans('vars.DetailsProductSet.size') }}: <b>{{ $subproduct->subproduct->parameterValue->translation->name }}</b></span>
                                                  <span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $subproduct->qty }}</span>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="priceBloc">
                                          <div>
                                              @if ($subproduct->subproduct->product->mainPrice)
                                              {{ $subproduct->subproduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}
                                              @endif
                                          </div>
                                          <div></div>
                                      </div>
                                  </div>
                              @else
                                  <div class="row productsCommands align-items-center justify-content-between">
                                      <p class="alert alert-danger">Product was deleted!</p>
                                  </div>
                              @endif
                          @endforeach

                      @foreach ($order->orderSets as $key => $set)
                      @if (!is_null($set->set))
                          <div class="itemCart cartSet">
                              <div class="descrBloc">
                                  <a href="{{ url('/'.$lang->lang.'/collection/'.$set->set->collection->alias.'?order'.$set->set->id) }}">
                                      @if ($set->set->mainPhoto)
                                          <img src="/images/sets/og/{{ $set->set->mainPhoto->src }}" alt="" />
                                      @else
                                          <img src="" alt="" />
                                      @endif
                                  </a>
                                  <div>
                                      <div class="name">{{ $set->set->translation->name }} ({{ trans('vars.DetailsProductSet.setOneHint') }})</div>
                                      <div class="size"><span>{{ trans('vars.DetailsProductSet.qty') }}: {{ $set->qty }}</span></div>
                                      {{-- <div class="functionalOptions">
                                          <div class="edit">Vezi produsele din set</div>
                                          <div class="optionsOpen">
                                              <div class="itemCart">
                                                  <div class="descrBloc">
                                                      <a href="oneProductPage.html">
                                                          <img src="/fronts/img/product.jpg" alt="" />
                                                      </a>
                                                      <div>
                                                          <div class="name">Fusta Cleo </div>
                                                      </div>
                                                  </div>
                                                  <div class="priceBloc">
                                                      <div>800 eur</div>
                                                      <div>900 eur</div>
                                                  </div>
                                              </div>
                                              <div class="itemCart">
                                                  <div class="descrBloc">
                                                      <a href="oneProductPage.html">
                                                          <img src="/fronts/img/product.jpg" alt="" />
                                                      </a>
                                                      <div>
                                                          <div class="name">Fusta Cleo </div>
                                                      </div>
                                                  </div>
                                                  <div class="priceBloc">
                                                      <div>800 eur</div>
                                                      <div>900 eur</div>
                                                  </div>
                                              </div>
                                              <div class="saveupdateBloc">
                                                  <div class="butt cancel">close</div>
                                              </div>
                                          </div>
                                      </div> --}}
                                  </div>
                              </div>
                              <div class="priceBloc">
                                  <div>
                                      @if ($set->set->mainPrice)
                                          {{ $set->set->mainPrice->price }} {{ $mainCurrency->abbr }}
                                      @endif
                                  </div>
                                  <div></div>
                              </div>
                          </div>
                          @else
                              <div class="row productsCommands align-items-center justify-content-between">
                                  <p class="alert alert-danger">Product was deleted!</p>
                              </div>
                          @endif
                      @endforeach
                      @endif

                  </div>
              @endif

                  <div class="thanksBloc">
                      {{-- @if (!Auth::guard('persons')->guest()) --}}
                      <div class="buttFour">
                          {{-- <h5>{{ trans('vars.PagesThankYou.row1') }}:</h5> --}}
                          {{-- <p>{{ trans('vars.PagesThankYou.row2') }}: <a href="{{ url('/'.$lang->lang.'/account/personal-data') }}">https://juliaallert.md/ro/login</a> </p> --}}
                      </div>
                      {{-- @endif --}}
                  </div>
                  <div class="thanksBloc">
                      <h5>{{ trans('vars.PagesThankYou.giftTitle') }}</h5>
                        @if(!is_null($promocode))
                        <p>
                            {{ trans('vars.PagesThankYou.EnterPromocode') }} {{ $promocode->name }}
                            {{ trans('vars.PagesThankYou.whenYouMake') }} {{ $promocode->treshold }}
                            {{ trans('vars.PagesThankYou.euroOrMore') }} {{ date("j F Y", strtotime($promocode->valid_to)) }}
                            {{ trans('vars.PagesThankYou.andEnjoy') }} {{ $promocode->discount }}
                            {{ trans('vars.PagesThankYou.off') }}
                        </p>
                        @endif

                      {{-- <p>{!! trans('front.thanks.pro÷ocode', ["name" => ' <span data-toggle="popover"  title="" data-placement="top" data-content="Copyied!" id="promoThanks"> '.$promocode->name.' </span>' , "treshold" => $promocode->treshold, "date" => date("j F Y", strtotime($promocode->valid_to)), "discount" => $promocode->discount]) !!}</p> --}}
                      <div class="buttFour">

                          <h5>{{ trans('vars.PagesThankYou.continueShopping') }}</h5>

                          @if (!Auth::guard('persons')->user())
                              <p>
                                  {{ trans('vars.PagesThankYou.row3') }}:
                              </p>
                          @endif

                          <div class="groupButtons">
                              @if (!Auth::guard('persons')->guest())
                                  <a href="{{ url('/'.$lang->lang.'/account/history') }}" class="butt">{{ trans('vars.PagesThankYou.row4') }}</a>
                              @endif
                              <a class="butt" href="{{ '/' . $lang->lang. '/sale' }}">{{ trans('vars.PagesThankYou.row5') }}</a>
                              <a class="butt" href="{{ '/' . $lang->lang. '/new' }}">{{ trans('vars.PagesNames.pageNameNewTitle') }}</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
</main>
@include('front.partials.footer')
@stop
