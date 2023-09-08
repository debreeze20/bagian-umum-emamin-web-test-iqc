<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8; min-height: 100vh; ">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
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
                        <div id="kt_content_container" class="container-fluid " style="margin-top: 100px;">

                            <!--begin::Content disini-->

                            <div class="card card-flush" id="kt_profile_details_view">
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <div class="card-header border-0 pt-5 align-items-center">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder text-dark mb-2">Data Pengajuan</span>
                                        </h3>
                                        <button type="button" class="btn h-50" style="background-color: #527D3C;"
                                            @click="$router.push({name: 'tambah-pengajuan'})">
                                            <span class="text-white">Tambah Data</span>
                                        </button>
                                    </div>
                                    <div class="card-body pt-5">
                                        <app-datatable :table_config="tableConfig" @change-page="getDataTable"
                                            v-model:show_per_page="tableConfig.config.show_per_page"
                                            v-model:search="tableConfig.config.search"
                                            v-model:order="tableConfig.config.order"
                                            v-model:sort_by="tableConfig.config.sort_by"
                                            v-model:current_page="tableConfig.config.current_page">
                                            <template v-slot:body>
                                                <tr v-for="(context, index) in tableConfig.feeder.data">
                                                    <td class="text-center">
                                                        {{ index + ((parseInt(tableConfig.config.show_per_page) *
                                                            (parseInt(tableConfig.config.current_page) - 1))) + 1 }}
                                                    </td>
                                                    <td class="text-left">{{ context.referenceNumber || '-' }}</td>
                                                    <td class="text-left">
                                                        <div>{{ context.name || '-' }}</div>
                                                    </td>
                                                    <td class="text-left">
                                                        <span v-for="(val, i) in context?.productType">{{ val?.name }}<span v-if="i != context?.productType?.length-1">, </span></span>
                                                    </td>
                                                    <td class="text-left">Rp {{ $rupiahFormat(context.totalPrice) || '-' }}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Aksi</button>
                                                            <ul class="dropdown-menu" style="cursor:pointer;">
                                                                <li><h6 class="dropdown-header p-3" style="color:black;">Pilih Aksi:</h6></li>
                                                                <li><a @click="getDetail(context?.id)" class="dropdown-item text-gray-700 p-3">
                                                                    <svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M14.6666 8.00065C14.6666 4.31875 11.6819 1.33398 7.99998 1.33398C4.31808 1.33398 1.33331 4.31875 1.33331 8.00065C1.33331 11.6825 4.31808 14.6673 7.99998 14.6673C11.6819 14.6673 14.6666 11.6825 14.6666 8.00065Z" fill="#7E8299"/><path d="M7.33331 7.33398V10.6673C7.33331 11.0355 7.63179 11.334 7.99998 11.334C8.36817 11.334 8.66665 11.0355 8.66665 10.6673V7.33398C8.66665 6.96579 8.36817 6.66732 7.99998 6.66732C7.63179 6.66732 7.33331 6.96579 7.33331 7.33398Z" fill="#7E8299"/><path d="M7.99998 4.66667C7.63179 4.66667 7.33331 4.96514 7.33331 5.33333C7.33331 5.70152 7.63179 6 7.99998 6C8.36817 6 8.66665 5.70152 8.66665 5.33333C8.66665 4.96514 8.36817 4.66667 7.99998 4.66667Z" fill="#7E8299"/></svg>
                                                                    Detail Pengajuan
                                                                </a></li>
                                                                <li><a @click="$router.push({path: `/edit-pengajuan/${context?.id}`})" class="dropdown-item text-gray-700 p-3">
                                                                    <svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M14.2667 5.56942L12.8273 7.00806L8.99 3.17074L10.4287 1.73136C10.6832 1.47688 11.0284 1.33398 11.3883 1.33398C11.7483 1.33398 12.0935 1.47688 12.348 1.73136L14.2667 3.65007C14.5211 3.90461 14.6641 4.24977 14.6641 4.6097C14.6641 4.96963 14.5211 5.31488 14.2667 5.56942ZM2.458 14.6221L6.59133 13.2441L2.754 9.40674L1.37599 13.54C1.32543 13.691 1.31802 13.8532 1.35459 14.0081C1.39116 14.1631 1.47027 14.3048 1.583 14.4172C1.69572 14.5297 1.8376 14.6084 1.99266 14.6446C2.14772 14.6808 2.3098 14.673 2.46066 14.6221H2.458Z" fill="#7E8299"/><path d="M3.71599 14.2007L2.46132 14.6193C2.3106 14.6695 2.14888 14.6767 1.99428 14.6402C1.83968 14.6037 1.69829 14.5249 1.58593 14.4126C1.47356 14.3003 1.39467 14.159 1.35806 14.0044C1.32145 13.8498 1.32858 13.6881 1.37865 13.5374L1.79732 12.282L3.71599 14.2007ZM2.75665 9.40397L6.59399 13.2413L12.83 7.00529L8.99265 3.16797L2.75665 9.40397Z" fill="#7E8299"/></svg>
                                                                    Edit Data
                                                                </a></li>
                                                            </ul>
                                                        </div>
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
                        <div v-if="detail?.loading" class="loader d-flex align-items-center justify-content-center"><app-loader></app-loader></div>
                        <div v-else class="mb-5">
                            <div class="row py-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Acara</h6>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 14px" class="fw-bolder">{{ detail?.data?.name }}</span>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Tanggal Acara</h6>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 14px" class="fw-bolder">{{ $moment(detail?.data?.eventDate).format('DD-MM-YYYY') }}</span>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Tanggal Pengiriman</h6>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 14px" class="fw-bolder">{{ $moment(detail?.data?.deliveryDate).format('DD-MM-YYYY') }}</span>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Metode Pemesanan</h6>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 14px" class="fw-bolder">{{ detail?.data?.orderMethod?.name }}</span>
                                </div>
                            </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Kode Rekening</h6>
                                </div>
                                <div class="col-md-8">
                                    <span style="font-size: 14px" class="fw-bolder">{{ detail?.data?.accountCode?.name }}</span>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-md-4">
                                    <h6 class="text-gray-600">Dokumen Pendukung</h6>
                                </div>
                                <div class="col-md-8 d-flex align-items-start justify-content-between">
                                    <span style="font-size: 14px" class="fw-bolder">{{ detail?.data?.referenceNumber }}</span>
                                    <div>
                                        <div v-for="(context, index) in detail?.data?.files" class="d-flex align-items-center py-2">
                                            <a :href="`${context?.link}?token=${token}`" target="_blank" :download="context?.name" class="btn btn-success btn-sm">
                                                <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1968_3942)"><path d="M1.83337 12.4167C1.83337 11.9583 2.29171 11.5 2.75004 11.5C3.20837 11.5 3.66671 11.9583 3.66671 12.4167C3.66671 12.7222 3.66671 14.25 3.66671 17C3.66671 18.0125 4.48752 18.8333 5.50004 18.8333H16.5C17.5126 18.8333 18.3334 18.0125 18.3334 17V12.4167C18.3334 11.9104 18.7438 11.5 19.25 11.5C19.7563 11.5 20.1667 11.9104 20.1667 12.4167V17C20.1667 19.025 18.5251 20.6667 16.5 20.6667H5.50004C3.475 20.6667 1.83337 19.025 1.83337 17C1.83337 14.25 1.83337 12.7222 1.83337 12.4167Z" fill="white"/><path d="M10.0833 13.3333C10.0833 13.8396 10.4937 14.25 11 14.25C11.5062 14.25 11.9166 13.8396 11.9166 13.3333L11.9166 2.33333C11.9166 1.82707 11.5062 1.41667 11 1.41667C10.4937 1.41667 10.0833 1.82707 10.0833 2.33333L10.0833 13.3333Z" fill="white"/><path d="M14.9352 9.01783C15.2931 8.65985 15.8735 8.65985 16.2315 9.01783C16.5895 9.37581 16.5895 9.95621 16.2315 10.3142L11.6482 14.8975C11.3034 15.2423 10.7492 15.2568 10.3868 14.9307L5.80345 10.8057C5.42715 10.467 5.39664 9.88743 5.73531 9.51113C6.07398 9.13483 6.65358 9.10432 7.02988 9.443L10.9668 12.9862L14.9352 9.01783Z" fill="white"/></g><defs><clipPath id="clip0_1968_3942"><rect width="22" height="22" fill="white" transform="translate(0 0.5)"/></clipPath></defs></svg>
                                            </a>
                                            <a :href="`${context?.link}?token=${token}&preview=1`" target="_blank" class="ms-5 btn btn-outline-success btn-sm" style="border:1px solid;">Lihat File</a>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="table-pesanan mt-5">
                                    <table v-for="(context, index) in detail?.data?.orderHasUmkms" class="table mb-0" style="width:100%;">
                                        <thead style="background-color:#DBF4D8 !important;">
                                            <tr>
                                                <td colspan="2" class="p-3" ><h5>{{ context?.umkm?.name }}</h5></td>
                                                <td class="text-center p-3" style="width:20%;"><h5>QTY</h5></td>
                                                <td class="text-end p-3" style="width:30%;"><h5>TOTAL HARGA</h5></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(value, idx) in context?.orderHasUmkmProductTypes">
                                                <tr>
                                                    <td class="p-3" colspan="4"><h6>{{ value?.productType?.name }} - Rp {{ $rupiahFormat(value?.productType?.price) }}</h6></td>
                                                </tr>
                                                <tr v-for="(val, i) in value?.orderHasUmkmProductTypeDetails">
                                                    <td valign="middle" class="p-3" style="width:5%;">{{ i+1 }}</td>
                                                    <td valign="middle" class="p-3">
                                                        <div>{{ val?.subdistrict?.name }}</div>
                                                        <div class="text-muted">{{val?.destinationAddress}}</div>
                                                    </td>
                                                    <td valign="middle" class="text-center p-3" style="width:20%;">{{ val?.qty }}</td>
                                                    <td valign="middle" class="text-end p-3" style="width:30%;">Rp {{ $rupiahFormat(Number(val?.totalPrice)) }}</td>
                                                </tr>
                                                <tr style="background-color:#F5F8FA;">
                                                    <td valign="middle" class="p-3" colspan="2"><b>Sub Total - {{ value?.productType?.name }}</b></td>
                                                    <td valign="middle" class="text-center p-3" style="width:20%;"><b>{{ $rupiahFormat(Number(countQtyProductTypes(index, idx))) }}</b></td>
                                                    <td valign="middle" class="text-end p-3" style="width:30%;"><b>Rp {{ $rupiahFormat(Number(value?.totalPrice)) }}</b></td>
                                                </tr>
                                            </template>
                                            <tr style="background-color:#F5F8FA;">
                                                <td valign="middle" class="p-3" colspan="2"><b>Grand Total - {{ context?.umkm?.name }}</b></td>
                                                <td valign="middle" class="text-center p-3" style="width:20%;"><b>{{ $rupiahFormat(Number(countQtyOrders(index))) }}</b></td>
                                                <td valign="middle" class="text-end p-3" style="width:30%;"><b>Rp {{ $rupiahFormat(Number(context?.totalPrice)) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="table-responsive" style="background-color:#DBF4D8;">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td class="px-2 " style="width: 41% !important;" colspan="2">
                                                <h5>Total Pesanan</h5>
                                            </td>
                                            <td style="width:20%;" class="px-3 text-center">
                                                <h5>{{ totalOrderAll() }}</h5>
                                            </td>
                                            <td style="width:23.5%;" class="text-end px-5" colspan="3">
                                                <h5>Rp {{ $rupiahFormat(detail?.data?.totalPrice) }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2" colspan="2">
                                                <h5>Pajak Daerah (10%)</h5>
                                            </td>
                                            <td class="text-end px-5" colspan="3">
                                                <h5>Rp {{ $rupiahFormat(detail?.data?.tax) }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-2" colspan="4">
                                                <h4>TOTAL PEMBAYARAN</h4>
                                            </td>
                                            <td class="text-end px-5" colspan="2">
                                                <h5>Rp {{ $rupiahFormat(detail?.data?.totalPriceWithTax) }}</h5>
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
export default {
    data() {
        return {
            DEFAULT_PASSWORD: '',
            pageStatus: 'standby',
            token: '',
            dropzoneFile: null,
            listErrorImport: [],
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
            token: '',
            tableConfig: {
                feeder: {
                    column: [{
                        text: 'NO',
                        sort_column: false,
                        style: 'text-align: center;width:8%',
                    },
                    {
                        text: 'No Surat',
                        sort_column: false,
                        style: 'text-align: left',
                    },
                    {
                        text: 'ACARA',
                        sort_column: false,
                        style: 'text-align: left',
                    },
                    {
                        text: 'TIPE PRODUK',
                        sort_column: false,
                        style: 'text-align: left',
                    },
                    {
                        text: 'TOTAL PEMBAYARAN',
                        sort_column: false,
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
            detail: {
                loading: false,
                data: '',
            }
        }
    },
    mounted() {
        this.getDataTable();
    },
    methods: {
        getDataTable() {
            let that = this;

            let params = {
                page: this.tableConfig.config.current_page,
                length: this.tableConfig.config.show_per_page,
                orderBy: this.tableConfig.config.order,
                sortBy: this.tableConfig.config.sort_by,
                search: this.tableConfig.config.search,
            }

            this.tableConfig.config.loading = true;
            Api().get(`${this.$apiType('web')}transact/submission`, {params})
                .then(res => {
                    let data = res?.data?.data;
                    let meta = res.data.meta;
                    this.tableConfig.feeder.data = data;
                    this.tableConfig.config.total_data = meta.total;
                })
                .catch(err => {
                    console.log(err);
                    this.tableConfig.feeder.data = [];
                    this.tableConfig.config.total_data = 0;
                    this.$axiosHandleError(err);
                })
                .then(() => {
                    this.tableConfig.config.loading = false;
                });
        },
        getDetail(id){
            $('#modal-detail').modal('show');
            this.detail.loading = true;
            Api().get(`${this.$apiType('web')}transact/submission/${id}`)
                .then(res => {
                    let data = res?.data?.data;
                    this.detail.data = data;
                })
                .catch(err => {
                    this.$axiosHandleError(err);
                })
                .then(() => {
                    this.detail.loading = false;
                });
        },
        totalOrderAll(){
            let that = this;

            let total = 0;
            this?.detail?.data?.orderHasUmkms?.forEach(function(item, index){
                item?.orderHasUmkmProductTypes?.forEach(function(value, idx){
                    value?.orderHasUmkmProductTypeDetails?.forEach(function(val, i){
                        total += Number(val?.qty);
                    });
                });
            });

            return isNaN(total) ? 0 : total;
        },
        countQtyOrders(){
            let that = this;

            let total = 0;
            this?.detail?.data?.orderHasUmkms[index]?.orderHasUmkmProductTypes?.forEach(function(value, idx){
                value?.orderHasUmkmProductTypeDetails?.forEach(function(val,i){
                    total += Number(val?.qty);
                });
            });

            return isNaN(total) ? 0 : total;
        },
        countQtyProductTypes(index, idx){
            let that = this;

            let total = 0;
            this?.detail?.data?.orderHasUmkms[index]?.orderHasUmkmProductTypes[idx]?.orderHasUmkmProductTypeDetails?.forEach(function(val, i){
                total += Number(val?.qty);
            });

            return isNaN(total) ? 0 : total;
        },
    }
}

</script>

<style scoped>#modal-detail th {
    background-color: #F5F8FA;
}</style>
