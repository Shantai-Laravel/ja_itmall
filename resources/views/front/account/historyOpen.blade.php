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
                              Istoria comenzilor <span></span>
                            </div>
                            @include('front.account.accountMenu')
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 historyOne">
                        <div class="historyOneTitle">
                            {{ trans('vars.Cabinet.order') }}: <small>{{ $order->order_hash }}</small> <span class="delivered">{{ $order->main_status }}</span>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 bloc">
                                <div>{{ trans('vars.Cabinet.contactData') }}</div>
                                <div>{{ $order->details->contact_name }}</div>
                                <div>+{{ $order->details->code }} {{ $order->details->phone }}</div>
                                <div>{{ $order->details->email }}</div>
                            </div>
                            <div class="col-lg-4 col-md-12 bloc">
                                <div>{{ trans('vars.Cabinet.shipiingAddress') }}</div>
                                <div>
                                    {{ $order->details->country }},
                                    @if ($order->details->region)
                                        {{ $order->details->region }},
                                    @endif
                                    {{ $order->details->city }},
                                    {{ $order->details->address }},
                                    @if ($order->details->zip)
                                        {{ $order->details->zip }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 bloc">
                                <div>{{ trans('vars.Cabinet.shipping/payment') }}</div>
                                <div>{{ $order->details->delivery }}</div>
                                <div>{{ $order->details->payment }}</div>
                            </div>
                            <div class="col-lg-12 bloc">
                                {{-- {{ trans('vars.Cabinet.trackingNumber') }}: <a href="#">094340</a> --}}
                            </div>
                        </div>
                        <div class="historyOneTitle">
                            {{ trans('vars.Cabinet.orderStatus') }}
                        </div>
                        <div class="statusBloc">
                            <div class="emptyBox">
                                @php
                                    $status = 0;
                                    if ($order->main_status == 'pendding') { $status = 25; }
                                    if ($order->main_status == 'processing') { $status = 50; }
                                    if ($order->main_status == 'inway') { $status = 75; }
                                    if ($order->main_status == 'completed') { $status = 100; }
                                @endphp
                                <div class="fillBox fillBoxDelivering" style="width: {{ $status }}%;"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 bloc orderplaced {{ $order->main_status == 'pendding' ? 'active' : '' }}">
                                    <div></div>
                                    <div>{{ trans('vars.Cabinet.pendingOrder') }}</div>
                                </div>
                                <div class="col-lg-6 col-md-12 bloc orderprocessing {{ $order->main_status == 'processing' ? 'active' : '' }}">
                                    <div></div>
                                    <div>{{ trans('vars.Cabinet.processingOrder') }}</div>
                                </div>
                                <div class="col-lg-6 col-md-12 bloc orderdelivering {{ $order->main_status == 'inway' ? 'active' : '' }}">
                                    <div></div>
                                    <div>{{ trans('vars.Cabinet.inwayOrder') }}</div>
                                </div>
                                <div class="col-lg-6 col-md-12 bloc orderdelivered {{ $order->main_status == 'completed' ? 'active' : '' }}">
                                    <div></div>
                                    <div>{{ trans('vars.Cabinet.completedOrder') }}</div>
                                </div>
                            </div>
                        </div>

                        @if ($order->orderSubproducts()->count() > 0)

                            <div class="historyOneTitle marginBottom">
                                {{ trans('vars.Cabinet.ordered') }}
                            </div>

                            @foreach ($order->orderSubproducts as $key => $subproduct)
                                @if (!is_null($subproduct->subproduct->product))
                                <div class="row productsCommands align-items-center justify-content-between">
                                    <div class="col-md-7 col-7 d-flex align-items-center">
                                        @if ($subproduct->subproduct->product->mainImage)
                                            <img src="/images/products/og/{{ $subproduct->subproduct->product->mainImage->src }}" alt="" />
                                        @else
                                            <img src="" alt="" />
                                        @endif
                                        <a href="{{ url('/'.$lang->lang.'/catalog/'.$subproduct->subproduct->product->category->alias.'/'.$subproduct->subproduct->product->alias) }}" class="nameProduct">{{ $subproduct->subproduct->product->translation->name }}</a>
                                    </div>
                                    <div class="col-md-auto col-2">
                                        {{ $subproduct->qty }} {{ trans('vars.Cabinet.pieces') }}.
                                    </div>
                                    <div class="col-md-auto col-3">
                                        @if ($subproduct->subproduct->product->mainPrice)
                                            {{ $subproduct->subproduct->product->mainPrice->price }} {{ $mainCurrency->abbr }}
                                        @endif
                                    </div>
                                </div>
                                @else
                                    <div class="row productsCommands align-items-center justify-content-between">
                                        <p class="alert alert-danger">Product was deleted!</p>
                                    <div>
                                @endif

                            @endforeach

                            @foreach ($order->orderSets as $key => $set)
                                @if (!is_null($set->set))
                                <div class="row productsCommands align-items-center justify-content-between">
                                    <div class="col-md-7 col-7 d-flex align-items-center">
                                        @if ($set->set->mainPhoto)
                                            <img src="/images/sets/og/{{ $set->set->mainPhoto->src }}" alt="" />
                                        @else
                                            <img src="" alt="" />
                                        @endif
                                        <a href="{{ url('/'.$lang->lang.'/collection/'.$set->set->collection->alias.'?order'.$set->set->id) }}" class="nameProduct">
                                            {{ $set->set->translation->name }} ({{ trans('vars.DetailsProductSet.setOneHint') }})
                                        </a>
                                    </div>
                                    <div class="col-md-auto col-2">
                                        {{ $set->qty }}  {{ trans('vars.Cabinet.pieces') }}.
                                    </div>
                                    <div class="col-md-auto col-3">
                                        @if ($set->set->mainPrice)
                                            {{ $set->set->mainPrice->price }} {{ $mainCurrency->abbr }}
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="row productsCommands align-items-center justify-content-between">
                                    <p class="alert alert-danger">Product was deleted!</p>
                                <div>
                            @endif
                            @endforeach

                            <div class="total">
                                {{ trans('vars.Cabinet.amount') }}: {{ $order->amount }} {{ $mainCurrency->abbr }}
                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('front.partials.footer')
@stop
