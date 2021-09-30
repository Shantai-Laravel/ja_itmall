<template>

    <div class="cartBloc step2 row">
        <div class="col-12 text-center text-danger" v-if="serverError">
            <p class="text-center">A avut loc o problema tehnica.</p>
            <p class="text-center">Va sugeram sa reincarcati pagina</p>
            <a href="#" @click="refreshPage">Reincarca</a>
        </div>
        <div class="bagFromFirefox" v-if="ready">

            <!-- if user not have address -->
            <div :class="['row', 'shippingInformation', editableAddress ? 'show' : 'hide']">
                <div class="col-12">
                    <div class="title">
                        <div>{{ trans.vars.Shipping.shipping }}</div>
                    </div>
                </div>
                <div class="col-12 shippingBloc">
                    <div class="title">{{ trans.vars.Shipping.shippingContact }}</div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <label for="name">{{ trans.vars.FormFields.fieldFullName }} <b>*</b></label>
                            <input type="text" id="name" v-model="name=user.name"/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <label for="email">{{ trans.vars.FormFields.fieldEmail }} <b>*</b></label>
                            <input type="text" id="email" v-model="email=user.email"/>
                        </div>
                        <div class="col-lg-4 col-md-8">
                            <label for="">{{ trans.vars.FormFields.fieldFullphone }}</label>
                            <div class="optionsOpen">
                                <select class="js-example-basic-single" v-model="code" v-select2="code">
                                    <option
                                        :data-image="'/images/flags/16x16/' + country.flag"
                                        :value="country.phone_code" v-for="country in countries"
                                        >
                                        <span>+{{ country.phone_code }}</span>
                                    </option>
                                </select>
                                <div class="nrTelephone">
                                    <input placeholder="Phone" type="text" id="tel" v-model="phone=user.phone"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 shippingBloc" v-if="userAddress">
                    <div class="title">{{ trans.vars.Shipping.shippingAdress }}</div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="street">{{ trans.vars.FormFields.fieldStreet }} <b>*</b></label>
                            <input type="text" id="street" v-model="address=userAddress.address"/>
                        </div>
                        <div class="col-md-6">
                            <label for="flat">{{ trans.vars.FormFields.fieldFullApartment }}</label>
                            <input type="text" id="flat" v-model="apartment=userAddress.homenumber"/>
                        </div>
                        <div class="col-lg-4 col-md-6 shippingSelect">
                            <label for="country">{{ trans.vars.FormFields.fieldCountry }} <b>*</b></label>
                            <select v-model="country" @change="changeCountry">
                                <option :value="country.id" v-for="country in countries">{{ country.translation.name }}</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="region">{{ trans.vars.FormFields.fieldFullRegion }}</label>
                            <input type="text" id="region" v-model="region=userAddress.region"/>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="city">{{ trans.vars.FormFields.fieldCity }} <b>*</b></label>
                            <input type="text" id="city" v-model="city=userAddress.location"/>
                        </div>
                        <div class="col-md-6">
                            <label for="zipCode">{{ trans.vars.FormFields.fieldPostcode }} <b>*</b></label>
                            <input type="text" id="zipCode" v-model="zip=userAddress.code"/>
                        </div>
                    </div>
                </div>
                <div class="col-12 shippingBloc" v-else>
                    <div class="title">{{ trans.vars.Shipping.shippingAdress }}</div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="street">{{ trans.vars.FormFields.fieldStreet }} <b>*</b></label>
                            <input type="text" id="street" v-model="address"/>
                        </div>
                        <div class="col-md-6">
                            <label for="flat">{{ trans.vars.FormFields.fieldFullApartment }}</label>
                            <input type="text" id="flat" v-model="apartment"/>
                        </div>
                        <div class="col-lg-4 col-md-6 shippingSelect">
                            <label for="country">{{ trans.vars.FormFields.fieldCountry }} <b>*</b></label>
                            <select v-model="country" @change="changeCountry">
                                <option :value="country.id" v-for="country in countries">{{ country.translation.name }}</option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="region">{{ trans.vars.FormFields.fieldFullRegion }}</label>
                            <input type="text" id="region" v-model="region"/>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label for="city">{{ trans.vars.FormFields.fieldCity }} <b>*</b></label>
                            <input type="text" id="city" v-model="city"/>
                        </div>
                        <div class="col-md-6">
                            <label for="zipCode">{{ trans.vars.FormFields.fieldPostcode }} <b>*</b></label>
                            <input type="text" id="zipCode" v-model="zip"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <label class="checkContainer" v-if="mode == 'auth'">
                    {{ trans.vars.FormFields.saveDefault }}
                    <input type="checkbox" v-model="setDefault"/>
                    <span></span>
                    </label>
                </div>
                <div class="col-12 text-center" v-if="validateError">
                    <p class="text-danger">{{ validateError }}</p>
                </div>
                <div class="col-lg-3 col-md-5 col-6">
                    <input type="submit" @click.prevent="confirmAddress" :value="trans.vars.FormFields.confirm" />
                </div>
                <div class="col-lg-3 col-md-5 col-6">
                    <div class="cancelStep">cancel</div>
                </div>
            </div>

            <!-- if user have address -->
            <div :class="['row', 'shippingInformation', !editableAddress ? 'show' : 'hide']">
                <div class="col-12">
                    <div class="title">
                        <div>{{ trans.vars.Shipping.shipping }}</div>
                    </div>
                </div>
                <div class="address col-12" v-if="name">
                    <div class="row">
                        <div class="item">
                            <div class="name">{{ name + ',' }} {{ phone + ',' }} {{ email }}</div>
                            <div class="street"><span>{{ address }}</span>  <span v-if="apartment">, {{ apartment }}</span> </div>
                            <div class="country">
                                <span v-if="currentCountry">{{ currentCountry.name }}</span>
                                <span v-if="region">, {{ region }}</span>
                                <span v-if="city">, {{ city }}</span>
                                <span v-if="zip">, {{ zip }}</span>
                            </div>
                            <div class="settingButton editAddress" @click="cancelConfirmAddress">Edit</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="blocReview">
                <div class="productsInCart">
                    <div class="title">
                        {{ trans.vars.Orders.orderReview }}
                    </div>
                    <cart-block :items="items" :mode="'order-shipping'"></cart-block>
                </div>
            </div>
        </div>
        <div class="col" v-else>
            not products in cart
        </div>
        <div class="alertUser  text-center" v-if="validateError">
            <div class="closeAlert" @click="dismisAllert">
            </div>
            <p class="text-danger">{{ validateError }}</p>
        </div>
        <div class="col-12 parFor">
            <div style="opacity: 0;">
            </div>
            <div class="step2butt" v-if="ready">
                <input type="button" class="butt buttView order-btn" :data-value="amount" :value="trans.vars.Orders.continueBtn" @click="order"/>
            </div>
        </div>
    </div>

