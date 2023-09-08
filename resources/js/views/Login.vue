<template>
    <div style=" overflow-x:hidden;">
        <div class="row" style="height:100vh;">
            <div class="col-md-7 " style="position:relative;">
                <img :src="`${$assetUrl()}extends/images/left.png`" style="width:100%; height:100vh; object-fit:cover;" alt="">
            </div>
            <div class="col-md-5 d-flex align-items-center justify-content-center">
                <div class="forms">
                    <div class="logo text-center">
                        <img :src="`${$assetUrl()}extends/images/e-mamin-logo.svg`" style="width:50%;  top:30px; left:50px;" alt="">
                        <br><br>
                        <div class="tulisan-judul py-7">
                            <h1 style="font-weight:900;">Selamat Datang</h1>
                            <b class="text-gray-700">Masukkan username dan password</b>
                        </div>
                    </div>
                    <div class="w-100 p-3 mb-5 text-center text-gray-700 fs-7" v-if="errorMessage"
                            style="border:1px #f26c6c solid;background-color: #fee3e3;border-radius:5px;">
                            {{ errorMessage }}
                    </div>
                    <div class="wrap-inputan">
                        <div class="inputan">
                            <label for="username" :class="`text-gray-700 ${v$.single.username.$error ? 'text-danger' : ''}`">Username</label>
                            <input type="text" v-model="single.username" @keyup.enter="login()" class="form-control" placeholder="Masukkan username">
                            <span class="text-danger" v-if="v$.single.username.$error">Username tidak boleh kosong.</span>
                        </div>
                        <br>
                        <div class="inputan" style="position:relative;">
                            <label for="password" :class="`text-gray-700 ${v$.single.password.$error ? 'text-danger' : ''}`">Password</label>
                            <input :type="hidePassword ? 'password' : 'text'" v-model="single.password" @keyup.enter="login()" class="form-control" placeholder="Masukkan password">
                            <span @click="showHidePassword()" style="cursor:pointer; position:absolute; right:10px; bottom:6px;">
                                <i class="bi bi-eye fa-2x" v-if="hidePassword"></i>
                                <i class="bi bi-eye-slash fa-2x" v-else></i>
                            </span>
                        </div>
                        <span class="text-danger" v-if="v$.single.password.$error">Password tidak boleh kosong.</span>
                        <br>
                        <center>
                            <vue-recaptcha ref="recaptcha" :sitekey="siteKey" @verify="verifyMethod" @expired="expiredMethod"></vue-recaptcha>
                        </center>
                        <br>
                        <center>
                            <template v-if="captcha">
                                <div>
                                    <button class="btn py-3 px-10 text-light" style="background-color: #527D3C; width:100%; border-radius: 15px;" @click="login()" v-if="!disabledButton">Masuk</button>
                                    <button class="btn py-3 px-10 text-light" disabled v-else style="cursor:progress !important; background-color: #527D3C; width:100%; border-radius: 15px;">Processing...</button>
                                </div>
                            </template>
                        </center>
                        <p class="text-end fixed-bottom px-20 me-15">Copyright © 2023 <span > <a href="https://umumprokopim.surabaya.go.id/" target="_blank" style="color:#527D3C">Bagian Umum & Prokopim Kota Surabaya</a></span> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Api from "@/services/api";
    import useVuelidate from '@vuelidate/core'
    import {
        VueRecaptcha
    } from 'vue-recaptcha';
    import {
        required
    } from '@vuelidate/validators'
    export default {
        components: {
            VueRecaptcha
        },
        data() {
            return {
                disabledButton: false,
                captcha: '',
                // bg_login: this.$assetUrl() + 'extends/images/bg-login.png',
                landingPageUrl: import.meta.env.VITE_LANDINGPAGE_URL,
                pageStatus: 'standby',
                errorMessage: '',
                siteKey: import.meta.env.VITE_RECAPTCHA_SITE_KEY,
                disabledButton: false,
                hidePassword: true,
                v$: useVuelidate(),
                single: {
                    username: '',
                    password: '',
                }
            }
        },
        validations() {
            return {
                single: {
                    username: {
                        required
                    },
                    password: {
                        required,
                    }
                },
            }
        },
        methods: {
            verifyMethod(response) {
                this.captcha = response;
            },
            expiredMethod() {
                this.captcha = '';
            },
            showHidePassword() {
                this.hidePassword = !this.hidePassword
            },
            login() {
                this.v$.$touch();
                if (this.v$.$error) {
                    this.$swal({
                                title: "Terjadi Kesalahan!",
                                icon: "warning",
                                text: 'Mohon masukkan username dan password terlebih dahulu.',
                                showCancelButton: false,
                                confirmButtonColor: "#F64E60",
                                confirmButtonText: "Baiklah",
                            });
                    return false;
                }

                if (this.disabledButton) {
                    return false;
                }

                this.pageStatus = "form-login";
                this.disabledButton = true;

                let formData = {
                    username: this.single.username,
                    password: this.single.password,
                    gRecaptchaResponse:this.captcha
                }
                Api().post(`${this.$apiType('global')}auth/login`, formData)
                    .then(response => {
                        this.$store.commit('profile/SET_PROFILE_DATA', null);
                        this.$router.replace({
                            path: '/'
                        });
                        localStorage.setItem('token', response.data.token.accessToken)
                    })
                    .catch(error => {
                        grecaptcha.reset()
                        this.single.captcha = '';
                        if (error.response && error.response.status == 401) {
                           this.errorMessage = error.response.data.meta.message
                        } 
                        else if (error.response && error.response.status == 429) {
                            this.errorMessage = 'Anda gagal masuk 3x, silahkan coba lagi 1 menit lagi';
                        }
                        else {
                            this.$axiosHandleError(error);
                        }
                    }).then(() => {
                        this.pageStatus = "standby";
                        this.disabledButton = false;
                    })
            }
        },
        computed: {

        },
        mounted() {
            this.$initializeAppPlugins();
        },
    }

</script>

<style scoped>
    .icon-password {
        cursor: pointer;
        float: right;
        position: relative;
        bottom: 32px;
        right: 10px;
        font-size: 20px;
    }

</style>
