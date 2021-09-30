{{-- @extends('front.app')
@section('content')
<div id="cover">
    @include('front.partials.header')
    <main>
        <div class="bcgProduct">
            <div class="oneProduct oneSet setBcgTwo">
                <div class="container">
                    <div class="row">
                        <div class="col-12 crumbs">
                            <a href="{{ url('/'.$lang->lang) }}">Home</a>
                            <a href="{{ url('/'.$lang->lang) }}">Ideea Shop</a>
                            <a href="{{ url('/'.$lang->lang.'/collection/'.$collection->alias) }}">{{ $collection->translation->name }}</a>
                            <a href="#">{{ $set->translation->name }}</a>
                        </div>
                    </div>
                    <div class="row justify-content-center productBloc setBloc">
                        <div class="col-md-8">
                            <div class="slideOne">
                                @if (count($set->photos) > 0)
                                @foreach ($set->photos as $key => $photo)
                                <img src="/images/sets/og/{{ $photo->src }}" alt="" />
                                @endforeach
                                @else
                                <img src="{{ asset('fronts/img/catOne.png') }}" alt="" />
                                @endif
                            </div>
                            <div class="slideOneNav">
                                @if (count($set->photos) > 0)
                                @foreach ($set->photos as $key => $photo)
                                <img src="/images/sets/og/{{ $photo->src }}" alt="" />
                                @endforeach
                                @else
                                <img src="{{ asset('fronts/img/catOne.png') }}" alt="" />
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 setBcg">
                            <div class="oneFunc">
                                <div class="nameProduct">
                                    {{ $set->translation->name }}
                                </div>
                                <div class="productDescr">
                                    <div>Cod Set</div>
                                    <div>{{ $set->code }}</div>
                                </div>
                                <div class="productDescr productDescrSet">
                                    @if (count($set->products) > 0)
                                    <div>Setul contine:</div>
                                    <ul>
                                        @foreach ($set->products as $key => $product)
                                        <li>{{ $product->translation->name }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <div class="row descrIcons justify-content-center">
                                    <div class="col-xl-4 col-lg-6 col-4">
                                        <img src="{{ asset('fronts/img/icons/track.png') }}" alt="" />
                                        <p>Livrare la tine acasa</p>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-4">
                                        <img src="{{ asset('fronts/img/icons/creativity.png') }}" alt="" />
                                        <p>Consilier desemnat</p>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-4">
                                        <img src="{{ asset('fronts/img/icons/builder.png') }}" alt="" />
                                        <p>Montaj profesionist</p>
                                    </div>
                                </div>
                                <div class="butt buttView" data-toggle="modal" data-target="#commandSet">Comanda</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="oneProduct oneSet">
                    <div class="row align-items-center oneProdParam">
                        <div class="container">
                            <div class="oneProduct oneSet">
                                <div class="row align-items-center ">
                                    <div class="col-md-12 oneProdDescr">
                                        <h4>Descriere</h4>
                                        <p>
                                            {!! $set->translation->description !!}
                                        </p>
                                    </div>

                                    <div class="col-12 ">
                                        @if ($set->products()->count() > 0)

                                        <h4>Components</h4>
                                        @foreach ($set->products as $key => $product)
                                            @if ($key % 2 == 0)

                                            <div class="row oneComponentSet">
                                                <div class="col-md-7">
                                                    <a href="{{ '/'. $lang->lang . '/catalog/' . $product->category->alias . '/' . $product->alias}}">
                                                        @if ($product->mainImage)
                                                            <img src="/images/products/og/{{ $product->mainImage->src }}" alt="">
                                                        @else
                                                            <img src="/images/noimage.jpg" alt="" />
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="oneFunc">
                                                        <a class="nameProduct" href="{{ '/'. $lang->lang . '/catalog/' . $product->category->alias . '/' . $product->alias}}">{{ $product->translation->name }}</a>
                                                        <div class="productDescr">
                                                            @if ($product->code)
                                                                <div>Cod Produs</div>
                                                                <div>{{ $product->code }}</div>
                                                            @endif
                                                        </div>
                                                        @if (count($product->propertyValues) >  0)
                                                            @foreach ($product->propertyValues as $key => $productValue)
                                                                @if (count($productValue->parametersMain) > 0)
                                                                    @if ($productValue->parameter->type == 'select' || $productValue->parameter->type == 'checkbox')
                                                                        @if (!is_null($productValue->value))
                                                                            <div class="productDescr">
                                                                                <div>{{ $productValue->parameter->translation->name }}</div>
                                                                                <div>{{ $productValue->value->translation->name }}</div>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        @if ($productValue->translation->value !== null)
                                                                            <div class="productDescr">
                                                                                <div>{{ $productValue->parameter->translation->name }}</div>
                                                                                <div>{{ $productValue->translation->value }}</div>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            <div class="row oneComponentSet">
                                                <div class="col-md-5">
                                                    <div class="oneFunc">
                                                        <a class="nameProduct" href="{{ '/'. $lang->lang . '/catalog/' . $product->category->alias . '/' . $product->alias}}">{{ $product->translation->name }}</a>
                                                        <div class="productDescr">
                                                            @if ($product->code)
                                                                <div>Cod Produs</div>
                                                                <div>{{ $product->code }}</div>
                                                            @endif
                                                        </div>
                                                        @if (count($product->propertyValues) >  0)
                                                            @foreach ($product->propertyValues as $key => $productValue)
                                                                @if (count($productValue->parametersMain) > 0)
                                                                    @if ($productValue->parameter->type == 'select' || $productValue->parameter->type == 'checkbox')
                                                                        @if (!is_null($productValue->value))
                                                                            <div class="productDescr">
                                                                                <div>{{ $productValue->parameter->translation->name }}</div>
                                                                                <div>{{ $productValue->value->translation->name }}</div>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        @if ($productValue->translation->value !== null)
                                                                            <div class="productDescr">
                                                                                <div>{{ $productValue->parameter->translation->name }}</div>
                                                                                <div>{{ $productValue->translation->value }}</div>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <a href="{{ '/'. $lang->lang . '/catalog/' . $product->category->alias . '/' . $product->alias}}">
                                                        @if ($product->mainImage)
                                                            <img src="/images/products/og/{{ $product->mainImage->src }}" alt="">
                                                        @else
                                                            <img src="/images/noimage.jpg" alt="" />
                                                        @endif
                                                    </a>
                                                </div>
                                            </div>
                                            @endif

                                        @endforeach

                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 oneProdDescr"></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="similarProducts similarSets">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (count($similarSets) > 0)
                        <div class="title">Alte recomandari pentru tine</div>
                        <div class="slideSimilarProducts">
                            @foreach ($similarSets as $key => $similarSet)
                            <div class="filterItem setItem">
                                <div class="buttWishProduct"></div>
                                <a href="{{ url($lang->lang.'/collection/'.$similarSet->collection->alias.'/'.$similarSet->alias) }}">
                                    <img src="{{ asset('fronts/img/catOne.png') }}" alt="" />
                                    <aside>
                                        <div class="nameProduct">{{ $similarSet->translation->name }}</div>
                                        <div class="components">
                                            @if (count($similarSet->products) > 0)
                                            @foreach ($similarSet->products as $key => $product)
                                            <span> {{ $product->translation->name }} </span>
                                            @endforeach
                                            @endif
                                        </div>
                                    </aside>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modals">
        <div class="modal" id="commandSet">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form class="row modalBody" method="post" action="{{ url($lang->lang.'/set/pre-order') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="set_id" value="{{ $set->id }}">
                        <div class="closeModal" data-dismiss="modal"></div>
                        <div class="title col-12">precomanda</div>
                        <div class="col-md-6">
                            <p>Детали уточняются по телефону. Отправте свои данные для предзаказа и мы вам перезвоним.</p>
                            <div class="item">
                                @if (!is_null($set->mainPhoto))
                                <img src="/images/sets/og/{{ $set->mainPhoto->src }}" alt="">
                                @else
                                <img src="{{ asset('/fronts/img/catOne.png') }}" alt="">
                                @endif
                                <div class="nameProduct">{{ $set->translation->name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if (count($set->products) > 0)
                            <p>Выберите необходимые компоненты:</p>
                            @foreach ($set->products as $key => $product)
                            <label class="containerFilter">{{ $product->translation->name }}
                            <input type="checkbox" checked name="product[{{ $product->id }}]" value="{{ $product->id }}"/>
                            <span class="checkmark"></span>
                            </label>
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-12">
                            <div class="groupButtons">
                                <input type="text" name="name" placeholder="Nume si prenume" required>
                                <div class="telefonGroup">
                                    <input type="text" name="phone" placeholder="Telefon" required>
                                </div>
                            </div>
                            <input type="text" name="email" placeholder="Email (optional)">
                        </div>
                        <div class="col-md-6 containerFooter">
                            <small class="text-danger text-center validate-terms">acest camp trebuie sa fie bifat</small>
                            <label class="containerFilter">Sunt de acord cu procesarea datelor personale
                            <input type="checkbox" required class="terms-checkbox"/>
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" class="butt buttView submit-pre-order" value="trimite comanda">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('front.partials.footer')
</div>
@stop --}}
