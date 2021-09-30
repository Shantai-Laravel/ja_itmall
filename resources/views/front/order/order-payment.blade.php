@extends('front.app')
@section('content')
    <div class="fullWidthHeader">
        @include('front.partials.header')
    </div>

    <main>

       <div class="cartContent cartContentOrder">
         <div class="container">
                <h3>{{ trans('vars.Orders.orderAdminSubject') }}</h3>
                <div class="row deliveryCart">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea1') }}</div>
                            <p>{{ trans('vars.General.textArea1') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea2') }}</div>
                            <p>{{ trans('vars.General.textArea2') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea3') }}</div>
                            <p>{{ trans('vars.General.textArea3') }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="deliveryItem">
                            <div class="deliveryTitle">{{ trans('vars.General.titleArea4') }}</div>
                            <p>{{ trans('vars.General.textArea4') }}</p>
                        </div>
                    </div>
                </div>

                <order-payment  :items="{{ $cartProducts }}"
                        :countrydelivery="{{ @$_COOKIE['country_delivery_id'] }}"
                        :delivery="{{ @$_COOKIE['delivery_id'] }}"
                        :mode="'{{ Auth::guard('persons')->user() ? "auth" : "guest" }}'"
                        :order_id="{{ $order->id }}"
                ></order-payment>

                <div class="footerOrder">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="title">
                          {{ trans('vars.Contacts.needHelp') }}
                      </div>
                      <p>
                          {{ trans('vars.Contacts.contactUsBy') }} <a href="{{ url('/'.$lang->lang.'/contacts') }}">{{ trans('vars.Contacts.contactsTitle') }}</a>. {{ trans('vars.Contacts.readMore') }} <a href="{{ url('/'.$lang->lang.'/livrare-achitare-retur') }}">{{ trans('vars.Contacts.here') }}</a>
                      </p>
                      <div class="title">
                          {{ trans('vars.Orders.billingDescriptor') }}
                      </div>
                      <p>
                          {{ trans('vars.Orders.billingDescriptorText1') }}
                      </p>
                      <div class="title">
                          {{ trans('vars.Contacts.queriesPaymentShippingReturnsCompany') }}
                      </div>
                      <p>
                          {{ trans('vars.Contacts.queriesPaymentShippingReturnsAddress') }}
                      </p>
                    </div>
                  </div>
                </div>
            </div>
        </div>

        {{-- <div id="paypal-button"></div> --}}

    </main>

@stop
