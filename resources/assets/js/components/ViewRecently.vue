<template>

    <div :class="['container', className]" v-if="products.length > 0">
        <div class="boxBloc">
            <div class="title">{{ trans.vars.DetailsProductSet.recentlyViewed }}</div>
            <div class="topSellers">
                <div class="oneProductBlock" v-for="(product, key) in products">
                    <a :href="'/' + $lang + '/catalog/' +  product.category.alias + '/' + product.alias">
                        <img :src="'/images/products/sm/' + product.main_image.src" :alt="product.translation.name" v-if="product.main_image"/>
                        <img src="/fronts/img/product.jpg" :alt="product.translation.name" v-else/>
                    </a>
                    <product :product="product" :id="product.id"></product>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import { bus } from '../app';

    export default {
        // components: { Slick },
        props : ['wish'],
        data() {
            return {
                products : [],
                page: 1,
                last_page: '',
                loading: false,
                ready: false,
                className: 'hide',
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            // load products method
            load() {
                this.loading = true;
                axios.post('/'+ this.$lang +'/get-recently-products')
                    .then(response => {
                        this.products = response.data;
                        this.loading = false;
                        this.ready = true;
                        // this.className = '';
                        let vm = this;
                        setTimeout(function(){
                            vm.className = '';
                            // console.log('here');
                        }, 4000)
                    })
                    .catch(e => {
                        this.loading = false;
                        console.log('loading products error.');
                    })

            },
        }
    }
</script>

<style>
    .hide{
        visibility: hidden;
    }
</style>
