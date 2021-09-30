<template>

    <a :href="'/' + $lang + '/cart'">
        <div class="nrArt">{{ count }}</div>
    </a>

</template>

<script>

import { bus } from '../../app';

export default {
    props: ['items'],
    data() {
        return {
            count: this.items.length,
        }
    },
    mounted() {
        bus.$on('updateCartBox', data => {
            this.count = 0;
            this.count += data.data.products.length;
            this.count += data.data.sets.length;
            $('.buttCart').addClass('heartBeat');
            setTimeout(function(){
                $('.buttCart').removeClass('heartBeat');
            }, 500);
        })

        bus.$on('updateCartBoxFromSet', data => {
            console.log(data);
            this.count = 0;
            this.count += data.data.carts.subproducts.length;
            this.count += data.data.carts.sets.length;
            $('.buttCart').addClass('heartBeat');
            setTimeout(function(){
                $('.buttCart').removeClass('heartBeat');
            }, 500);
        })
    },
}
</script>
