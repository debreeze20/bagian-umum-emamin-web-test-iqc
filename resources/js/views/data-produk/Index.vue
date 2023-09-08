<template>
    <div class="d-flex flex-column flex-root" style="height:100vh; background-color: #527D3C;">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="mt-20 d-flex flex-column flex-row-fluid " style="background-color: #DBF4D8 !important;" id="kt_wrapper">
                <!--begin::Header-->
                <app-navbar></app-navbar>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid" style="margin-top: 100px;">
                            <!--begin::Content disini-->

                        <div class="card card-flush" id="kt_profile_details_view">
                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-5 align-items-center">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder text-dark mb-2">Data Master Tipe Produk</span>
                                    </h3>
                                    <div class="d-flex">
                                        <button type="button" class="btn h-50" style="background-color: #527D3C !important;"
                                        @click="tambahUmkm">
                                        <span class="text-white">Tambah Data</span>
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body pt-5">
                                    <app-datatable :table_config="tableConfig" @change-page="getDatatable"
                                        v-model:show_per_page="tableConfig.config.show_per_page"
                                        v-model:search="tableConfig.config.search"
                                        v-model:order="tableConfig.config.order"
                                        v-model:current_page="tableConfig.config.current_page">
                                        <template v-slot:body>
                                            <tr v-for="(context,index) in tableConfig.feeder.data">
                                                <td class="text-center">
                                                    {{index + ((parseInt(tableConfig.config.show_per_page) * (parseInt(tableConfig.config.current_page) - 1))) + 1}}
                                                </td>
                                                <td class="text-left">
                                                   {{ context?.name || '-' }}

                                                </td>
                                                <td class="text-center">
                                                   Rp {{$rupiahFormat(context?.price || '-') }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="m-auto form-check form-switch form-check-custom form-check-solid">
                                                        <input class="m-auto form-check-input h-30px w-50px" type="checkbox" :checked="context?.price " @change="switchStatus(context?.id)"/>
                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center">
                                                    <button class="btn btn-light mx-2 btn-sm" @click="edit(context?.id)" title="edit">
                                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_2245_1330)"><path d="M11.9604 6.0805L6.3839 11.9762C6.21863 12.1509 5.98873 12.2499 5.74822 12.2499L3.20833 12.2499C2.72508 12.2499 2.33333 11.8582 2.33333 11.3749L2.33333 8.81264C2.33333 8.58536 2.42176 8.367 2.57991 8.20378L8.21434 2.38837C8.55061 2.04131 9.10456 2.03255 9.45163 2.36882C9.45494 2.37202 9.45822 2.37526 9.46148 2.37852L11.9435 4.86051C12.2785 5.19552 12.286 5.73631 11.9604 6.0805Z" fill="#7E8299"/></g><defs><clipPath id="clip0_2245_1330"><rect width="14" height="14" fill="white"/></clipPath></defs></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        </template>
                                    </app-datatable>
                                </div>
                            </div>
                        </div>
                            <!--end::Content disini-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->

        <div class="modal fade" tabindex="-1" id="modal-add">
            <div class="modal-dialog modal-dialog-centerd">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 text-left">
                            <h3 class="modal-title text-left" style="font-size:14px !important" >
                                {{ flag == 'insert' ? 'Tambah' : 'Edit' }} Tipe Produk
                            </h3>
                        </div>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon-2x">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17.88 15.9996L23.6134 10.2796C23.8644 10.0285 24.0055 9.688 24.0055 9.33293C24.0055 8.97786 23.8644 8.63733 23.6134 8.38626C23.3623 8.13519 23.0218 7.99414 22.6667 7.99414C22.3116 7.99414 21.9711 8.13519 21.72 8.38626L16 14.1196L10.28 8.38626C10.029 8.13519 9.68844 7.99414 9.33337 7.99414C8.97831 7.99414 8.63778 8.13519 8.38671 8.38626C8.13564 8.63733 7.99459 8.97786 7.99459 9.33293C7.99459 9.688 8.13564 10.0285 8.38671 10.2796L14.12 15.9996L8.38671 21.7196C8.26174 21.8435 8.16254 21.991 8.09485 22.1535C8.02716 22.316 7.99231 22.4902 7.99231 22.6663C7.99231 22.8423 8.02716 23.0166 8.09485 23.179C8.16254 23.3415 8.26174 23.489 8.38671 23.6129C8.51066 23.7379 8.65813 23.8371 8.8206 23.9048C8.98308 23.9725 9.15736 24.0073 9.33337 24.0073C9.50939 24.0073 9.68366 23.9725 9.84614 23.9048C10.0086 23.8371 10.1561 23.7379 10.28 23.6129L16 17.8796L21.72 23.6129C21.844 23.7379 21.9915 23.8371 22.1539 23.9048C22.3164 23.9725 22.4907 24.0073 22.6667 24.0073C22.8427 24.0073 23.017 23.9725 23.1795 23.9048C23.342 23.8371 23.4894 23.7379 23.6134 23.6129C23.7383 23.489 23.8375 23.3415 23.9052 23.179C23.9729 23.0166 24.0078 22.8423 24.0078 22.6663C24.0078 22.4902 23.9729 22.316 23.9052 22.1535C23.8375 21.991 23.7383 21.8435 23.6134 21.7196L17.88 15.9996Z"
                                        fill="black" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="fs-6 form-label">Nama Tipe</label>
                            <input class="form-control" v-model="single.name" placeholder="Cth:Snack VVIP"/>
                            <div v-if="v$.single.name.$error" class="text-danger py-2">
                                Nama Tipe Produk Wajib diisi!
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="fs-6 form-label">Harga</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Rp</span>
                                <app-money class="form-control" v-model="single.price" placeholder="Cth: 10.000"
                                v-bind="moneyConfig">
                            </app-money>
                            </div>
                            <div v-if="v$.single.price.$error" class="text-danger py-2">
                                Nama Tipe Produk Wajib diisi!
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn mx-3 btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn mx-3 btn-sm" style="background-color:#527D3C; color:white;" v-if="flag == 'insert'" @click="save">Simpan</button>
                        <button type="button" class="btn mx-3 btn-sm" style="background-color:#527D3C; color:white;" v-else @click="update">Update</button>
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
        required
    } from '@vuelidate/validators'
    export default {
        data() {
            return {
                v$: useVuelidate(),
                pageStatus: 'standby',
                token: '',
                moneyConfig: {
                    masked: false,
                    prefix: '',
                    suffix: '',
                    thousands: '.',
                    decimal: ',',
                    precision: 0,
                    disableNegative: false,
                    disabled: false,
                    min: null,
                    max: null,
                    allowBlank: false,
                    minimumNumberOfCharacters: 0,
                },
                flag: 'insert',
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center;width:8%',
                            },
                            {
                                text: 'NAMA TIPE',
                                style: 'text-align: left',
                            },
                            {
                                text: 'HARGA',
                                style: 'text-align: center',
                            },
                            {
                                text: 'STATUS',
                                style: 'text-align: center',
                            },
                            {
                                text: 'AKSI',
                                sort_column: false,
                                style: 'text-align: center;width:15%',
                            },
                        ],

                        data: [],
                    },
                    config: {
                        title: 'Datatable',
                        show_per_page: 10,
                        search: '',
                        order: 'desc',
                        sort_by: 'id',
                        total_data: 0,
                        current_page: 1,
                        loading: true,
                        show_search: true,
                    }
                },
                single: {
                    id: '',
                    name: '',
                    price: 0

                }
            }
        },
        validations() {
            return {
                single: {
                    name: {
                        required
                    },
                    price: {
                        required
                    }
                },
            }
        },
        mounted() {
            this.$initializeAppPlugins();
            this.token = localStorage.getItem('token');
            this.getDatatable()
        },
        methods: {
            getDatatable() {
                this.tableConfig.config.loading = true;
                this.tableConfig.feeder.data = [];

                let params = {
                    page: this.tableConfig.config.current_page,
                    length: this.tableConfig.config.show_per_page,
                    orderDir: this.tableConfig.config.order,
                    orderCol: this.tableConfig.config.sort_by,
                    search: this.tableConfig.config.search,
                }

                Api().get(`${this.$apiType('web')}master/product-type`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;
                        let meta = response.data.meta
                        this.tableConfig.feeder.data = data;
                        this.tableConfig.config.total_data = meta.total;

                        this.tableConfig.config.loading = false;
                    })
                    .catch(error => {

                        this.tableConfig.config.loading = false;

                        this.tableConfig.feeder.data = [];
                        this.tableConfig.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            tambahUmkm() {
                this.flag = 'insert'
                this.reset()
                $("#modal-add").modal("show");
            },
            edit(id){
                this.flag = 'edit'
                this.reset()
                this.$loaderShow()
                Api().get(`${this.$apiType('web')}master/product-type/${id}`)
                .then(response => {
                    let data = response?.data?.data
                    this.single.id = data?.id
                    this.single.name = data?.name
                    this.single.price = data?.price
                }).catch(err =>{
                    console.log(err)
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.$loaderHide()
                })
                $("#modal-add").modal("show")
            },
            switchStatus(id){
                this.$loaderShow();
                Api().put(`${this.$apiType('web')}master/product-type/${id}/change-status`)
                    .then(res => {
                        this.getDatatable();
                        toastr.success('Status berhasil diubah.');
                    })
                    .catch(err => {
                        this.$axiosHandleError(err);

                    })
                    .then(() => {
                        this.$loaderHide();
                    });
            },
            save(){
                this.flag = 'insert'
                $('#modal-add').modal('hide')
                this.$loaderShow()
                let param = {
                    name: this.single.name || '',
                    price: this.single.price || 0
                }
                Api().post(`${this.$apiType('web')}master/product-type`, param)
                .then(response => {
                    this.$swal({
                                title: "Berhasil!",
                                text: 'Menambahkan data Tipe Produk',
                                icon: "success",
                            }).then(result => {
                               this.getDatatable()

                            });
                }).catch(err => {
                    console.log(err)
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.$loaderHide()
                })
            },
            update(){
                this.flag = 'edit'
                $('#modal-add').modal('hide')
                this.$loaderShow()
                let param = {
                    name: this.single.name || '',
                    price: this.single.price || 0
                }
                Api().put(`${this.$apiType('web')}master/product-type/${this.single.id}`, param)
                .then(response => {
                    this.$swal({
                                title: "Berhasil!",
                                text: 'Mengubah data Tipe Produk',
                                icon: "success",
                            }).then(result => {
                               this.getDatatable()

                            });
                }).catch(err => {
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.$loaderHide()
                })
            },
            reset(){
                this.v$.$reset()
                this.single.name = ''
                this.single.price = ''
            }
        }
    }

</script>

<style scoped>
    #modal-detail th{
        background-color: #F5F8FA;
    }
    .form-switch .form-check-input:checked{
        background-color: #FFC700 !important;
    }


</style>
