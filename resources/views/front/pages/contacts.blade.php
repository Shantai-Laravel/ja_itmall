@extends('front.app')
@section('content')
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
            <div class="container">
                <div class="row contact">
                    <div class="col-md-6 col-12">

                        <div class="contactBloc">
                            <div class="title">
                                {{ trans('vars.Contacts.queriesPaymentShippingReturnsTitle') }}
                            </div>
                            <p>{{ trans('vars.Contacts.queriesPaymentShippingReturnsSubTitle') }}</p>
                            <ul>
                                <li class="inactive" style="margin-bottom: 10px;">
                                    {{ trans('vars.Contacts.queriesPaymentShippingReturnsCompany') }}
                                </li>
                                <li class="inactive">
                                    <a href="#" class="location">
                                        {{ trans('vars.Contacts.queriesPaymentShippingReturnsAddress') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="tel:+{{ trans('vars.Contacts.queriesPaymentShippingReturnsPhone') }}" class="phone">{{ trans('vars.Contacts.queriesPaymentShippingReturnsPhone') }}</a>
                                </li>
                                <li>
                                    <a href="mailto:juliaallertmarketing@gmail.com" class="aron">{{ trans('vars.Contacts.queriesPaymentShippingReturnsEmail') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="contactBloc">
                            <div class="title">
                                {{ trans('vars.Contacts.queriesProductsDetailsTitle') }}
                            </div>
                            <ul>
                                <li>
                                    <a href="tel:{{ trans('vars.Contacts.phoneNumber') }}" class="phone">{{ trans('vars.Contacts.phoneNumber') }}</a>
                                </li>
                                <li>
                                    <a href="mailto:juliaallertmarketing@gmail.com" class="aron">juliaallertmarketing@gmail.com</a>
                                </li>
                                <li>
                                    <a href="#" class="location">{{ trans('vars.Contacts.addressSiteMain') }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div class="contactBloc">
                            <div class="title">
                                {{ trans('vars.Contacts.address') }}
                            </div>
                            <ul>
                                <li class="inactive">
                                    <a href="#" class="location">{{ trans('vars.Contacts.addressSiteMain') }}</a>
                                </li>
                            </ul>
                        </div> -->
                        <div class="contactBloc">
                            <div class="title">
                                {{ trans('vars.Contacts.schedule') }}
                            </div>
                            <ul>
                                <li class="inactive">
                                    <a href="#" class="calendar">{{ trans('vars.Contacts.scheduleInfo') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="contactBloc">
                            <div class="title">
                                {{ trans('vars.Contacts.socialMedia') }}
                            </div>
                            <ul>
                                <li>
                                    <a href="https://www.instagram.com/julia_allert_brand/?igshid=zdjmycaaxdfu" target="_blank" class="facebook">https://www.instagram.com/allertfashion/</a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/allertfashion/" target="_blank" class="instagram">https://www.facebook.com/allertfashion/</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <img src="/fronts/img/icons/imgContact.png" alt="">
                    </div>
                    <div class="col-md-10">
                        <form class="" action="{{ url('/'.$lang->lang.'/contact-feed-back') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-12 title">
                                    {{ trans('vars.Contacts.getInTouch') }}
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans('vars.FormFields.fieldFullName') }}<b>*</b> </label>
                                    <input type="text" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="">{{ trans('vars.FormFields.fieldEmail') }}<b>*</b> </label>
                                    <input type="email" name="email" required>
                                </div>
                                <div class="col-12">
                                    <label for="">{{ trans('vars.FormFields.needToKnow') }}</label>
                                    <textarea name="message" rows="8" cols="80" required></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="checkContainer">
                                        {{ trans('vars.FormFields.termsUserAgreementPersonalData3') }}
                                        <a href="{{ url('/'.$lang->lang.'/terms') }}" target="_blank"> {{ trans('vars.PagesNames.pageNameTermsConditions') }}</a>
                                        <input type="checkbox" required/>
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col-12">
                                    <input type="submit" value="{{ trans('vars.FormFields.send') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('front.partials.footer')
@stop
