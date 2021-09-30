<template>
    <div class="row cartBloc" v-if="ready">
    <!-- <div class="col-12 text-center text-danger" v-if="notInStoc">
        {{ trans.front.cart.notInStock }}
    </div> -->
    <div class="col-12 text-center text-danger" v-if="serverError">
        <p class="text-center">A avut loc o problema tehnica.</p>
        <p class="text-center">Va sugeram sa reincarcati pagina</p>
        <a href="#" @click="refreshPage">Reincarca</a>
    </div>
    <div class="col-12 text-center" v-if="!cartProds.length &&  !cartSets.length">
        {{ trans.front.cart.empty }}
    </div>
    <div class="bagFromFirefox">
        <div class="productsInCart">
            <!-- Products -->
            <div :class="['itemCart', cartSubprod.stock_qty == 0 ? 'pasive' : '']" v-for="(cartSubprod, key) in cartSubprods">
                <div class="text-danger" v-if="cartSubprod.stock_qty == 0 ">
                    {{ trans.vars.Notifications.errorOutOfStockSingle }}
                </div>
                <div class="descrBloc">
                    <a :href="'/' + $lang + '/catalog/' + cartSubprod.subproduct.product.category.alias + '/' + cartSubprod.subproduct.product.alias">
                        <img :src="'/images/products/sm/' + cartSubprod.subproduct.product.main_image.src" alt="" v-if="cartSubprod.subproduct.product.main_image"/>
                        <img src="/images/noimage.jpg" alt="" v-else/>
                    </a>
                    <div>
                        <div class="name">{{ cartSubprod.subproduct.product.translation.name }}</div>
                        <div class="size">
                            <span>{{ trans.vars.DetailsProductSet.size }}: {{ cartSubprod.subproduct.parameter_value.translation.name }}</span>
                            <span>{{ trans.vars.DetailsProductSet.qty }}: {{ cartSubprod.qty }}</span>
                        </div>
                        <div class="functionalOptions">
                            <div class="edit" v-if="cartSubprod.stock_qty > 0">{{ trans.vars.Cart.edit }}</div>
                            <div class="saveForLater" @click="moveProductToWish(cartSubprod.id)">{{ trans.vars.Wishlist.wishMoveTo }}</div>
                            <div class="optionsOpen">
                                <select @change="changeProductQty" :name="cartSubprod.id">
                                    <option :value="key + 1" :selected="key + 1 == cartSubprod.qty" v-for="(stoc, key) in cartSubprod.stock_qty">{{ key + 1}}</option>
                                </select>
                                <div class="saveupdateBloc">
                                    <div class="butt cancel">{{ trans.vars.TehButtons.btnClose }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="priceBloc">
                    <div>{{ cartSubprod.subproduct.product.main_price.price * cartSubprod.qty }} {{ $mainCurrency }}</div>
                    <div>
                        <span v-if="cartSubprod.subproduct.product.main_price.price !== cartSubprod.subproduct.product.main_price.old_price">
                            {{ cartSubprod.subproduct.product.main_price.old_price * cartSubprod.qty }}
                            {{ $mainCurrency }}
                        </span>
                    </div>
                </div>
                <div class="delete" @click="removeProduct(cartSubprod.id, key)"></div>
            </div>
            <!-- Sets -->
            <div :class="['itemCart', 'cartSet', cartSet.stock_qty == 0 ? 'pasive' : '']" v-for="cartSet in cartSets">
                <div class="descrBloc">
                    <a :href="'/' + $lang + '/collection/' + cartSet.set.collection.alias + '?order=' + cartSet.set.id">
                        <img :src="'/images/sets/sm/' + cartSet.set.main_photo.src" v-if="cartSet.set.main_photo" />
                        <img src="/images/noimage.jpg" v-else />
                    </a>
                    <div>
                        <div class="name">{{ cartSet.set.translation.name }} {{ trans.vars.DetailsProductSet.setOneHint }}</div>
                        <div class="size"><span>{{ trans.vars.DetailsProductSet.qty }}: {{ cartSet.qty }}</span></div>
                        <div class="functionalOptions">
                            <div class="edit" v-if="cartSet.stock_qty > 0">{{ trans.vars.DetailsProductSet.viewItemsFromSet }}</div>
                            <div class="saveForLater" @click="moveSetToWish(cartSet.id)">{{ trans.vars.Wishlist.wishMoveTo }}</div>
                            <div class="optionsOpen">
                                <select @change="changeProductQty" :name="cartSet.id">
                                    <option :value="key + 1" :selected="key + 1 == cartSet.qty" v-for="(stoc, key) in cartSet.stock_qty">{{ key + 1}}</option>
                                </select>
                                <div class="itemCart" v-for="children in cartSet.children">
                                    <div class="descrBloc">
                                        <a :href="'/' + $lang + '/catalog/' + children.subproduct.product.category.alias + '/' + children.subproduct.product.alias">
                                            <img :src="'/images/products/sm/' + children.subproduct.product.main_image.src" v-if="children.subproduct.product.main_image" />
                                            <img src="/images/noimage.jpg" v-else />
                                        </a>
                                        <div>
                                            <div class="name">{{ children.subproduct.product.translation.name }}</div>
                                            <div class="size">
                                                <span>{{ trans.vars.DetailsProductSet.size }}: {{ children.subproduct.parameter_value.translation.name }}</span>
                                                <span>{{ trans.vars.DetailsProductSet.qty }}: 1</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="priceBloc">
                                        <div>{{ children.subproduct.product.main_price.price }} {{ $mainCurrency }}</div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="saveupdateBloc">
                                    <div class="butt cancel">{{ trans.vars.TehButtons.btnClose }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="priceBloc">
                    <div>{{ cartSet.set.main_price.price }} {{ $mainCurrency }}</div>
                    <div v-if="cartSet.set.discount">{{ cartSet.set.main_price.old_price }} {{ $mainCurrency }}</div>
                    <div v-else></div>
                </div>
                <div class="delete" @click="removeProduct(cartSet.id, key)"></div>
            </div>
        </div>
    </div>
    <!-- Summary -->
    <div class="parentThis" v-if="cartProds.length || cartSets.length">
        <div class="infoOrder" id="orderSummary">
            <div class="orderSummary">
                <div class="title">{{ trans.vars.Cart.orderSummary }}</div>
                <div class="bloc" v-if="mode != 'order-shipping' && mode != 'order-payment'">
                    <div>{{ trans.vars.Shipping.shipping }}:</div>
                    <div>
                        <select v-model="currentCountry" @change="changeCountry">
                            <option :value="country" v-for="country in countries">{{ country.translation.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="bloc" v-if="mode == 'order-shipping' && 'order-payment'">
                    <div>{{ trans.vars.Shipping.shipping }}:</div>
                    <span v-if="currentCountry.translation">{{ currentCountry.translation.name }}</span>
                </div>
                <div class="bloc" v-if="currentCountry.main_delivery">
                    <div>{{ trans.vars.Shipping.shipping }}:</div>
                    <div>
                        <select v-model="mainDelivery" @change="changeShippingMethod">
                            <option :value="delivery.delivery_id" :data-price="delivery.delivery.price" :data-time="delivery.delivery.delivery_time" v-for="delivery in currentCountry.deliveries">{{ delivery.delivery.translation.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="bloc" v-if="currentCountry.main_delivery">
                    <div>
                        {{ trans.vars.Shipping.shippingTime }}
                    </div>
                    <div>
                        {{ shippingTime }} {{ trans.vars.Shipping.days }}
                    </div>
                </div>
                <div class="bloc" v-else>
                    <div>{{ trans.vars.Shipping.shipping }}:</div>
                    <div>
                        no shipping for this country
                    </div>
                </div>
                <div class="promoCode">
                    <div>{{ trans.vars.Promocode.promocodeAdd }}</div>
                    <div class="bloc">
                        <input type="text" name="promocode" placeholder="" v-model="promocode" :class="[promocodeDetails.status == 'true' ? 'verified' : '']" autocomplete="off">
                        <input type="button" value="Cancel" @click.prevent="removePromocode()" v-if="promocodeDetails.status == 'true' &&  promocode"/>
                        <input type="button" :value="trans.vars.Promocode.promocodeApply " @click.prevent="applyPromocode()" v-else/>
                    </div>
                    <span class="invalid-feedback text-left error-promocode" style="display: block; margin-right: 20%;" v-if="promocodeDetails.status == 'false' && promocode"> {{ promocodeDetails.body }}</span>
                    <span class="invalid-feedback text-left" style="display: block; margin-right: 20%;" v-if="promocodeDetails.status == 'true'"> {{ trans.front.general.successPromocode }} {{ promocodeDetails.discount }}%</span>
                </div>
                <div class="title">{{ trans.vars.Cart.orderSummary }}</div>
                <div class="bloc">
                    <div>{{ trans.vars.Orders.orderSubtotal }}:</div>
                    <div>
                        {{ amount }} {{ $mainCurrency }}
                    </div>
                </div>
                <div class="bloc" v-if="currentCountry">
                    <div>{{ trans.vars.Shipping.shipping }}:</div>
                    <div v-if="shippingPrice">
                        {{ shippingPrice }} {{ $mainCurrency }}
                    </div>
                    <div v-else>
                        no shipping for this country
                    </div>
                </div>
                <div class="bloc orderTotal ">
                    <div><b>{{ trans.vars.Orders.orderTotal }}:</b></div>
                    <div>
                        {{ parseFloat(amount) + parseFloat(shippingPrice) }} {{ $mainCurrency }}
                    </div>
                </div>
                <div class="bloc aproximateTotal" v-if="$currency !== $mainCurrency">
                    ({{ trans.vars.Orders.approximately }}: {{ convertFloat((parseFloat(amount) + parseFloat(shippingPrice)) * parseFloat($currencyRate)) }} {{ $currency }})
                </div>
            </div>
            <div class="orderSummary">

                <!-- <p>
                  <a :href="'/' + this.$lang + '/livrare-achitare-retur'">{{ trans.vars.Cart.ship }}</a> {{ trans.vars.Cart.shippingTerm }}
                </p>
                <p>
                  <a :href="'/' + this.$lang + '/refund'"> {{ trans.vars.Cart.return }} </a> {{ trans.vars.Cart.inDays }}
                </p> -->

                <p>
                    <a href="#" data-target="#shipping" data-toggle="modal">{{ trans.vars.Cart.ship }}</a> {{ trans.vars.Cart.shippingTerm }}
                </p>
                <p>
                    <a href="#" data-target="#returns" data-toggle="modal">{{ trans.vars.Cart.return }}</a> {{ trans.vars.Cart.inDays }}
                </p>
                <!-- <p>
                    {{ trans.vars.Notifications.holidaysJanuaryNotification }}
                </p> -->

                <label class="checkContainer" v-if="mode == 'order-payment'">
                    {{ trans.vars.FormFields.agreeTo }}
                    <a href="#" data-target="#terms" data-toggle="modal" class="_link">
                        {{ trans.vars.PagesNames.pageNameTermsConditions }}
                    </a>
                    {{ trans.vars.FormFields.and }}
                    <a href="#"data-target="#returns" data-toggle="modal" class="_link">
                        {{ trans.vars.PagesNames.pageReturnPolicy }}
                    </a>
                    <input type="checkbox" v-model="agreeCond"/>
                    <span></span>
                </label>

            </div>
            <span v-if="mode != 'order-shipping' && mode != 'order-payment'">
                <span v-if="notInStoc">
                    <a class="butt buttView" data-toggle="modal" data-target="#checkStocks" href="#" @click="setGuest">{{ trans.vars.Orders.order }}</a>
                </span>
                <span v-else>
                    <a class="butt buttView" :href="'/' + this.$lang + '/order'" v-if="mode == 'cart'" @click="setGuest">{{ trans.vars.Orders.order }}</a>
                    <a class="butt buttView" id="_InitiateCheckout" data-toggle="modal" data-target="#login" href="#" @click="setGuest" v-else>{{ trans.vars.Orders.order }}</a>
                </span>
            </span>
        </div>
    </div>
    <div class="modal" id="checkStocks">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row modalBody">
                    <div class="closeModal" data-dismiss="modal"></div>
                    <div class="col-md-12">
                        <p class="text-center text-danger" >
                            {{ trans.front.cart.notInStock }}
                        </p>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center">
                        <input type="button" class="butt buttView" value="Move to Favorites" data-dismiss="modal" @click="moveAllProductToWish"/>
                        <input type="button" class="butt buttView" value="Cancel" data-dismiss="modal"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import { bus } from '../../app';

    export default {
        props: ['items', 'mode'],
        data() {
            return {
                loading: false,
                ready: false,
                serverError: false,
                notInStoc: false,
                cartProds: this.items,
                cartSubprods: [],
                cartSets: [],
                qty: 1,
                amount: 0,
                amountWithoutDiscount: 0,
                amountPersonalCurrecy: 0,
                delivery: 50,
                promocode: '',
                promocodeDetails: {},
                countries: [],
                currentCountry: [],
                mainDelivery: 0,
                shippingPrice: false,
                shippingTime: 0,
                agreeCond: false,
            }
        },
        mounted() {
            bus.$on('updateCart', data => {
                this.load();
                this.applyPromocode();  //reload all products
            })

            bus.$on('changeCountry', data => {
                this.currentCountry = data;
                this.mainDelivery =  data.main_delivery ? data.main_delivery.delivery_id : 0;
            })

            this.loadCountries();
            this.load();
            this.checkPromocode();

            // Request from order
            bus.$on('cartData', data => {
                bus.$emit('getCartData', {
                    amount      : parseFloat(this.amount) + parseFloat(this.shippingPrice), // this.amount,
                    delivery    : this.mainDelivery,
                    currency    : this.$currency,
                    promocode   : this.promocode,
                    tax         : parseFloat(this.amount) * parseFloat(this.currentCountry.vat),
                    agreeCond   : this.agreeCond,
                });
            })
        },
        methods: {
            // update products list and emit event in CartBoxComponent
            updateItemsList(data) {
                this.cartProds = data.products;
                this.cartSubprods = data.subproducts;
                this.cartSets = data.sets;
                this.countAmount();
                this.countPersonalAmount();
                this.applyPromocode();
                this.checkStock();
                bus.$emit('updateCartBox', {
                    data: data
                });
            },
            // load cart products method
            load() {
                axios.post('/' + this.$lang + '/get-cart-items')
                    .then(response => {
                        this.ready = true;
                        this.cartProds = response.data.products;
                        this.cartSubprods = response.data.subproducts;
                        this.cartSets = response.data.sets;
                        this.countAmount();
                        this.countPersonalAmount();
                        this.checkStock();
                        this.loading = false;
                    })
                    .catch(e => {
                        this.serverError = 'A avut loc o problema tehnica!';
                        console.log('error load products');
                    })
                },
                loadCountries(){
                    axios.post('/' + this.$lang + '/get-countries')
                        .then(response => {
                            this.countries = response.data.countries;
                            this.currentCountry = response.data.currentCountry;
                            this.mainDelivery = response.data.currentCountry.main_delivery ? response.data.currentCountry.main_delivery.delivery_id : 0;
                            this.shippingPrice = this.currentCountry.main_delivery ? this.currentCountry.main_delivery.price : false;
                            this.shippingTime = this.currentCountry.main_delivery ? this.currentCountry.main_delivery.delivery_time : 0;
                            this.ready = true;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error load countries');
                        })
                },
                // count amount method
                countAmount() {
                    let ammount = 0;

                    this.cartSubprods.forEach(function(entry){
                        if (entry.stock_qty > 0) {
                            ammount += entry.subproduct.product.main_price.price * entry.qty;
                        }
                    });

                    this.cartSets.forEach(function(entry){
                        if (entry.stock_qty > 0) {
                            ammount += entry.set.main_price.price * entry.qty;
                        }
                    });

                    if (this.promocodeDetails.discount) {
                        this.amount = ammount - (ammount * this.promocodeDetails.discount / 100);
                        this.amountWithoutDiscount = ammount;
                        return true;
                    }

                    this.amount = ammount;
                    this.amountWithoutDiscount = ammount;
                },
                // count personal currency amount method
                countPersonalAmount() {
                    var amount = 0;
                    this.cartSubprods.forEach(function(entry){
                        if (entry.stock_qty > 0) {
                            amount += entry.subproduct.product.personal_price.price * entry.qty;
                        }
                    });

                    this.cartSets.forEach(function(entry){
                        if (entry.stock_qty > 0) {
                            amount += entry.set.personal_price.price * entry.qty;
                        }
                    });

                    if (this.promocodeDetails.discount) {
                        this.amountPersonalCurrecy = amount - (amount * this.promocodeDetails.discount / 100);
                        return true;
                    }

                    this.amountPersonalCurrecy = amount;
                },
                // remove all cart products method
                removeAllCart(e) {
                    this.loading = true;
                    axios.post('/' + this.$lang + '/remove-all-cart')
                        .then(response => {
                            this.updateItemsList(response.data);
                            this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error remove all carts');
                        })
                },
                // remove one cart product method
                removeProduct(cartId, key) {
                    this.loading = true;
                    axios.post('/' + this.$lang + '/remove-cart-item', {
                            cartId: cartId
                        })
                        .then(response => {
                            this.updateItemsList(response.data);
                            this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error remove product');
                        })
                },
                // change product quantity method
                changeProductQty(e) {
                    this.loading = true;
                    axios.post('/' + this.$lang + '/change-product-qty', {
                            cartId: e.target.name,
                            qty: e.target.value,
                        })
                        .then(response => {
                            this.updateItemsList(response.data);
                            // this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error change qty');
                        });
                },
                // move product to wish list
                moveProductToWish(cartId) {
                    this.loading = true;
                    axios.post('/' + this.$lang + '/move-product-to-wish', {
                            cartId: cartId
                        })
                        .then(response => {
                            bus.$emit('updateWishBox', response.data.wishProducts);
                            this.updateItemsList(response.data.cartProducts);
                            this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error move to wishlist')
                        })
                },
                // move set to wish list
                moveSetToWish(cartId) {
                    this.loading = true;
                    axios.post('/' + this.$lang + '/move-set-to-wish', {
                            id: cartId
                        })
                        .then(response => {
                            bus.$emit('updateWishBox', response.data.wishProducts);
                            this.updateItemsList(response.data.cartProducts);
                            this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error move to wishlist')
                        })
                },
                moveAllProductToWish(){
                    axios.post('/' + this.$lang + '/move-all-product-to-wish')
                        .then(response => {
                            bus.$emit('updateWishBox', response.data.wishProducts);
                            this.updateItemsList(response.data.cartProducts);
                            this.loading = false;
                            $('#checkStocks').modal('hide');
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error error move all to wish list');
                        });
                },
                // check if promocode is valid on load component
                checkPromocode() {
                    axios.post('/' + this.$lang + '/check-promocode', {amount: this.amount})
                        .then(response => {
                            if (response.data != 'false') {
                                this.promocodeDetails = {
                                    'body': response.data.body,
                                    'discount': response.data.discount,
                                    'status': response.data.status,
                                };
                                this.promocode = response.data.name;
                                if (response.data.status == 'true') {
                                    this.load();
                                }
                            }
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error check promocode')
                        })
                },
                // apply and check a new promocode from input
                applyPromocode() {
                    this.promocodeCheck = true;
                    axios.post('/' + this.$lang + '/apply-promocode', {
                            promocode: this.promocode,
                            amount: this.amountWithoutDiscount,
                        })
                        .then(response => {
                            this.promocodeDetails = {
                                'body': response.data.body,
                                'discount': response.data.discount,
                                'status': response.data.status,
                            };
                            this.countAmount();
                            this.countPersonalAmount();
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error aply promocode')
                        })
                },
                removePromocode(){
                    this.promocode = '';
                    this.applyPromocode();
                },
                checkStock(){
                    let notInStock = false;
                    this.cartSubprods.forEach(function(entry){
                        if (entry.stock_qty == 0) {
                            bus.$emit('addAlertMessage', trans.front.cart.notInStock)
                            notInStock = true;
                        }
                        return notInStock;
                    });

                    this.cartSets.forEach(function(entry){
                        if (entry.stock_qty == 0) {
                            bus.$emit('addAlertMessage', trans.front.cart.notInStock)
                            notInStock = true;
                        }
                        return notInStock;
                    });

                    return this.notInStoc = notInStock;
                },
                setDeliveryCountry(){
                    axios.post('/' + this.$lang + '/change-product-qty', {
                            cartId: e.target.name,
                            qty: e.target.value,
                        })
                        .then(response => {
                            this.updateItemsList(response.data);
                            this.loading = false;
                        })
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('error set delivery country');
                        });
                },
                convertFloat(amount){
                    return amount.toFixed(2);
                },
                setGuest(){
                    bus.$emit('setGuest');
                    axios.post('/' + this.$lang + '/set-country-delivery', {
                            country: this.currentCountry.id,
                            delivery: this.mainDelivery,
                        })
                        .then(response => {})
                        .catch(e => {
                            this.serverError = 'A avut loc o problema tehnica!';
                            console.log('set guest user');
                        });
                },
                changeShippingMethod(e){
                    if (e.target.options.selectedIndex > -1) {
                        const theTarget = e.target.options[e.target.options.selectedIndex].dataset;
                        this.shippingPrice = theTarget.price
                    }
                    if (e.target.options.selectedIndex > -1) {
                        const theTarget = e.target.options[e.target.options.selectedIndex].dataset;
                        this.shippingTime = theTarget.time
                    }
                },
                changeCountry(){
                    this.shippingPrice = this.currentCountry.main_delivery ? this.currentCountry.main_delivery.price : false;
                    this.shippingTime = this.currentCountry.main_delivery ? this.currentCountry.main_delivery.delivery_time : 0;
                    this.mainDelivery = this.currentCountry.main_delivery ? this.currentCountry.main_delivery.delivery_id : 0;
                },
                setProductsPrice(set){
                    let ammount = 0;
                    set.children.forEach(function(entry){
                        ammount += entry.subproduct.product.main_price;
                    });

                    return ammount;
                },
                refreshPage(){
                    return location.reload();
                }
        }
    }
</script>

<style>
    .invalid-feedback{
        background-color: rgba(255, 255, 255, 0.7);
        padding: 20px;
    }

    .pasive{
        background-color: rgba(225, 205, 151, 0.6);
    }

    .loader-spiner {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    .lds-dual-ring {
        display: inline-block;
        width: 64px;
        height: 64px;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -32px;
        margin-top: -32px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 46px;
        height: 46px;
        margin: 1px;
        border-radius: 50%;
        border: 5px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 0.5s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    ._link{
        font-size: 16px;
    }
    .error-alert{
        /* position: absolute;
        width: 300px;
        min-height: 300px;
        background-image: url(../img/icons/fonTechniquePages.png);
        background-repeat: repeat; */
    }
</style>
