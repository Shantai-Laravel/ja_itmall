<div class="headerHome">
  <a href="{{ url('/'. $lang->lang) }}" id="copyLink" class="logo logoMobile"><img src="/fronts/img/icons/logo.svg" alt=""/></a>
    <header>
        <div class="headerBlock">
            <ul class="menuLeft">
              <!-- <li class="itemButt {{ Request::segment(2) == 'new' ? 'pageActive' : '' }}"><span><a href="{{ url('/'.$lang->lang.'/new') }}">{{ trans('vars.PagesNames.pageNameNewTitle') }}</a></span></li> -->

                <li class="itemButt {{ Request::segment(2) == 'catalog' ? 'pageActive' : '' }}">
                    <span>{{ trans('vars.PagesNames.pageNameProductsTitle') }}</span>
                    <ul class="subMenu">
                        <li class="menuBack"><span>{{ trans('vars.General.back') }}</span></li>
                        @if (count($categoriesMenu))
                            @foreach ($categoriesMenu as $key => $categoryItem)
                                @if (count($categoryItem->children()->get()) > 0)
                                    <li class="submenuButton">
                                        <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias) }}">
                                            {{ $categoryItem->translation($lang->id)->first()->name }}
                                        </a>
                                        <div class="submenu2">
                                            <ul>
                                                @foreach ($categoryItem->children()->get() as $key => $categoryItem2)
                                                    <li>
                                                        <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias.'/'.$categoryItem2->alias) }}">
                                                            {{ $categoryItem2->translation($lang->id)->first()->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias) }}"> {{ $categoryItem->translation($lang->id)->first()->name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li class="itemButt {{ Request::segment(2) == 'collection' ? 'pageActive' : '' }}">
                    <span>{{ trans('vars.PagesNames.pageNameCollections') }}</span>
                    <ul class="subMenu">
                        <li class="menuBack"><span>{{ trans('vars.General.back') }}</span></li>
                        @if (count($collectionsMenu))
                            @foreach ($collectionsMenu as $key => $collectionItem)
                                <li class="submenuButton">
                                    <a href="{{ url($lang->lang.'/collection/'.$collectionItem->alias) }}">
                                        {{ $collectionItem->translation($lang->id)->first()->name }}
                                    </a>
                                    @if ($collectionItem->sets()->count() > 0)
                                        <ul class="setList">
                                            <li class="menuBack"><span>{{ trans('vars.General.back') }}</span></li>
                                            @foreach ($collectionItem->sets as $key => $set)
                                                <li>
                                                    <a href="{{ url('/'.$lang->lang.'/collection/'.$collectionItem->alias.'?order='.$set->id) }}">{{ $set->translation->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                <li class="itemButt {{ Request::segment(2) == 'sale' ? 'pageActive' : '' }}"><span><a href="{{ url('/'.$lang->lang.'/sale') }}">{{ trans('vars.PagesNames.pageNameOutletTitle') }}</a></span></li>
                @php
                    $setting = getSettings();
                @endphp
                @if ($setting['promotions'] == 'active')
                    <li class="itemButt {{ Request::segment(2) == 'new' ? 'pageActive' : '' }}"><span><a href="{{ url('/'.$lang->lang.'/promotions') }}">{{ trans('vars.PagesNames.pagePromotions') }}</a></span></li>
                @else
                    <li class="itemButt"></li>
                @endif

                <li>
                    <span>
                       <a href="{{ url('/'.$lang->lang.'/about') }}" id="putLink" class="logo"><span>BRAND</span> <img src="/fronts/img/icons/logo.svg" alt=""/></a>
                    </span>
                </li>
                <li class="itemButt itemButtMobile"><span><a href="{{ url('/'.$lang->lang.'/livrare-achitare-retur') }}">{{ trans('vars.PagesNames.pageDelivery') }}</a></span></li>
                <!-- <li class="itemButt itemButtMobile"><span><a href="{{ url('/'.$lang->lang.'/about') }}">{{ trans('vars.PagesNames.pageAboutUs') }}</a></span></li> -->
                <li class="itemButt itemButtMobile"><span><a href="{{ url('/'.$lang->lang.'/contacts') }}">{{ trans('vars.PagesNames.pageNameContacts') }}</a></span></li>
                <ul class="socialNetworks socialNetworksMobile" >
                    <li class="f"><a href="{{ trans('vars.Contacts.facebook') }}" target="_blank"></a></li>
                    <li class="i"><a href="{{ trans('vars.Contacts.instagram') }}" target="_blank"></a></li>
                    <li class="p"><a href="{{ trans('vars.Contacts.printerest') }}" target="_blank"></a></li>
                    <li class="in"><a href="{{ trans('vars.Contacts.linkedin') }}" target="_blank"></a></li>
                    <li class="t"><a href="{{ trans('vars.Contacts.twitter') }}" target="_blank"></a></li>
                    <li class="y"><a href="{{ trans('vars.Contacts.youtube') }}" target="_blank"></a></li>
                </ul>
            </ul>
            <ul class="menuCabinet">
                <li class="buttMenu buttWish animated">
                    <wish-counter :items="{{ $wishProducts }}" :sets="{{ $wishSets }}"></wish-counter>
                </li>
                <li class="buttMenu buttCart animated">
                    <a href="{{ url('/' . $lang->lang . '/cart') }}">
                        <cart-counter :items="{{ $cartProducts }}"></cart-counter>
                    </a>
                </li>
                @if (Auth::guard('persons')->user())
                    <li class="buttMenu buttAvatar"><a href="{{ url('/'.$lang->lang.'/account/personal-data') }}"></a></li>
                @else
                    <li class="buttMenu buttAvatar" data-target="#login" data-toggle="modal"></li>
                @endif
                <li class="buttMenu buttSettings">
                    <a href="#" data-target="#settings" data-toggle="modal">
                        {{ $currency->abbr }} / {{ $lang->lang }} /<span class="flag" style="background-image: url(/images/flags/24x24/{{ $country->flag }})"></span>
                    </a>
                </li>
            </ul>
            <div id="burger" class="burger">
                <div class="iconBar"></div>
            </div>
        </div>
    </header>
</div>
