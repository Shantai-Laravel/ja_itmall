<template>

    <div class="productsInCart">
        <div class="itemCart" v-for="wishListProduct in wishListProducts" :key="wishListProduct.id">
            <div class="descrBloc">
                <a :href="'/' + $lang + '/catalog/' + wishListProduct.product.category.alias + '/' + wishListProduct.product.alias">
                    <img v-if="wishListProduct.product.main_image" :src="'/images/products/sm/' + wishListProduct.product.main_image.src">
                    <img v-else src="/fronts/images/noimage.png" alt="">
                </a>
                <div>
                    <div class="oneProductBlock">
                        <product :product="wishListProduct.product" :id="wishListProduct.product.id" mode="'wish'"></product>
                    </div>
                </div>
            </div>
            <div class="delete" @click="removeProductWish(wishListProduct.id)"></div>
        </div>

        <div class="itemCart cartSet" v-for="wishListSet in wishListSets">
            <div class="descrBloc">
                <a href="oneProductPage.html">
                    <img v-if="wishListSet.set.main_photo" :src="'/images/sets/sm/' + wishListSet.set.main_photo.src">
                    <img v-else src="/fronts/images/noimage.png" alt="">
                </a>
                <div>
                    <div class="name">{{ wishListSet.set.translation.name }} {{ trans.vars.DetailsProductSet.setOneHint }}</div>
                    <div class="functionalOptions">
                        <div class="edit">{{ trans.vars.DetailsProductSet.viewItemsFromSet }}</div>
                        <div class="optionsOpen">
                            <wish-set :set="wishListSet.set"></wish-set>
                            <div class="saveupdateBloc">
                                <div class="butt cancel">close</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="delete" @click="removeSetWish(wishListSet.id)"></div>
        </div>
    </div>

</template>

<script>
import { bus } from '../../app.js'

export default {
    props: ['products', 'sets'],
    data() {
        return {
            wishListProducts: this.products,
            wishListSets: this.sets,
            loading: false,
            isSubproduct: false,
            error: false,
            subproductId: false
        }
    },
    mounted(){
        bus.$on('updateWishList', data => {
            this.wishListProducts = data.products;
            this.wishListSets = data.sets;
        })
    },
    methods: {
        updateWishList(){

        },
        removeProductWish(id) {
            axios.post('/' + this.$lang + '/removeProductWish', {id : id})
                .then(response => {
                    this.wishListProducts = response.data.products,
                    this.wishListSets = response.data.sets,
                    bus.$emit('updateWishBox', response.data);
                })
                .catch(e => {
                    console.log('error remove product')
                })
        },
        removeSetWish(id) {
            axios.post('/' + this.$lang + '/removeSetWish', {id : id})
                .then(response => {
                    this.wishListProducts = response.data.products,
                    this.wishListSets = response.data.sets,
                    bus.$emit('updateWishBox', response.data);
                })
                .catch(e => {
                    console.log('error remove set')
                })
        },

    }
}
</script>
