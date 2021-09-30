<template>
    <div class="productOptions">
        <div class="selectBox">
            <div class="optionSelectedBox">{{ trans.vars.DetailsProductSet.size }}</div>
            <div class="options">
                <div class="sizeGide" data-toggle="modal" data-target="#modalSize">
                    {{ trans.vars.DetailsProductSet.sizeGuide }}
                </div>
                <div :class="['containerSize', subproduct.stoc == 0 ? 'soldOut' : '']" v-for="subproduct in product.subproducts">
                    <input type="radio" name="size1" :value="subproduct.parameter_value.translation.name" @change="chooseSubproduct(subproduct.id)" />
                    <span class="option">
                        <span class="optionSize">{{ subproduct.parameter_value.translation.name }}</span>
                        <span v-if="subproduct.stoc >= 5">{{ trans.vars.DetailsProductSet.inStock }}</span>
                        <span v-if="subproduct.stoc < 5 && subproduct.stoc > 0">{{ trans.vars.DetailsProductSet.inStockFewItems }}</span>
                        <span v-if="subproduct.stoc == 0">{{ trans.vars.DetailsProductSet.notInStock }}</span>
                    </span>
                </div>
            </div>
        </div>
        <div data-toggle="modal" data-target="#modalShipping" class="sizeGide shippingPopDescktop">
            Shipping, Payment and Returns
        </div>
        <div class="iconCart buttAddToCart" @click="addToCart">
            {{ btn }}
        </div>
    </div>
</template>

<script>
    import { bus } from '../../app';

    export default{
        props: ['product'],
        data() {
            return {
                properties: [],
                subproduct: [],
                checkProperty: false,
                isSubproduct: false,
                qty: 1,
                alertShow: false,
                alertStok: false,
                btn: trans.vars.Cart.cartAddTo,
            }
        },
        mounted() { },
        methods: {
            // add product to cart emit event in CartBoxComponent
            addToCart(){
                axios.post('/'+ this.$lang +'/add-product-to-cart', {
                        productId   : this.product.id,
                        subproductId : this.subproduct,
                    })
                    .then(response => {
                        this.btn = trans.vars.Cart.cartAddedTo;
                        bus.$emit('updateCartBox', {data : response.data});
                        bus.$emit('updateCart', this.subproduct.code);
                        $('.buttCart').addClass('flash');
                        setTimeout(function(){
                            $('.buttCart').removeClass('flash');
                        }, 500);
                    })
                    .catch(e => {
                      this.errors.push(e)
                  });
            },
            chooseSubproduct(subproductId){
                this.subproduct = subproductId;
            }
        },
    }
</script>
