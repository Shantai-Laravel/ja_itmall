<template>
    <div>
        <div class="sizeBlock">
            <label class="radioContainer" v-for="subproduct in this.product.subproducts">
                <input type="radio" v-on:click="getSubproduct(subproduct.parameter_id, subproduct.value_id)"  :name="'prop' + product.id ">
                <span class="radioCheckmark">{{ subproduct.parameter_value.translation.name }}</span>
            </label>
        </div>

        <div class="row justify-content-center">
            <span class="col-10 text-center" v-if="alertShow">
                {{ trans.front.collections.size }}
            </span>
            <span class="col-10 text-center" v-if="alertStok">
                {{ trans.front.general.notInStock }}
            </span>

            <div class="modalFooter">
                <select name="selectCant" id="selectCant" v-model="qty" v-if="isSubproduct">
                    <option v-if="subproduct" v-for="stoc in subproduct.stoc">{{ stoc }}</option>
                </select>
                <select name="selectCant" id="selectCant" v-model="qty" v-if="product.subproducts.length == 0">
                    <option v-for="stoc in product.stock">{{ stoc }}</option>
                </select>
                <div class="buttHover"><a href="#" class="butt" v-on:click="addToCart">{{ trans.front.general.addToCart }}</a></div>
            </div>
        </div>
    </div>
</template>

<script>
    import SizesComponent from './SizesComponent.vue';
    import { bus } from '../app';
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
            }
        },
        mounted() {
            this.setProperies();
        },
        methods: {
            // set default parameters
            setProperies(){
                this.properties = this.product.category.properties;
            },
            // check if subproduct is active and in stoc
            checkSubproduct(propertyId){
                let result = false;
                let subproducts = this.product.subproducts;

                let valObj = subproducts.filter(function(elem){
                    let isProp = true;
                    if((elem.active == 0) || (elem.stoc == 0)){
                        let combs = Object.values(JSON.parse(elem.combination));
                        if (combs.includes(propertyId)) {
                            isProp = false;
                        }
                    }
                    if (isProp === false) {
                        return elem;
                    }
                });

                if(valObj.length == 0){
                    result = true;
                }
                return result;
            },
            // get subproduct on change size
            getSubproduct(propertyId, valueId){
                if (this.product.subproducts.length > 0) {
                    axios.post('/'+ this.$lang +'/get-subproduct', {
                            productId   : this.product.id,
                            propertyId  : propertyId,
                            valueId     : valueId,
                        })
                        .then(response => {
                            if (response.data) {
                                this.subproduct = response.data;
                                this.isSubproduct = true;
                                this.alertStok  = false;
                                this.alertShow  = false;
                            }else{
                                this.subproduct = [];
                                this.isSubproduct = false;
                                this.alertShow = false;
                                this.alertStok = true;
                            }
                        })
                        .catch(e => {
                            console.log('get subproduct error.');
                      });
                 }
            },
            // add product to cart emit event in CartBoxComponent
            addToCart(){
                if(this.product.subproducts.length == 0 || this.isSubproduct != false){
                    axios.post('/'+ this.$lang +'/add-product-to-cart', {
                            productId   : this.product.id,
                            subproductId   : this.subproduct.id,
                            qty : this.qty,
                        })
                        .then(response => {
                            bus.$emit('updateCartBox', {products : response.data});
                            bus.$emit('updateCart', this.subproduct.code);
                            bus.$emit('showMessage' + this.product.id);
                        })
                        .catch(e => {
                          this.errors.push(e)
                      });
                }else{
                    this.alertStok = false;
                    this.alertShow = true;
                }
            }
        },
    }
</script>
