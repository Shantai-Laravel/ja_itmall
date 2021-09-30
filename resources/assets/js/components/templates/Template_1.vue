<template>
    <div>
        <div class="templateProductsOne">

          <div class="productContainer product1" v-for="(product, key) in products" v-if="(key + 1) % 3 == 1">
            <div class="oneProductBlock">

              <a :href="'/' + $lang + '/catalog/' +  product.category.alias + '/' + product.alias">
                  <img :src="'/images/products/' + $device + '/' + product.main_image.src" :alt="product.translation.name" v-if="product.main_image"/>
                  <img src="/fronts/img/product.jpg" :alt="product.translation.name" v-else/>
              </a>
              <product :product="product" :id="product.id"></product>
            </div>
          </div>

          <div class="productContainer product2" v-for="(product, key) in products" v-if="(key + 1) % 3 == 2">
            <div class="oneProductBlock">
                <a :href="'/' + $lang + '/catalog/' +  product.category.alias + '/' + product.alias">
                    <img :src="'/images/products/' + $device + '/' + product.main_image.src" :alt="product.translation.name" v-if="product.main_image"/>
                    <img src="/fronts/img/product.jpg" :alt="product.translation.name" v-else/>
                </a>
              <product :product="product" :id="product.id"></product>
            </div>
          </div>


          <div class="productContainer product3" v-for="(product, key) in products" v-if="(key + 1) % 3 == 0">
            <div class="oneProductBlock">
                <!-- <div class="buttSound buttSoundCat" v-if="product.video">
                  <div class="iconSound">
                  </div>
                </div> -->
                <a :href="'/' + $lang + '/catalog/' +  product.category.alias + '/' + product.alias" class="videoCont">
                    <img :src="'/images/products/' + $device + '/' + product.main_image.src" :alt="product.translation.name" v-if="product.main_image"/>
                    <img src="/fronts/img/product.jpg" :alt="product.translation.name" v-else/>
                    <!-- <video width="100%" height="100%" :src="'/videos/' + product.video" :poster="'/images/products/' + $device + '/' + product.main_image.src" autoplay muted loop v-if="product.video"></video>
                    <img src="/fronts/img/product.jpg" :alt="product.translation.name" v-else/> -->
                </a>
             <product :product="product" :id="product.id"></product>
            </div>
          </div>

        </div>
    </div>

</template>

<script>
import { bus } from '../../app';

export default {
    props: ['products'],
    data() {
        return {
            items: this.products,
        };
    },
    mounted() {

    },
    methods: {},
}
</script>
