<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8; min-height: 100vh;">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            <!-- <app-sidebar></app-sidebar> -->
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="mt-20 d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <app-navbar></app-navbar>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid">
                            <!--begin::Content disini-->
                            <div class="row d-flex align-items-center mt-5 mb-6">
                                <div class="col-lg-8 align-items-center">
                                  <span class="fw-bolder fs-4">History Penjualan</span>&ensp;<a
                                    href="javascript:void(0)"
                                    @click="$router.back()"
                                    class="text-gray-500"
                                    >|&ensp;&ensp;Data Master -  UMKM </a
                                  >&ensp;-&ensp; History Penjualan
                                  <h1 style="font-size: 30px !important;" class="py-5  fw-bold">History Penjualan : {{ single.umkmName ?? '-' }} </h1>
                                </div>
                                <div class="col-lg-4 text-right justify-content-end d-flex">
                                  <button
                                  type="button"
                                  @click="$router.back()"
                                  class="btn btn-sm btn-white text-dark"
                                >
                                  <i class="fa fa-arrow-left text-dark"></i>&ensp;Kembali
                                </button>
                                </div>
                              </div>
                            <div class="card card-flush" id="kt_profile_details_view" >
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <div class="row align-items-center text-center mt-10 mb-5 px-10">
                                        <div class="col-md-6 ">
                                            <div class="p-6 border border-dashed  border-dark rounded">
                                                <h2 style="color: #527D3C;">
                                                    Total omset
                                                </h2>
                                                <h1 >Rp {{
                                                    loading ?  "Loading..."
                                                   :  $rupiahFormat(single.totalOmset) ?? '-'}}</h1>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-6 border border-dashed border-dark rounded">
                                                <h2 style="color: #527D3C;">
                                                    Total Permintaan
                                                </h2>
                                                <h1 >{{ loading ?  "Loading..."
                                                    : single.totalOrder ?? '-'}}</h1>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-5">
                                        <app-datatable :table_config="tableConfig" @change-page="getDataTable"
                                            v-model:show_per_page="tableConfig.config.show_per_page"
                                            v-model:search="tableConfig.config.search"
                                            v-model:order="tableConfig.config.order"
                                            v-model:sort_by="tableConfig.config.sort_by"
                                            v-model:current_page="tableConfig.config.current_page">
                                            <template v-slot:body>
                                                <tr v-for="(context,index) in tableConfig.feeder.data">
                                                    <td class="text-center">
                                                        {{index + ((parseInt(tableConfig.config.show_per_page) * (parseInt(tableConfig.config.current_page) - 1))) + 1}}
                                                    </td>
                                                    <td class="text-left">{{context.name}}</td>
                                                    <td class="text-left">{{ context.productType.map(data => data.name).join(', ') }}</td>
                                                    <td class="text-left">{{ context.totalQty}} Pcs</td>
                                                    <td class="text-left">Rp {{ $rupiahFormat(context.totalPrice)  }}</td>
                                                    <td class="text-center">
                                                            <button class="btn btn-secondary btn-xs "
                                                                type="button" 
                                                                style="padding:5px 10px !important;"
                                                                aria-expanded="false"  @click="detail(context.id)">
                                                                Detail
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

        <div class="modal fade" tabindex="-1" id="modal-detail">
            <div class="modal-dialog modal-dialog-centerd modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 text-left">
                            <h3 class="modal-title text-left" style="font-size:14px !important">
                                Detail Pengajuan
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
                        <div class="mb-5">
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Acara</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{single.event}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Tanggal Acara</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{single.dateEvent}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Tanggal Pengiriman</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{single.dateShipping}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Metode Pemesanan</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{single.orderMethod}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Kode Rekening</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{single.accountCode}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Dokumen Pendukung</h6>
                                </div>
                                <div class="col-md-4">
                                  <span style="font-size: 14px" class="fw-bolder">{{single.reference}}</span>
                                </div>
                                <div class="col-md-4">
                                  <div v-for="(context,index) in single.files" class="d-flex align-items-center py-2">
                                    <a :href="`${context?.link}?token=${token}`" target="_blank" :download="context?.name" class="btn btn-success btn-sm">
                                      <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1968_3942)"><path d="M1.83337 12.4167C1.83337 11.9583 2.29171 11.5 2.75004 11.5C3.20837 11.5 3.66671 11.9583 3.66671 12.4167C3.66671 12.7222 3.66671 14.25 3.66671 17C3.66671 18.0125 4.48752 18.8333 5.50004 18.8333H16.5C17.5126 18.8333 18.3334 18.0125 18.3334 17V12.4167C18.3334 11.9104 18.7438 11.5 19.25 11.5C19.7563 11.5 20.1667 11.9104 20.1667 12.4167V17C20.1667 19.025 18.5251 20.6667 16.5 20.6667H5.50004C3.475 20.6667 1.83337 19.025 1.83337 17C1.83337 14.25 1.83337 12.7222 1.83337 12.4167Z" fill="white"/><path d="M10.0833 13.3333C10.0833 13.8396 10.4937 14.25 11 14.25C11.5062 14.25 11.9166 13.8396 11.9166 13.3333L11.9166 2.33333C11.9166 1.82707 11.5062 1.41667 11 1.41667C10.4937 1.41667 10.0833 1.82707 10.0833 2.33333L10.0833 13.3333Z" fill="white"/><path d="M14.9352 9.01783C15.2931 8.65985 15.8735 8.65985 16.2315 9.01783C16.5895 9.37581 16.5895 9.95621 16.2315 10.3142L11.6482 14.8975C11.3034 15.2423 10.7492 15.2568 10.3868 14.9307L5.80345 10.8057C5.42715 10.467 5.39664 9.88743 5.73531 9.51113C6.07398 9.13483 6.65358 9.10432 7.02988 9.443L10.9668 12.9862L14.9352 9.01783Z" fill="white"/></g><defs><clipPath id="clip0_1968_3942"><rect width="22" height="22" fill="white" transform="translate(0 0.5)"/></clipPath></defs></svg>
                                  </a>
                                  <a :href="`${context?.link}?token=${token}&preview=1`" target="_blank" class="ms-5 btn btn-outline-success btn-sm" style="border:1px solid;">Lihat File</a>
                                  </div>
                                </div>
                              </div>
                              <h2 class="py-3 fw-normal" style="color: #527D3C; ">Informasi Pesanan Mamin</h2>
                              <table  class="table mb-0" style="width:100%;">
                                <thead class="py-10" style="background-color:#DBF4D8 !important;">
                                    <tr>
                                        <td colspan="2" class="p-1 ps-10 py-3"><h5>{{single.umkmName}}</h5></td>
                                        <td class="text-center p-1 py-3" style="width:20%;"><h5>QTY</h5></td>
                                        <td class="text-end p-1 pe-5 py-3" style="width:30%;"><h5>TOTAL HARGA</h5></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(context,index) in single.orderDetail">
                                        <tr>
                                            <td colspan="4" class="ps-10"><h6>{{ context?.productType?.name }} - Rp {{ $rupiahFormat(context?.productType?.price) }}</h6></td>
                                        </tr>
                                        <tr v-for="(val, i) in context?.orderHasUmkmProductTypeDetails">
                                            <td valign="middle" class="p-2 text-center" style="width:5%;">{{ i+1 }}</td>
                                            <td valign="middle" class="p-2">
                                                <div>{{ val?.subdistrict?.name }}</div>
                                                <div class="text-muted">{{val?.destinationAddress}}</div>
                                            </td>
                                            <td valign="middle" class="text-center p-2" style="width:20%;">{{ val?.qty }}</td>
                                            <td valign="middle" class="text-end p-2" style="width:30%;">Rp {{ $rupiahFormat(Number(val?.totalPrice)) }}</td>
                                        </tr>
                                        <tr style="background-color:#F5F8FA;" class="w-100">
                                            <td  class="p-2 text-end" colspan="2"><b>Sub Total - {{ context?.productType?.name }}</b></td>
                                            <td valign="middle" class="text-center p-2" style="width:20%;"><b>{{ $rupiahFormat(Number(countQtyProductTypes(index))) }}</b></td>
                                            <td valign="middle" class="text-end p-2" style="width:30%;"><b>Rp {{ $rupiahFormat(Number(context?.totalPrice)) }}</b></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            <div class="table-responsive" style="background-color:#DBF4D8;">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 " style="width: 41% !important;" colspan="2">
                                                <h5>Total Pesanan</h5>
                                            </td>
                                            <td style="width:20%;" class="px-1 text-center">
                                                <h5>{{totalOrderAll()}}</h5>
                                            </td>
                                            <td style="width:23.5%;" class="text-end px-5" colspan="3">
                                                <h5>Rp {{$rupiahFormat(single.totalPrice)}}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2" colspan="2">
                                                <h5>Pajak Daerah (10%)</h5>
                                            </td>
                                            <td class="text-end px-5" colspan="3">
                                                <h5>Rp {{$rupiahFormat(single?.totalTax)}}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2" colspan="4">
                                                <h4>TOTAL PEMBAYARAN</h4>
                                            </td>
                                            <td class="text-end px-5" colspan="2">
                                                <h5>Rp {{$rupiahFormat(single?.totalPayment)}}</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                token: localStorage.getItem('token'),
                v$: useVuelidate(),
                loading: false,
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center;width:8%',
                            },
                            {
                                text: 'ACARA',
                                style: 'text-align: left',
                            },
                            {
                                text: 'TIPE PRODUK',
                                style: 'text-align: left',
                            },
                            {
                                text: 'Total PRODUK',
                                style: 'text-align: left',
                            },
                            {
                                text: 'TOTAL PEMBAYARAN',
                                style: 'text-align: left',
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
                    total: '',
                    umkmName: '',                 
                    event: '',
                    address: '',
                    subdistrict: '',
                    dateEvent: '',
                    dateShipping:'',
                    orderMethod: '',
                    totalOrder: '',
                    totalPrice: '',
                    totalTax:'',
                    totalPayment:'',
                    id: '',
                    totalOrder: '',
                    totalOmset: '',
                    totalQty: '',
                    orderDetail: [],
                    accountCode: '',
                    reference: '',
                    files: null,
                }
            }
        },
        validations() {
            return {
                single: {
                    kbli: {
                        number: {
                            required
                        },
                        year: {
                            required
                        },
                        name: {
                            required
                        }
                    },
                },
            }
        },
        mounted() {
            this.$initializeAppPlugins();
           this.getDataTable();
           this.count();
        },

        methods: {
            getDataTable(){
                this.tableConfig.config.loading = true;
                this.tableConfig.feeder.data = [];

                let params = {
                    page: this.tableConfig.config.current_page,
                    length: this.tableConfig.config.show_per_page,
                    orderDir: this.tableConfig.config.order,
                    orderCol: this.tableConfig.config.sort_by,
                    search: this.tableConfig.config.search,
                  
                }
                Api().get(`${this.$apiType('web')}transact/history/${this.$route.params.id}`,{ params })
                .then(response =>{
                    let data = response.data.data;
                    let meta = response.data.meta
                        console.log(data);
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
            count(){
                this.loading = true
                Api().get(`${this.$apiType('web')}transact/history/count/${this.$route.params.id}`)
                .then(response =>{
                    let data = response?.data?.data;
                    this.single.totalOmset = data?.countOmset;
                    this.single.totalOrder = data?.countOrder;
                    this.single.umkmName = data?.umkm;
                    
                }).catch((err) =>{
                    this.$axiosHandleError(err)
                }).then(() => {
                    this.loading = false;
                })
            },
            detail(id) {
            this.$loaderShow();
            Api().get(`${this.$apiType("web")}transact/history/${this.$route.params.id}/submission/${id}`)
            .then((res) => {
            let that = this;
            let context = res?.data?.data;
            this.single.id =  context?.id;
            this.single.event = context?.name;
            this.single.dateEvent = context?.eventDate;
            this.single.accountCode = context?.accountCode?.name;
            this.single.reference = context?.referenceNumber;
            this.single.dateShipping = context?.deliveryDate;
            this.single.orderMethod = context?.orderMethod?.name;
            this.single.totalTax = context?.tax;
            this.single.totalPayment = context?.totalPriceWithTax;
            this.single.totalPrice = context?.totalPrice;
            this.single.umkmName = context?.orderHasUmkms[0]?.umkm?.name
            this.single.orderDetail = context?.orderHasUmkms[0].orderHasUmkmProductTypes;
            this.single.files = context?.files
            $("#modal-detail").modal("show");
            })
            .catch((err) => {
              console.log(err)
            this.$axiosHandleError(err);
            })
            .then(() => {
                this.$loaderHide();
            this.tableConfig.config.loading = false;
            });
        },
        totalOrderAll(){
            let that = this;

            let total = 0;
            this.single.orderDetail.forEach(function(item,index){
                item.orderHasUmkmProductTypeDetails?.forEach(function(val,i){
                    total += Number(val?.qty)
                })
            })
            return isNaN(total) ? 0 : total;
        },
        countQtyOrders(){
            let that = this;

            let total = 0;
            this?.single.orderDetail?.forEach(function(value, idx){
                value?.orderHasUmkmProductTypeDetails?.forEach(function(val,i){
                    total += Number(val?.qty);
                });
            });

            return isNaN(total) ? 0 : total;
        },
        countQtyProductTypes(index){
            let that = this;

            let total = 0;
            this?.single.orderDetail[index].orderHasUmkmProductTypeDetails?.forEach(function(val, i){
                total += Number(val?.qty);
            });

            return isNaN(total) ? 0 : total;
        },
        }
    }

</script>
