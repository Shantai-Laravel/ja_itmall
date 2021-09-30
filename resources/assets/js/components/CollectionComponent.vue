<template>

    <div class="row parentFilter">
       <div class="col-12">
          <h3>{{ collection.translation.name }}</h3>
       </div>

        <div class="col-md-4" v-for="set in sets">
           <div class="filterItem setItem">
              <a :href="'/' + $lang + '/collection/' + set.collection.alias + '/' + set.alias">

                 <img :src="'/images/sets/og/' + set.main_photo.src" alt="" v-if="set.main_photo"/>
                 <img src="/images/noimage.jpg" alt="" v-else/>
                 <aside>
                    <div class="nameProduct">{{ set.translation.name }}</div>
                    <div class="components"></div>
                 </aside>
              </a>
           </div>
        </div>
    </div>

</template>

<script>
    import { bus } from '../app';

    export default {
        props: ['collection'],
        data() {
            return {
                sets : [],
                page: 0,
                last_page: 0,
                loading: false,
            };
        },
        mounted(){
            axios.interceptors.request.use(config => {
                bus.$emit('showPreloader');
                return config;
            }, error => {
                return Promise.reject(error);
            });

            axios.interceptors.response.use(response => {
                bus.$emit('hidePreloader');
                return response;
            }, error => {
            this.loading = false
                return Promise.reject(error);
            });
            this.load();
            window.addEventListener('scroll', this.handleScroll);
        },
        methods: {
            load(){
                this.loading = true;
                axios.post('/'+ this.$lang +'/get-sets?page=' + this.page, {
                        collection_id : this.collection.id,
                    })
                    .then(response => {
                        this.last_page = response.data.last_page;
                        this.page = response.data.current_page + 1;
                        this.sets = this.sets.concat(response.data.data);

                        console.log(this.sets);
                        this.loading = false;
                    })
                    .catch(e => {  console.log('sets loading error') });
            },
            handleScroll(e) {
                let scrollY = window.scrollY
                let visible = document.documentElement.clientHeight
                let pageHeight = document.documentElement.scrollHeight - 500

                if (this.page <= this.last_page) {
                    let bottomOfPage = visible + scrollY >= pageHeight
                    let diff =  bottomOfPage || pageHeight < visible

                    if (diff && !this.loading ) {
                        this.load();
                    }
                }
                // bus.$emit('handleScroll', {
                //     scrollY: scrollY,
                //     visible: visible,
                //     pageHeight: pageHeight,
                //     last_page: this.last_page
                // });
            },
        }
    }
</script>
