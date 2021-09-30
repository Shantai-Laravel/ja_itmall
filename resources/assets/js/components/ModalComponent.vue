<template>
    <div v-if="showModal">
        <transition name="modal-rent">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="close" @click="showModal = false"></div>
                        <div class="headModal">{{ showModal }}</div>
                      </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { bus } from '../app.js'

export default {
      props: ['product'],
      data() {
          return {
              showModal : false,
          }
      },
      mounted(){
          bus.$on('showModal', data => {
              this.showModal = data;
          })
      },
      methods: {}
}
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }
    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
</style>
