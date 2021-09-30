<template>
    <form class="row modalBody">
        <div class="closeModal" data-dismiss="modal"></div>
        <div class="modalHeader">
            <span>{{ trans.vars.Auth.passForgotQuestion }}</span>
        </div>
        <div class="col-md-12" v-if="step == 1">
            <p>
                {{ trans.vars.Auth.forgetPassMessage }}
            </p>
            <div class=" loginBy loginByRegister">
                <input type="text" placeholder="Email" v-model="email"/>
            </div>
            <p class="text-danger text-center" v-if="error" v-html="error"></p>
            <input type="button" class="butt buttView" value="Send" @click="sendEmail"/>
        </div>
        <div class="col-md-12" v-if="step == 2">
            <p>
                Introduceti mai jos codul primit in email.
            </p>
            <div class="numberCode">
                <div class="send" @click="sendEmail">send again</div>
                <input type="text" placeholder="Introduceti codul" v-model="code"/>
            </div>
            <p class="text-danger text-center" v-if="error" v-html="error"></p>
            <input type="button" class="butt buttView" value="Send" @click="sendCode"/>
        </div>
        <div class="col-md-12"  v-if="step == 3">
            <div class="col-md-12">
                <input type="password" placeholder="Parola noua" v-model="password"/>
                <input type="password" placeholder="Repeta parola" v-model="passwordAgain"/>
            </div>
            <p class="text-danger text-center" v-if="error" v-html="error"></p>
            <input type="button" class="butt buttView" value="Save" @click="resetPassword"/>
        </div>
    </form>
</template>

<script>
    export default {
      data() {
            return {
                email: null,
                code: null,
                password: null,
                passwordAgain: null,
                token: document.querySelector('meta[name="_token"]').content,
                error: false,
                step: 1
            }
      },
      methods: {
          sendEmail(){
              this.error = false;
              if (this.validateEmail(this.email) ) {
                  axios.post('/' + this.$lang + '/reset-password-send-email', {email: this.email})
                      .then(response => {
                          if (response.data.status == 'false') {
                              this.error = response.data.error.toString()
                          }else{
                              this.step = 2;
                              this.error = false;
                          }
                      })
                      .catch(e => { console.log('error reset password send email') });
              }else{
                  this.error = 'Email is not valid';
              }
          },
          sendCode(){
              if (this.code.length > 1 ) {
                  axios.post('/' + this.$lang + '/reset-password-send-code', {code: this.code})
                      .then(response => {
                          if (response.data.status == 'false') {
                              this.error = response.data.error.toString()
                          }else{
                              this.step = 3;
                              this.error = false;
                          }
                      })
                      .catch(e => { console.log('error reset password send code') });
              }else{
                  this.error = 'Code is not required';
              }
          },
          resetPassword(){
              if (this.validatePasswords()) {
                  axios.post('/' + this.$lang + '/reset-password-send-password', {password: this.password, _token: this.token})
                      .then(response => {
                          if (response.data.status == 'false') {
                              this.error = response.data.error
                          }else{
                              window.location.reload(true);
                          }
                      })
                      .catch(e => { console.log('error reset password') });
              }
          },
            validateEmail(email) {
               var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
               return re.test(String(email).toLowerCase());
            },
            validatePasswords(){
               if (this.password.length < 1) {
                   this.error = 'Password is required';
                   return false;
               }

               if (this.password !== this.passwordAgain) {
                   this.error = 'Passwords not much';
                   return false;
               }

               return true;
            },
        }
    }
</script>
