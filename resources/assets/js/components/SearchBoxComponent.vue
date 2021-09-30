<template>

    <div class="searchOpen">
        <div class="closeSearch"></div>
        <input type="text" :placeholder="trans.vars.Search.searchTitle" v-model="search" @keyup="findProducts"/>
        <ul class="searchResults">
            <li v-for="product in products">
                <a :href="'/' + $lang + '/catalog/' + product.category.alias + '/' + product.alias" class="nameProduct">
                  <img :src="'/images/products/og/' + product.main_image.src" v-if="product.main_image">
                  <img src="/fronts/img/product.jpg" v-else>
                  <span>{{ product.translation.name }}</span>
                </a>
            </li>
            <li v-for="set in sets">
                <a :href="'/' + $lang + '/collection/' + set.collection.alias + '?order=' + set.alias" class="nameProduct">
                  <img :src="'/images/sets/og/' + set.main_photo.src" v-if="set.main_photo">
                  <img src="/fronts/img/product.jpg" v-else>
                  <span>{{ set.translation.name }} ({{ trans.vars.DetailsProductSet.setOneHint }})</span>
                </a>
            </li>
        </ul>
    </div>

</template>

<script>
    import { bus } from '../app';
    export default{
        data() {
            return {
                search : '',
                products : [],
                sets : [],
            }
        },
        methods: {
            // find products method
            findProducts(){
                if (this.search.length > 2) {
                    axios.post('/'+ this.$lang +'/search-product', {search : this.search})
                        .then(response => {
                            this.products = response.data.products;
                            this.sets = response.data.sets;
                        })
                        .catch(e => {
                            console.log('loading search products error.');
                        })
                }
            }
        }
    }
</script>
