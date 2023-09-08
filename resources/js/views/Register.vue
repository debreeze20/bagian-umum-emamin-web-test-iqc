<template>
    <div class="register-wrapper">
        <div class="d-flex">
            <div class="column-left-signup">
                <div class="d-flex flex-column align-items-center justify-content-center column-left-group">
                    <img alt="Logo" :src="`${$assetUrl()}extends/images/hero-signup.png`" class="mb-5"
                        style="max-width:90%;width:auto;" />
                    <div style="max-width:400px;" class="fs-2 text-dark fw-bolder text-center">Cepat, Kreatif and
                        Produktif</div>
                    <div style="max-width:400px;" class="text-gray-800 pt-2 text-center">Pengetahuan yang dipadu dengan
                        kreativitas adalah kombinasi yang tepat untuk memperoleh keberhasilan</div>
                </div>
            </div>
            <div class="pt-12 p-12 column-right-signup">
                <router-link to="/login" class="mb-5">
                    <div class="d-flex justify-content-center">
                        <div><img alt="Logo" class="me-3" :src="`${$assetUrl()}extends/images/bekraf-logo.png`"
                                style="width:70px" /></div>
                        <div><img alt="Logo" :src="`${$assetUrl()}extends/images/logo-1.png`" style="width:230px" />
                        </div>
                    </div>
                </router-link>
                <div class="w-100 mt-5 bg-white rounded p-10 p-lg-15"
                    style="box-shadow: 0px 0px 40px rgba(239, 240, 241, 0.7);">

                    <div class="text-center mb-10">
                        <h1 class="mb-3"
                            style="font-weight:900;text-transform: uppercase;background: linear-gradient(270.17deg, #44A8DF 0.15%, #6CB283 49.55%, #F8D831 103.26%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;background-clip: text;text-fill-color: transparent;">
                            selamat datang</h1>

                        <div class="text-gray-500 fw-bold fs-6">Silahkan lengkapi data dibawah ini untuk melanjutkan
                        </div>
                    </div>

                    <div class="fw-bolder fs-5 pb-3">Akun Untuk Login</div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.email.$error ? 'text-danger' : ''">Email Pemilik <span
                                class="text-danger">*Pastikan
                                Aktif Untuk Verifikasi Akun</span></label>
                        <input class="form-control" type="email" v-model="single.email" placeholder="Masukkan email"
                            autocomplete="off" />
                        <div v-if="v$.single.email.$error && !v$.single.email.validatorForbiddenHtml.$invalid" class="text-danger"> Email tidak boleh kosong & harus valid,
                            Ex: pengguna@gmail.com!
                        </div>
                        <div class="text-danger" v-if="v$.single.email.validatorForbiddenHtml.$invalid">
                            {{ v$.single.email.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <div class="d-flex flex-stack justify-content-between mb-2 align-items-center">
                            <label class="form-label text-gray-700 fs-6 mb-0"
                                :class="v$.single.password.$error ? 'text-danger' : ''">Password Untuk Login</label>
                        </div>
                        <input class="form-control" placeholder="Masukkan password" v-model="single.password"
                            :type="hidePassword ? 'password' : 'text'" autocomplete="off" />
                        <i id="icon-password" class="icon-password" @click="hidePassword = !hidePassword"
                            :class="hidePassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                        <div v-if="v$.single.password.$error && !v$.single.password.validatorForbiddenHtml.$invalid" class="text-danger"> Panjang minimal 6 karakter
                        </div>
                        <div class="text-danger" v-if="v$.single.password.validatorForbiddenHtml.$invalid">
                            {{ v$.single.password.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <div class="d-flex flex-stack justify-content-between mb-2 align-items-center">
                            <label class="form-label text-gray-700 fs-6 mb-0"
                                :class="v$.single.confirmPassword.$error ? 'text-danger' : ''">Konfirmasi
                                Password</label>
                        </div>
                        <input class="form-control" placeholder="Masukkan password" v-model="single.confirmPassword"
                            :type="hideConfirmPassword ? 'password' : 'text'" autocomplete="off" />
                        <i id="icon-password" class="icon-password" @click="hideConfirmPassword = !hideConfirmPassword"
                            :class="hideConfirmPassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                        <div v-if="v$.single.confirmPassword.$error && !v$.single.confirmPassword.validatorForbiddenHtml.$invalid" class="text-danger"> Harus sama dengan password
                        </div>
                        <div class="text-danger" v-if="v$.single.confirmPassword.validatorForbiddenHtml.$invalid">
                            {{ v$.single.confirmPassword.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fw-bolder fs-5 pb-3">Industri</div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.name.$error ? 'text-danger' : ''">Nama Industri</label>
                        <input class="form-control" type="text" v-model="single.name"
                            placeholder="Masukkan nama industri" autocomplete="off" />
                        <div v-if="v$.single.name.$error && !v$.single.name.validatorForbiddenHtml.$invalid" class="text-danger"> Nama Industri tidak boleh kosong!
                        </div>
                        <div class="text-danger" v-if="v$.single.name.validatorForbiddenHtml.$invalid">
                            {{ v$.single.name.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.type.$error ? 'text-danger' : ''">Jenis Industri</label>
                        <app-select-single v-model="single.type" :placeholder="'Pilih jenis industri'"
                            :options="listType" :show_button_clear="false" :show_search="false" :serverside="false">
                        </app-select-single>
                        <div v-if="v$.single.type.$error" class="text-danger"> Pilih salah satu!
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.sector.$error ? 'text-danger' : ''">Sektor Industri</label>
                        <app-select-multiple v-model="single.sector" :placeholder="'Pilih sektor industri'"
                            :loading="pageStatus == 'sector-load'" :options="listSector" :serverside="true"
                            @change-search="getSector" :show_button_clear="false"></app-select-multiple>
                        <div v-if="v$.single.sector.$error" class="text-danger"> Pilih salah satu!
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.merkName.$error ? 'text-danger' : ''">Nama Merek Dagang</label>
                        <input class="form-control" v-model="single.merkName" type="text"
                            placeholder="Masukkan merek dagang" autocomplete="off" />
                        <div v-if="v$.single.merkName.$error && !v$.single.merkName.validatorForbiddenHtml.$invalid" class="text-danger"> Nama Merek Dagang tidak boleh kosong!
                        </div>
                        <div class="text-danger" v-if="v$.single.merkName.validatorForbiddenHtml.$invalid">
                            {{ v$.single.merkName.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.ownerName.$error ? 'text-danger' : ''">Nama Pemilik</label>
                        <input class="form-control" v-model="single.ownerName" type="text"
                            placeholder="Masukkan nama pemilik industri" autocomplete="off" />
                        <div v-if="v$.single.ownerName.$error && !v$.single.ownerName.validatorForbiddenHtml.$invalid" class="text-danger"> Nama Pemilik tidak boleh kosong!
                        </div>
                        <div class="text-danger" v-if="v$.single.ownerName.validatorForbiddenHtml.$invalid">
                            {{ v$.single.ownerName.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.addressSelling.$error ? 'text-danger' : ''">Alamat Penjualan Produk
                            (Marketplace atau
                            sejenisnya)</label>
                        <input class="form-control" type="text" v-model="single.addressSelling"
                            placeholder="Cth: https://www.tokopedia.com/sambeldedesatoe" autocomplete="off" />
                        <div v-if="v$.single.addressSelling.$error && !v$.single.addressSelling.validatorForbiddenHtml.$invalid" class="text-danger"> Tidak boleh kosong & harus
                            berupa link valid!
                        </div>
                        <div class="text-danger" v-if="v$.single.addressSelling.validatorForbiddenHtml.$invalid">
                            {{ v$.single.addressSelling.validatorForbiddenHtml.$response.message }}
                        </div>
                    </div>
                    <div class="fv-row mb-6">
                        <label class="form-label fs-6 text-gray-700"
                            :class="v$.single.nib.$error ? 'text-danger' : ''">Unggah NIB *PDF</label>
                        <input class="form-control" type="text" v-model="single.nib" placeholder="Masukkan nib"
                            autocomplete="off" />
                        <div v-if="v$.single.nib.$error && !v$.single.nib.validatorForbiddenHtml.$invalid" class="text-danger"> NIB tidak boleh kosong!
                        </div>
                        <div class="text-danger" v-if="v$.single.nib.validatorForbiddenHtml.$invalid">
                            {{ v$.single.nib.validatorForbiddenHtml.$response.message }}
                        </div>
                        <div class="mt-5 mb-5">
                            <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-nib">
                                <div class="dz-message needsclick">
                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                    <div class="ms-4">
                                        <h5 class="kt-dropzone__msg-title">
                                            Drop files here or click to upload
                                        </h5>
                                        <span class="kt-dropzone__msg-desc text-primary">
                                            Upload only 1 file with the format
                                            .pdf
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="kt_sign_in_submit"
                            class="btn btn-lg me-3 my-2 px-16 bg-primary-custom" :disabled="disabledButton"
                            @click="register">
                            {{ pageStatus == 'form-register' ? 'Memproses...' : 'Daftar' }}
                        </button>
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
        required,
        email,
        sameAs,
        minLength,
        url
    } from '@vuelidate/validators'
    export default {

        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                disabledButton: false,
                hidePassword: true,
                hideConfirmPassword: true,
                listSector: [],
                dropzone: null,
                listType: [{
                        id: 'product',
                        text: 'Produk'
                    },
                    {
                        id: 'service',
                        text: 'Jasa'
                    }
                ],
                single: {
                    email: '',
                    password: '',
                    confirmPassword: '',
                    nib: '',
                    name: '',
                    type: {},
                    sector: [],
                    merkName: '',
                    ownerName: '',
                    addressSelling: ''
                }
            }
        },
        validations() {
            const validatorForbiddenHtml = this.$validatorForbiddenHtml
            return {
                single: {
                    nib: {
                        required,
                        validatorForbiddenHtml
                    },
                    email: {
                        required,
                        validatorForbiddenHtml,
                        email
                    },
                    password: {
                        required,
                        minLength: minLength(6),
                        validatorForbiddenHtml
                    },
                    confirmPassword: {
                        required,
                        sameAsPassword: sameAs(this.single.password),
                        validatorForbiddenHtml
                    },
                    name: {
                        required,
                        validatorForbiddenHtml
                    },
                    type: {
                        required
                    },
                    sector: {
                        required
                    },
                    merkName: {
                        required,
                        validatorForbiddenHtml
                    },
                    ownerName: {
                        required,
                        validatorForbiddenHtml
                    },
                    addressSelling: {
                        required,
                        validatorForbiddenHtml,
                        url
                    }
                },
            }
        },
        beforeRouteLeave(to, from, next) {
            this.dropzone.destroy();
            next();
        },
        mounted() {
            this.$initializeAppPlugins();
            this.dropzone = new Dropzone("#dropzone-nib", {
                url: `/`,
                dictCancelUpload: "Cancel",
                maxFilesize: 20,
                parallelUploads: 1,
                uploadMultiple: false,
                maxFiles: 2,
                addRemoveLinks: false,
                acceptedFiles: ".pdf",
                autoProcessQueue: false,
                init: function () {
                    this.on("addedfile", function (file) {
                        if (this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }

                    });
                    this.on("error", function (file) {
                        if (!file.accepted) {
                            this.removeFile(file);
                            that.$swal("Silahkan periksa file Anda lagi");
                        } else if (file.status == "error") {
                            this.removeFile(file);
                            that.$swal("Terjadi kesalahan koneksi");
                        }
                    });

                    this.on("resetFiles", function (file) {
                        this.removeAllFiles();
                    });
                },
            });
        },
        methods: {
            register() {
                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                this.pageStatus = 'form-register';
                this.disabledButton = true;

                let formData = new FormData();
                formData.append('nib', this.single.nib);
                formData.append('email', this.single.email);
                formData.append('password', this.single.password);
                formData.append('passwordConfirmation', this.single.confirmPassword);
                formData.append('industryName', this.single.name);
                formData.append('trademarkName', this.single.merkName);
                formData.append('industryType', this.single.type.id);
                formData.append('marketingLink', this.single.addressSelling);
                formData.append('ownerName', this.single.ownerName);

                for (let i = 0; i < this.single.sector.length; i++) {
                    formData.append('industrySectorId[]', this.single.sector[i].id);
                }

                let hasFile = false;
                if (!$.isEmptyObject(this.dropzone.files)) {
                    for (let file in this.dropzone.files) {
                        formData.append('file', this.dropzone.files[file]);
                        hasFile = true;
                    }
                }

                if (!hasFile) {
                    this.$toast.error("Dokumen NIB harus diisi!");
                    return false;
                }


                Api().post(`${this.$apiType('global')}auth/register`, formData)
                    .then(response => {

                        this.$router.replace({
                            path: '/register/success'
                        })
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                        this.disabledButton = false;
                    });
            },
            getSector(keyword, limit) {

                this.pageStatus = 'sector-load';

                Api().get(`${this.$apiType("global")}select-list/industry-sector?limit=${limit}&search=${keyword}`)
                    .then(response => {

                        this.listSector = [];

                        for (let i = 0; i < response.data.data.length; i++) {
                            this.listSector.push({
                                id: response.data.data[i].id,
                                text: response.data.data[i].name,
                            });
                        }

                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.pageStatus = 'standby';
                    })
            },
            reset() {
                this.single.email = '';
                this.single.password = '';
                this.single.confirmPassword = '';
                this.single.name = '';
                this.single.type = {};
                this.single.sector = {};
                this.single.merkName = '';
                this.single.ownerName = '';
                this.single.addressSelling = '';
            }
        }
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

    .column-right-signup {
        width: 550px;
        min-height: 100vh;
    }

    .column-left-signup {
        width: calc(100% - 550px);
        min-height: 100vh;
    }

    .column-left-group {
        min-height: 100vh;
        position: fixed;
        width: calc(100% - 550px);
    }

    @media(max-width:991px) {
        .column-right-signup {
            width: 100% !important;
            padding: 20px !important;
            min-height: 0 !important;
        }

        .column-left-signup {
            width: 0 !important;
            display: none !important;
            min-height: 0 !important;
        }

        .column-left-group {
            min-height: 0 !important;
            position: static !important;
            width: 0 !important;

        }
    }

</style>
