<template>
    <div class="col-lg-5 col-md-6">
        <div class="asideSet">
            <div class="parentAside">
                <div class="productsInSet">
                    <div class="product" v-for="product in set.products">
                        <a :href="'/' + $lang + '/catalog/' + product.category.alias + '/' + product.alias">
                            <img :src="'/images/products/set/' + getSetImage(product, set.id)" v-if="getSetImage(product, set.id) != false">
                        </a>
                        <div class="productDescr" >
                            <a :href="'/' + $lang + '/catalog/' + product.category.alias + '/' + product.alias" class="name">{{ product.translation.name }}</a>
                            <div class="descrBloc"><span>{{ trans.vars.DetailsProductSet.price }}: </span><span>{{ product.personal_price.price }} {{ $currency }}</span></div>
                            <div class="selectBox">
                                <div class="optionSelectedBox">{{ trans.vars.DetailsProductSet.size }}</div>
                                <div class="options">
                                    <div class="sizeGide" data-toggle="modal" data-target="#modalSize">
                                        {{ trans.vars.DetailsProductSet.sizeGuide }}
                                    </div>
                                    <div :class="['containerSize', subproduct.stoc == 0 ? 'soldOut' : '']" v-for="subproduct in product.subproducts">
                                        <input type="radio" name="size1" :value="subproduct.parameter_value.translation.name" @change="chooseSubproduct(subproduct.product_id, subproduct.id)" v-if="subproduct.stoc > 0"/>
                                        <input type="radio" name="size1" :value="subproduct.parameter_value.translation.name" v-else/>
                                        <span class="option">
                                            <span class="optionSize">{{ subproduct.parameter_value.translation.name }}</span>
                                            <span v-if="subproduct.stoc >= 5">{{ trans.vars.DetailsProductSet.inStock }}</span>
                                            <span v-if="subproduct.stoc < 5 && subproduct.stoc > 0">{{ trans.vars.DetailsProductSet.inStockFewItems }}</span>
                                            <span v-if="subproduct.stoc == 0">{{ trans.vars.DetailsProductSet.notInStock }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="productOptions">
                    <div class="price">
                        <span>{{ trans.vars.DetailsProductSet.pricePerSet }}</span>
                        <span v-if="set.personal_price.price > 0">
                            <del v-if="set.personal_price.price > ammount && ammount > 0"><span>{{ set.personal_price.price }} {{ $currency }}</span></del>
                            <span v-else>{{ parseFloat(set.personal_price.price) }} {{ $currency }}</span>
                        </span>
                        <span v-if="ammount > 0">
                            <del v-if="ammount > set.personal_price.price && set.personal_price.price > 0"><span>{{ parseFloat(ammount) }} {{ $currency }}</span></del>
                            <span v-else>{{ parseFloat(ammount) }} {{ $currency }}</span>
                        </span>
                    </div>
                    <p class="text-danger text-center" v-if="notInStock">{{ this.notInStock }}</p>
                    <div class="buttons">
                        <div class="butt addToWish" @click="addToWish"></div>
                        <div class="butt buttAddToCartSet" @click="addToCart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { bus } from '../app';

export default {
    props: ['set'],
    data() {
        return {
            subproducts: [],
            chooseProducts: false,
            ammount: 0,
            notInStock: false,
        };
    },
    mounted() {
        this.amountProducts();
    },
    methods: {
        amountProducts(){
            let ammount = 0;
            this.set.products.forEach(function(entry) {
                ammount += parseFloat(entry.personal_price.price);
            });
            this.ammount = ammount;
        },
        addToCart(e){
            this.notInStock = false;
            if (this.chooseProducts) {
                e.target.classList.toggle('addedToCart');
                axios.post('/'+ this.$lang +'/add-set-to-cart', {
                        setId   : this.set.id,
                        subproducts : this.subproducts,
                    })
                    .then(response => {
                        bus.$emit('updateCartBoxFromSet', {data : response.data});
                    })
                    .catch(e => {
                        this.errors.push(e)
                  });
            }else{
                this.notInStock = trans.vars.Notifications.chooseSizes;
            }
        },
        addToWish(e){
            e.target.classList.toggle('wishAdded');

            axios.post('/'+ this.$lang +'/add-set-to-wish', {setId : this.set.id})
                .then(response => {
                    bus.$emit('updateWishBox', response.data);
                })
                .catch(e => {
                    this.errors.push(e)
              });
        },
        chooseSubproduct(productId, subproductId){
            this.notInStock = false;
            this.subproducts[productId] = subproductId;
            this.validate();
        },
        validate(){
            let vm = this;
            this.chooseProducts = true;
            this.set.products.forEach(function(entry){
                if (!vm.subproducts.hasOwnProperty(entry.id)) {
                    vm.chooseProducts = false;
                }
            });
        },
        getSetImage(product, setId){
            let ret = false;
            product.set_images.forEach(function(entry){
                if(setId == entry.set_id){
                    ret = entry.image;
                    return ret;
                }
            })
            return ret;
        },
    },
}
</script>
