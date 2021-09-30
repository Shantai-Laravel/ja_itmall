<template>
    <div>
        <div class="modalHeader">
            <div class="headTab" id="registerTab" @click="deactivateActiveTab">
                {{ trans.vars.Auth.registrationTitle }}
            </div>
            <div class="headTab active" id="signinTab" @click="deactivateActiveTab">
                {{ trans.vars.Auth.login }}
            </div>
            <div class="headTab" id="guestTab" @click="showGuestTab" v-if="isGuest">
                {{ trans.vars.Auth.asGuest }}
            </div>
        </div>
        <!-- Login -->
        <div class="tabBloc signinBloc activeBloc" id="signinBloc">
            <label for="login2">{{ trans.vars.FormFields.fieldEmail }}</label>
            <input type="email" id="login2" v-model="loginUserData.email"/>
            <label for="pwd1">{{ trans.vars.FormFields.pass }}</label>
            <input type="password" id="pwd1" v-model="loginUserData.password"/>
            <p class="text-danger text-center" v-if="loginError.length">
                {{ loginError }}
            </p>
            <p class="text-danger text-center" v-for="(error, index) in serverErrors" :key="index" v-html="error">
                {{ error }}
            </p>
            <input type="submit" :value="trans.vars.Auth.login"  @click="login"/>
            <a href="#" data-target="#forgetPassword" data-toggle="modal" data-dismiss="modal">Forgot password?</a>
            <div class="text-center">{{ trans.vars.Auth.loginWith }}</div>
            <ul class="socialMedia">
                <li><a :href="'/' + $lang + '/login/facebook'" class="f"></a></li>
                <li><a :href="'/' + $lang + '/login/google'" class="gp"></a></li>
            </ul>
        </div>
        <!-- Registration -->
        <div class="tabBloc registerBloc" id="registerBloc">
            <label for="login1">{{ trans.vars.FormFields.fieldFullName }}</label>
            <input type="text" id="login1"  v-model="registerUserData.name"/>
            <label for="tel">{{ trans.vars.FormFields.fieldEmail }}</label>
            <input type="text" id="tel"v-model="registerUserData.email" />
            <label for="tel">{{ trans.vars.FormFields.fieldphone }}</label>
            <div class="telefonGroup">
                <select class="js-example-basic-single" name="" v-model="registerUserData.code">
                    <option :value="country.phone_code"
                            :data-image="'/images/flags/16x16/' + country.flag"
                            v-for="country in countries">
                             <span>+{{ country.phone_code }}</span>
                    </option>
                </select>
                <input type="number" :placeholder="trans.vars.FormFields.fieldphone" v-model="registerUserData.phone"/>
            </div>

            <label for="pwd">{{ trans.vars.FormFields.pass }}</label>
            <input type="password" id="pwd" v-model="registerUserData.password"/>
            <label for="reppwd">{{ trans.vars.FormFields.passRepeat }}</label>
            <input type="password" id="reppwd" v-model="registerUserData.passwordAgain"/>
            <label class="checkContainer"
                > {{ trans.vars.FormFields.termsUserAgreementPersonalData3 }} <a :href="'/' + $lang + '/terms'" target="_blank"> {{ trans.vars.PagesNames.pageNameTermsConditions }}</a>
            <input type="checkbox" v-model="registerUserData.agree"/>
            <span></span>
            </label>
            <p class="text-danger text-center" v-if="registerError.length">
                {{ registerError }}
            </p>
            <p class="text-danger text-center" v-for="(error, index) in serverErrors" :key="index" v-html="error">
                {{ error }}
            </p>
            <input type="submit" :value="trans.vars.Auth.registrationTitle" @click="register"/>
        </div>
        <!-- Guest User -->
        <div class="tabBloc guestBloc" id="guestBloc" v-if="isGuest">
            <label for="name2">{{ trans.vars.FormFields.fieldFullName }}</label>
            <input type="text" id="name2" v-model="guestUserData.name"/>
            <label for="login2">{{ trans.vars.FormFields.fieldEmail }}</label>
            <input type="email" id="login2" v-model="guestUserData.email"/>
            <label for="">{{ trans.vars.FormFields.fieldphone }}</label>
            <div class="telefonGroup">
                <select class="jjs-example-basic-single" name="" v-model="registerUserData.code">
                    <option :value="country.phone_code"
                            :data-image="'/images/flags/16x16/' + country.flag"
                            v-for="country in countries">
                            <span>+{{ country.phone_code }}</span>
                    </option>
                </select>
                <input type="number" placeholder="Telefon" v-model="guestUserData.phone"/>
            </div>

            <p class="text-danger text-center" v-if="guestLoginError.length">
                {{ guestLoginError }}
            </p>
            <p class="text-danger text-center" v-for="(error, index) in serverErrors" :key="index" v-html="error">
                {{ error }}
            </p>
            <input type="submit" :value="trans.vars.TehButtons.submit"  @click="signGuestUser"/>
            <div class="text-center">{{ trans.vars.Auth.loginWith }}</div>
            <ul class="socialMedia">
                <li><a :href="'/' + $lang + '/login/facebook'" class="f"></a></li>
                <li><a :href="'/' + $lang + '/login/google'" class="gp"></a></li>
            </ul>
            <div class="text-center">
                {{ trans.vars.Auth.guestLoginNotification }}
            </div>
        </div>
    </div>
</template>

