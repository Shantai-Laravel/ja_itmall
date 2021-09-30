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
                        <h5>{{ trans('vars.Cabinet.personalData') }}</h5>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="cabinetNavBloc">
                            <div class="cabNavTitle">
                                {{ trans('vars.General.hello') }}, {{ $userdata->name }}
                            </div>
                            <div id="selectCabinet" class="selectOption">
                              {{ trans('vars.Cabinet.personalData') }} <span></span>
                            </div>
                            @include('front.account.accountMenu')
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-7">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="invalid-feedback text-center">
                                  {!!$error!!}
                                </div>
                            @endforeach
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <div class="displayInline row justify-content-between align-items-center">
                            <div class="col-md-auto bloc marginTop">
                                <div>{{ $userdata->name }} {{ $userdata->surname }}</div>
                            </div>
                            <div class="col-md-auto buttAbsolute">
                                <div class="butt " data-toggle="modal" data-target="#userData">
                                    {{ trans('vars.General.modify') }}
                                </div>
                            </div>
                        </div>
                        <div class="displayInline row justify-content-between align-items-center">
                            <div class="col-md-auto bloc">
                                <div>{{ $userdata->email }}</div>
                            </div>
                        </div>
                        <div class="displayInline  row justify-content-between align-items-center">
                            <div class="col-md-auto bloc">
                                <div>{{ $userdata->code }} {{ $userdata->phone }}</div>
                            </div>
                        </div>
                        <div class="row displayInlineLast justify-content-between align-items-center">
                            <div class="col-md-auto bloc">
                                <div>{{ trans('vars.FormFields.pass') }}</div>
                                <div>*********</div>
                            </div>
                            <div class="col-md-auto">
                                <div class="butt" data-toggle="modal" data-target="#changePasswords">
                                    {{ trans('vars.General.modify') }}
                                </div>
                            </div>
                        </div>

                        <div class="textLight">{{ trans('vars.Shipping.shippingAdress') }}</div>

                        <div class="row justify-content-end">
                            @if ($userdata->address)
                                <div class="col-12">
                                    <div class="row justify-content-between adressBloc">
                                        <div class="col-lg-6 col-md-12">
                                            @if (!is_null($userdata->address->getCountryById))
                                                <p>{{ $userdata->address->getCountryById->name }},</p>
                                            @endif

                                            @if ($userdata->address->region)
                                                <p>{{ $userdata->address->region }},</p>
                                            @endif

                                            @if ($userdata->address->location)
                                                <p>{{ $userdata->address->location }},</p>
                                            @endif

                                            @if ($userdata->address->address)
                                                <p>{{ $userdata->address->address }}
                                                @if ($userdata->address->homenumber)
                                                    {{ $userdata->address->homenumber }}
                                                @endif
                                                </p>
                                            @endif

                                            @if ($userdata->address->code)
                                                <p>{{ $userdata->address->code }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-auto buttGroup">
                                            <div class="butt" data-toggle="modal" data-target="#changeAddress">{{ trans('vars.General.modify') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-auto ">
                                    <div class="butt buttLarge" data-toggle="modal" data-target="#addAddress">{{ trans('vars.General.modifyAddress') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modals">

    {{-- Modals --}}
    <div class="modal" id="userData">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody" action="{{ url('/'.$lang->lang.'/account/savePersonalData') }}" method="post">
                    {{ csrf_field() }}
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="modalHeader">
                        <span>{{ trans('vars.Cabinet.personalData') }}</span>
                    </div>

                    <div class="col-md-12 registerBloc">
                        <input type="text" placeholder="Name" name="name" required value="{{ $userdata->name }}"/>
                        <input type="email" placeholder="Email" name="email" required value="{{ $userdata->email }}"/>
                        <div class="telefonGroup">
                            <select name="code" class="js-example-basic-single">
                                @foreach ($countries as $key => $countryItem)
                                    @if ($userdata->code)
                                        <option value="{{ $countryItem->phone_code }}" data-image="/images/flags/16x16/{{ $countryItem->flag }}"  {{ $userdata->code == $countryItem->phone_code ? 'selected' : ''}}>
                                            +{{ $countryItem->phone_code }}
                                        </option>
                                    @else
                                        <option value="{{ $countryItem->phone_code }}" data-image="/images/flags/16x16/{{ $countryItem->flag }}"  {{ $country->id == $countryItem->id ? 'selected' : ''}}>
                                            +{{ $countryItem->phone_code }}
                                        </option>
                                    @endif

                                @endforeach
                            </select>
                            <input type="number" placeholder="{{ trans('vars.FormFields.fieldphone') }}" name="phone" required value="{{ $userdata->phone }}"/>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="butt buttView" value="{{ trans('vars.FormFields.save') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="changePasswords">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody" action="{{ url('/'.$lang->lang.'/account/changePass') }}" method="post">
                    {{ csrf_field() }}
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="modalHeader">
                        <span>{{ trans('vars.General.modifyPassword') }}</span>
                    </div>
                    <div class="col-md-12">
                        {{-- <input type="password" placeholder="old password" name="oldpass" required/> --}}
                        <input type="password" placeholder="{{ trans('vars.FormFields.passNew') }}" name="newpass" required/>
                        <input type="password" placeholder="{{ trans('vars.FormFields.passRepeat') }}" name="repeatnewpass" required/>
                    </div>
                    <div class="col-12">
                        <input type="submit" class="butt buttView" value="{{ trans('vars.FormFields.save') }}" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (!is_null($userdata->address))
        <div class="modal" id="changeAddress">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="row modalBody" action="{{ url('/'.$lang->lang.'/account/saveAddress/'.$userdata->address->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="closeModal" data-dismiss="modal"></div>
                        <div class="modalHeader">
                            <span>{{ trans('vars.General.modifyAddress') }}</span>
                        </div>
                        <div class="col-md-12">
                            <select name="country_id" class="js-example-basic-single">
                                @foreach ($countries as $key => $countryItem)
                                    @if ($userdata->address)
                                        <option value="{{ $countryItem->id }}" data-image="/images/flags/16x16/{{ $countryItem->flag }}"  {{ $countryItem->id == $userdata->address->country ? 'selected' : '' }}>
                                            {{ $countryItem->name }}
                                        </option>
                                    @else
                                        <option value="{{ $countryItem->id }}" data-image="/images/flags/16x16/{{ $countryItem->flag }}"  {{ $country->id == $countryItem->id ? 'selected' : ''}}>
                                            {{ $countryItem->name }}
                                        </option>
                                    @endif

                                @endforeach
                            </select>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldFullRegion') }}" name="region" value="{{ $userdata->address->region }}" required/>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldCity') }}" name="city" value="{{ $userdata->address->location }}" required/>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldStreet') }}" name="address" value="{{ $userdata->address->address }}" required/>
                            <input type="number" placeholder="{{ trans('vars.FormFields.homeNumberField') }}" name="homenumber" value="{{ $userdata->address->homenumber }}"/>
                            <input type="number" placeholder="{{ trans('vars.FormFields.fieldPostcode') }}" name="code" value="{{ $userdata->address->code }}" required/>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="butt buttView" value="{{ trans('vars.FormFields.save') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="modal" id="addAddress">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="row modalBody" action="{{ url('/'.$lang->lang.'/account/addAddress/') }}" method="post">
                        {{ csrf_field() }}
                        <div class="closeModal" data-dismiss="modal"></div>
                        <div class="modalHeader">
                            <span>{{ trans('vars.General.modifyAddress') }}</span>
                        </div>
                        <div class="col-md-12">
                            <select class="" name="country_id">
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country->id }}" {{ $country->id == $_COOKIE['country_id'] ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select> <br>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldFullRegion') }}" name="region" value="" required/>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldCity') }}" name="city" value="" required/>
                            <input type="text" placeholder="{{ trans('vars.FormFields.fieldStreet') }}" name="address" value="" required/>
                            <input type="number" placeholder="{{ trans('vars.FormFields.homeNumberField') }}" name="homenumber" value=""/>
                            <input type="number" placeholder="{{ trans('vars.FormFields.fieldPostcode') }}" name="code" value="" required/>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="butt buttView" value="{{ trans('vars.FormFields.save') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

    @include('front.partials.footer')
@stop