</template>

<script>
import {bus} from '../app.js'

export default {
  props: ['items', 'mode'],
  data() {
    return {
        ready: true,
        serverError: false,
        user: [],
        userAddress: false,

        countries: [],
        currentCountry: '',

        name: '',
        code: '',
        phone: '',
        email: '',
        address: '',
        apartment: '',
        country: '',
        region: '',
        city: '',
        zip: '',
        setDefault: false,

        // payments: [],
        // mainPayment: [],
        // choosePayment: false,
        // defaultPayment: false,

        amount: '0.00',
        validateError: false,
        cartData: [],
        editableAddress: true,
        lookOrderBtn: false,
    }
  },
  mounted() {
      this.editableAddress = this.mode == 'guest' ? true : false;

      this.getUser();

      bus.$on('getCartData', data => {
          this.cartData = data;
      });

      bus.$on('updateCartBox', data => {
          this.checkCart(data);
      });
  },
  methods: {
      dismisAllert(){
          this.validateError = false;
      },
      getUser(){
          axios.post('/' + this.$lang + '/order-get-user')
              .then(response => {
                  if (response.data.mode == 'auth') {
                      this.user = response.data.frontUser;
                      this.userAddress = response.data.frontUser.address;
                      if (this.userAddress) {
                          this.editableAddress = false;
                      }else{
                          this.editableAddress = true;
                      }
                  }else{
                      this.user = response.data.frontUser;
                      this.editableAddress = true;
                  }
                  this.country = response.data.country;
                  this.code = response.data.phone_code;
                  this.phone = response.data.phone;
                  this.loadCountries();
              })
              .catch(e => {
                  this.serverError = 'A avut loc o problema tehnica!';
                  console.log('error load user')
              })
      },
      loadCountries(){
          axios.post('/' + this.$lang + '/get-countries')
              .then(response => {
                  this.countries = response.data.countries;
                  this.currentCountry = response.data.currentCountry;
              })
              .catch(e => {
                  this.serverError = 'A avut loc o problema tehnica!';
                  console.log('error load countries')
              })
      },
      setPayments(){ // to Delete
          if (this.userAddress) {
              this.payments = this.userAddress.get_country_by_id.payments;
              this.mainPayment = 0;
          }else{
              this.payments = this.currentCountry.payments;
              this.mainPayment = 0;
          }
      },
      changeCountry(){
          axios.post('/' + this.$lang + '/order-change-country', {countryId: this.country})
              .then(response => {
                  this.currentCountry = response.data;
                  this.payments = this.currentCountry.payments;
                  bus.$emit('changeCountry', this.currentCountry);
              })
              .catch(e => {
                  this.serverError = 'A avut loc o problema tehnica!';
                  console.log('error')
              })
      },
      order(){
          bus.$emit('cartData');
          this.validate();
          if (!this.validateError) {

              if (this.lookOrderBtn === false) {
                  // this.lookOrderBtn = true;
                  // checkout
                  axios.post('/' + this.$lang + '/order-shipping', {
                      name          : this.name,
                      email         : this.email,
                      phone_code    : this.code,
                      phone         : this.phone,
                      country       : this.country,
                      region        : this.region,
                      city          : this.city,
                      address       : this.address,
                      apartment     : this.apartment,
                      zip           : this.zip,
                      saveAddress   : this.setDefault,
                      payment       : this.choosePayment,
                      defaultPayment: this.defaultPayment,
                      cartData      : this.cartData,
                  })
                  .then(response => {
                      window.location.href = window.location.origin + '/' + this.$lang + '/order/payment/' + response.data;
                  })
                  .catch(e => {
                      this.serverError = 'A avut loc o problema tehnica!';
                      console.log('error')
                  })
              }
          }
          let vm = this;
          setTimeout(function(){
              vm.dismisAllert();
          }, 5000);
      },
      confirmAddress(){
          this.validate('shipping');
          if (!this.validateError) {
              this.editableAddress = false;
          }
      },
      cancelConfirmAddress(){
          this.editableAddress = true;
      },
      checkCart(data){
          // if (data.products.length == 0 || data.sets.length == 0) {
          //     this.ready = false;
          // }else{
          //     this.ready = true;
          // }
      },
      validate(mode = 'all'){
          let error = false;

          if (mode == 'all') {
              // if (this.cartData.agreeCond == false) {
              //     error = trans.vars.Notifications.agreeRequired
              // }
              if (this.cartData.delivery.length < 1) {
                  error = 'delivery missing!'
              }
          }

         if (this.zip === null) { error = "zip missing!"; }
         else{ if (this.zip.length < 1) { error = "zip missing!"; } }

         if (this.city === null) { error = "city missing!"; }
         else{ if (this.city.length < 1) { error = "city missing!"; } }

         if (this.country === null) { error = "country missing!"; }
         else{ if (this.country.length < 1) { error = "country missing!"; } }

         if (this.address === null) { error = "street missing!"; }
         else{ if (this.address.length < 1) { error = "street missing!"; } }

         if (!this.validatePhone(this.phone)) { error = 'phone is not valid' }

         if (this.phone === null) { error = trans.vars.Notifications.phoneRequired }
         else{ if (this.phone.length < 1) { error = trans.vars.Notifications.phoneRequired }}

         if (!this.validateEmail(this.email)) { error = 'email is not valid' }

         if (this.email === null) { error = trans.vars.Notifications.emailRequired }
         else{ if (this.email.length < 1) { error = trans.vars.Notifications.emailRequired } }

         if (this.name === null) { error = trans.vars.Notifications.nameRequired }
         else{ if (this.name.length < 1) { error = trans.vars.Notifications.nameRequired } }

         this.validateError = error;
     },
     validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    validatePhone(phone) {
       var re = /^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
       return re.test(String(phone).toLowerCase());
   },
  }
}
</script>

<style media="screen">
    .cart .butt.buttView{
        margin-right: auto;
    }
    .hide{
        display: none;
    }
</style>