<script>
    import { bus } from '../../app.js'

    export default {
        props: ['guest'],
        data() {
            return {
                registerUserData : {
                    email: '',
                    name: '',
                    code: '',
                    phone: '',
                    password: '',
                    passwordAgain: '',
                    agree: false,
                },
                loginUserData: {
                    email: '',
                    password: '',
                },
                guestUserData: {
                    name: '',
                    phone: '',
                    email: '',
                    code: '',
                },
                countries: [],
                registerError: [],
                loginError: [],
                serverErrors: [],
                guestLoginError: [],
                isGuest: false,
            }
        },
        mounted() {
            this.getCountriesList();
            bus.$on('setGuest', data => {
                this.isGuest = true;
            });
            if (this.guest.length > 0) {
                this.setGuestData();
            }
        },
        methods: {
            setGuestData(){
                let guest = JSON.parse(this.guest);
                this.guestUserData.name = guest.name;
                this.guestUserData.email = guest.email;
                this.guestUserData.phone = guest.phone;
            },
            getCountriesList(){
                axios.post('/' + this.$lang + '/auth-get-phone-codes-list')
                    .then(response => {
                        this.registerUserData.code = response.data.currentCountry.phone_code;
                        this.countries = response.data.countries;
                    })
                    .catch(e => { console.log('error load codes') });
            },
            register(){
                if (this.validateRegistration() == true) {
                    axios.post('/' + this.$lang + '/registration', this.registerUserData)
                        .then(response => {
                            if (response.data.status === 'false') {
                                this.serverErrors = response.data.errors
                            }else{
                                window.location.reload(true);
                            }
                        })
                        .catch(e => { console.log('error user register') });
                }
            },
            login(){
                if (this.validateLogin() == true) {
                    axios.post('/' + this.$lang + '/auth-login', this.loginUserData)
                        .then(response => {
                            if (response.data.status === 'false') {
                                this.serverErrors = response.data.errors
                            }else{
                                window.location.reload(true);
                            }
                        })
                        .catch(e => { console.log('error user login') });
                }
            },
            signGuestUser(){
                axios.post('/' + this.$lang + '/auth-guest-login', this.guestUserData)
                    .then(response => {
                        if (response.data.status === 'false') {
                            this.serverErrors = response.data.errors
                        }else{
                            window.location.href = window.location.origin + '/' + this.$lang + '/order';
                        }
                    })
                    .catch(e => { console.log('error user login') });

            },
            validateLogin(){
                this.loginError = [];
                if (this.loginUserData.email.length < 2) {
                    this.loginError = trans.vars.Notifications.emailRequired;
                    return false;
                }
                if (!this.validateEmail(this.loginUserData.email)) {
                    this.loginError = trans.vars.Notifications.emailNotValid
                    return false;
                }
                if (this.loginUserData.password.length < 2) {
                    this.loginError = trans.vars.Notifications.passNotValid
                    return false;
                }

                return true;
            },
            validateGuestLogin(){
                this.loginError = [];
                if (this.guestUserData.name.length < 2) {
                    this.guestLoginError = trans.vars.Notifications.nameRequired;
                    return false;
                }
                if (this.guestUserData.email.length < 2) {
                    this.guestLoginError = trans.vars.Notifications.emailRequired;
                    return false;
                }
                if (!this.validateEmail(this.guestUserData.email)) {
                    this.guestLoginError = trans.vars.Notifications.emailNotValid;
                    return false;
                }
                if (this.guestUserData.phone.length < 2) {
                    this.guestLoginError = trans.vars.Notifications.phoneRequired;
                    return false;
                }

                return true;
            },
            validateRegistration(){
                this.registerError = [];
                if (this.registerUserData.name.length < 2) {
                    this.registerError = trans.vars.Notifications.nameRequired;
                    return false;
                }
                if (this.registerUserData.email.length < 2) {
                    this.registerError = trans.vars.Notifications.emailRequired;
                    return false;
                }
                if (!this.validateEmail(this.registerUserData.email)) {
                    this.registerError = trans.vars.Notifications.emailNotValid;
                    return false;
                }
                if (this.registerUserData.code.length < 1) {
                    this.registerError = trans.vars.Notifications.codeRequired;
                    return false;
                }
                if (this.registerUserData.phone.length < 1) {
                    this.registerError = trans.vars.Notifications.phoneRequired;
                    return false;
                }
                if (this.registerUserData.password.length < 1) {
                    this.registerError = trans.vars.Notifications.passRequired;
                    return false;
                }
                if (this.registerUserData.password.length < 7) {
                    this.registerError = trans.vars.Notifications.passMinChars;
                    return false;
                }
                if (!this.checkPwd(this.registerUserData.password)) {
                    this.registerError = trans.vars.Notifications.passCharsNumAlpha;
                    return false;
                }
                if (this.registerUserData.password !== this.registerUserData.passwordAgain) {
                    this.registerError = trans.vars.Notifications.passNotMatch;
                    return false;
                }
                if (this.registerUserData.agree == false) {
                    this.registerError = trans.vars.Notifications.agreeRequired;
                    return false;
                }

                return true;
            },
            checkPwd(str) {
                if (str.search(/\d/) == -1) {
                    return false;
                } else if (str.search(/[a-zA-Z]/) == -1) {
                    return false;
                } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
                    return false;
                }

                return true;
            },
            validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            },
            showGuestTab(){
                $('.headTab').removeClass('active');
                $('#guestTab').addClass('active');
                this.signGuestUser();

                // $('.tabBloc').removeClass('activeBloc');
                // $('.guestBloc').addClass('activeBloc');
            },
            deactivateActiveTab(){
                $('#guestTab').removeClass('active');
                $('.tabBloc').removeClass('activeBloc');
            }
        },
    }
</script>

<style media="screen">
    .guestBloc{
        display: none;
    }
</style>
