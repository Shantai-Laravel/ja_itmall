<div class="modalRight">

    <div class="modal fade" id="terms">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    {{-- <span>Shipping, payment and returns</span> --}}
                </div>
                <div class="row">
                    <div class="col-12 editorPage">
                        @php $page = getPage('terms', $lang->id); @endphp
                        @if (!is_null($page))
                            {!! $page->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shipping">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    {{-- <span>Shipping, payment and returns</span> --}}
                </div>
                <div class="row">
                    <div class="col-12 editorPage">
                        @php $page = getPage('livrare-achitare-retur', $lang->id); @endphp
                        @if (!is_null($page))
                            {!! $page->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="returns">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    {{-- <span>Shipping, payment and returns</span> --}}
                </div>
                <div class="row">
                    <div class="col-12 editorPage">
                        @php $page = getPage('refund', $lang->id); @endphp
                        @if (!is_null($page))
                            {!! $page->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalShipping">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    <span>Shipping, payment and returns</span>
                </div>
                <div class="row">
                    <div class="col-12 editorPage">
                        @php $page = getPage('livrare-achitare-retur', $lang->id); @endphp
                        @if (!is_null($page))
                            {!! $page->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSize">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                  <span>Shipping, payment and returns</span>
                </div>
                <div class="row">
                    <div class="col-12 editorPage">
                        @php $page = getPage('size-guide', $lang->id); @endphp
                        @if (!is_null($page))
                            {!! $page->body !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelivery">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 editorPage">
                            @php $page = getPage('delivery', $lang->id); @endphp @if (!is_null($page)) {!! $page->body !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@if (!Auth::guard('persons')->user())
    <div class="modal fade" id="login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>

                @if (!is_null($unloggedUser))
                    <auth guest="{{ json_encode($unloggedUser) }}"></auth>
                @else
                    <auth guest="{{ null }}"></auth>
                @endif

            </div>
        </div>
    </div>

    {{-- Forget Password modal --}}
    <div class="modal fade" id="forgetPassword">
        <div class="modal-dialog">
            <div class="modal-content">
                <reset-password></reset-password>
            </div>
        </div>
    </div>
@endif


<div class="modal fade" id="settings">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="closeModal" data-dismiss="modal"></div>
            <div class="modalHeader">
                <span>{{ trans('vars.FormFields.settings') }}</span>
            </div>
            <div class="menuOpen">
                <form class="" action="{{ url('/'.$lang->lang.'/set-user-settings') }}" method="post">
                    {{ csrf_field() }}
                    <div class="settingsBloc">
                        <div>{{ trans('vars.FormFields.shipTo') }}</div>
                        <select name="country_id">
                            @foreach ($countries as $key => $oneCountry)
                                <option value="{{ $oneCountry->id }}" {{ $oneCountry->id == $country->id ? 'selected' : ''}}>{{ $oneCountry->translation->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="settingsBloc">
                        <div>{{ trans('vars.FormFields.currency') }}</div>
                        <select name="currency_id">
                            @foreach ($currencies as $key => $oneCurrency)
                                <option value="{{ $oneCurrency->id }}"  {{ $oneCurrency->id == $currency->id ? 'selected' : ''}}>{{ $oneCurrency->abbr }}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="settingsBloc">
                        <div>{{ trans('vars.FormFields.language') }}</div>
                        <select name="lang_id">
                            @foreach ($langs as $key => $language)
                                <option value="{{ $language->id }}" {{ $lang->id == $language->id ? 'selected' : '' }}>{{ $language->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="menuFooter">
                        <input type="submit" value="{{ trans('vars.FormFields.save') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@if (!Request::segment(2) && $notShippingCounrty))
    {{-- <div class="modal modalAlert hide" id="alert">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    <span>{{ trans('vars.Notifications.notification') }}</span>
                </div>
                <div class="menuOpen">
                    {{ trans('vars.Notifications.notShippingForYou') }}
                </div>
            </div>
        </div>
    </div> --}}
@endif

@if (Session::has('payError')))
    <div class="modal modalAlert fade" id="alert">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="closeModal" data-dismiss="modal"></div>
                <div class="modalHeader">
                    <span>{{ trans('vars.Notifications.notification') }}</span>
                </div>
                <div class="menuOpen">
                    {{ trans('vars.Notifications.paymentEror') }}
                </div>
            </div>
        </div>
    </div>
@endif
