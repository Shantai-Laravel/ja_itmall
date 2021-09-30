<template>

    <a :href="'/' + $lang + '/wish'">
        <div class="nrArt">{{ count }}</div>
    </a>

</template>

<script>
import { bus } from '../../app';

export default {

    props: ['items', 'sets'],
    data() {
        return {
            count: this.items.length + this.sets.length,
        }
    },
    mounted() {
        bus.$on('updateWishBox', data => {
            this.count = 0;
            this.count += data.products.length;
            this.count += data.sets.length;
            $('.buttWish').addClass('heartBeat');
            setTimeout(function(){
                $('.buttWish').removeClass('heartBeat');
            }, 500);
        })
        bus.$on('updateWishCounter', data => {
            this.count = data;
        })
    },
}
</script>
