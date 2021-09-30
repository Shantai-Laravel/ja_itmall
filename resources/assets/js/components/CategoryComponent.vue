<template>

    <div>
        <template v-for="(products, key) in productsTemplate">
            <template1 v-if="(key + 1) % 3 == 1" :products="products"></template1>
            <template2 v-if="(key + 1) % 3 == 2" :products="products"></template2>
            <template3 v-if="(key + 1) % 3 == 0" :products="products"></template3>
        </template>
    </div>

</template>

<script>
import { bus } from '../app';

export default {
    props: ['category', 'product'],
    data() {
        return {
            products: [],
            productsTemplate: [],
            defaultFilter: [],
            page: 0,
            last_page: 0,
            loading: false,
            categoryFiltredId: this.category.id
        };
    },
    mounted() {
        bus.$on('sendInitProducts', data => {
            this.products = this.products.concat(data.data);
            this.parseProducts();
        })

        bus.$on('categoryFilter', data => {
            this.categoryFiltredId = data.id;
            this.page = 0;
            this.filterCategory();
        })

        bus.$on('filterProducts', data => {
            this.products = data;
            this.parseProducts();
        })

        bus.$on('loadMoreFilterProducts', data => {
            this.products = this.products.concat(data.data);
            this.parseProducts();
        })

        window.addEventListener('scroll', this.handleScroll);
    },
    methods: {
        parseProducts(){
            let productArr = [];
            let products = [];
            let i = 0;
            let s = 0;
            this.products.forEach(function(entry, key){
                if ((key + 1) % 3 == 1) {
                    products = [];
                    i = 0;
                    s++;
                }
                products[i] = entry;
                productArr[s] = products;
                i++;
            });
            let filtered = productArr.filter(function (el) {
              return el != null;
            });
            this.productsTemplate = filtered;
        },
        handleScroll(e) {
            let scrollY = window.scrollY
            let visible = document.documentElement.clientHeight
            let pageHeight = document.documentElement.scrollHeight - 1500

            bus.$emit('handleScroll', {
                scrollY: scrollY,
                visible: visible,
                pageHeight: pageHeight,
                last_page: this.last_page
            });
        },
        // load cart products method
        load() {
            this.loading = true;
            axios.post('/ro/categories?page=' + this.page, {
                    mainProductId: this.product,
                    category_id: this.categoryFiltredId
                })
                .then(response => {
                    this.last_page = response.data.products.last_page;
                    this.page = response.data.products.current_page + 1;
                    this.products = this.products.concat(response.data.products.data);
                    this.defaultFilter = response.data.filter;
                    this.loading = false;

                    bus.$emit('setFilterDefault', response.data.filter);
                })
                .catch(e => {
                    console.log('error load products');
                })
        },
        filterCategory() {
            this.loading = true;
            axios.post('/ro/categories?page=' + this.page, {
                    mainProductId: this.product,
                    category_id: this.categoryFiltredId
                })
                .then(response => {
                    this.last_page = response.data.last_page;
                    this.page = response.data.current_page + 1;
                    this.loading = false;
                    this.products = response.data.data;
                })
                .catch(e => {
                    console.log('error load products');
                })
        },

    },
}
</script>
