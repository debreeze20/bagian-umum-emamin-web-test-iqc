<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8; min-height:100vh;">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid" >
            <!--begin::Wrapper-->
            <div class="mt-20 d-flex flex-column flex-row-fluid" id="kt_wrapper" >
                <!--begin::Header-->
                <app-navbar></app-navbar>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid" style="margin-top: 115px;">
                            
                            <!--begin::Content disini-->
                           
                            <div class="card card-flush" id="kt_profile_details_view" >
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <div class="card-header border-0 pt-5 align-items-center">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bolder text-dark mb-2">Rekap Pengajuan</span>
                                            <span class="text-gray-500 fs-4">
                                                Silahkan mengisi form berikut untuk membuat laporan.
                                            </span>
                                        </h3>
                                        
                                    </div>
                                    <div class="card-body pt-5">
                                        <div class="row py-5">
                                            <div class="col-md-4">
                                              <h6 class="text-dark">Tanggal Acara</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <app-datepicker type="date" placeholder="Pilih tanggal"
                                                    :format="'DD/MM/YYYY'" v-model:value="eventDate" :value-type="'YYYY-MM-DD'" :range="true" :class="'w-100'"
                                                   >
                                                </app-datepicker>
                                            </div>
                                          </div>
                                        <div class="row py-5">
                                            <div class="col-md-4">
                                              <h6 class="text-dark">Tanggal Pengiriman</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <app-datepicker type="date" placeholder="Pilih tanggal"
                                                    :format="'DD/MM/YYYY'" v-model:value="deliveryDate" :value-type="'YYYY-MM-DD'" :range="true" :class="'w-100'"
                                                    >
                                                </app-datepicker>
                                            </div>
                                          </div>
                                        <div class="row py-5">
                                            <div class="col-md-4">
                                              <h6 class="text-dark">UMKM</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <app-select-multiple v-model="single.umkm"
                                                :placeholder="'Pilih UMKM'"
                                                :loading="pageStatus == 'umkm'"
                                                @change-search="getUmkm" :options="listUmkm"
                                                :serverside="true"></app-select-multiple>
                                            </div>
                                          </div>
                                        <div class="row py-5">
                                            <div class="col-md-4">
                                              <h6 class="text-dark">Metode Pembayaran</h6>
                                            </div>
                                            <div class="col-md-4">
                                                <app-select-multiple v-model="single.payment"
                                                :placeholder="'Pilih Metode Pembayaran'"
                                                :loading="pageStatus == 'payment'"
                                                @change-search="getPayment" :options="listPayment"
                                                :serverside="true"></app-select-multiple>
                                            </div>
                                          </div>
                                          <div class="py-3">
                                            <btn class="btn text-white" style="background-color: #527D3C !important; color:#fff " @click="report">
                                                Export Excel
                                            </btn>
                                          </div>
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

        
  
    </div>
</template>

<script>
    import Api from "@/services/api";
    export default {
        data() {
            return {
                pageStatus: 'standby',
                token: localStorage.getItem('token'),
                listUmkm: [],
                listPayment: [],
                eventDate: ['',''],
                deliveryDate : ['',''],
                single: {
                    umkm : [],
                    payment: []
                }
              
            }
        },

        mounted() {
            this.$initializeAppPlugins();

            this.token = localStorage.getItem('token');
            
        },
        methods: {
            getPayment(keyword,limit){
                this.pageStatus = 'payment'
                Api().get(`${this.$apiType('global')}select-list/order-method?search=${keyword}&limit=${limit}`)
                .then(response => {
                    this.listPayment = []
                    for(let i = 0; i<response?.data?.data.length; i++){
                        this.listPayment.push({
                            id: response.data?.data[i]?.id,
                            text: response?.data?.data[i].name
                        })
                    }
                    
                }).catch(err =>{
                    this.listPayment = []
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.pageStatus = 'standby'
                })
            },
            getUmkm(limit,keyword){
                this.pageStatus = 'umkm'
                Api().get(`${this.$apiType('global')}select-list/umkm?search=${keyword}&limit=${limit}`)
                .then(response => {
                    this.listUmkm = []
                    for(let i = 0; i<response?.data?.data.length; i++){
                        this.listUmkm.push({
                            id: response.data?.data[i]?.id,
                            text: response?.data?.data[i].name
                        })
                    }
                    console.log(this.listUmkm)
                }).catch(err =>{
                    this.listUmkm = []
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.pageStatus = 'standby'
                })
            },
            report(){
                this.$loaderShow()
                let umkm =[]
                let payment = []

                for(let i=0; i<this.single.payment.length; i++){
                    payment.push(this.single.payment[i].id)
                }
                for(let i=0; i<this.single.umkm.length; i++){
                    umkm.push(this.single.umkm[i].id)
                }
                let params = {
                    orderMethodId: payment,
                    umkmId: umkm,
                    deliveryStartDate : this.deliveryDate[0],
                    deliveryEndDate: this.deliveryDate[1],
                    eventStartDate :this.eventDate[0],
                    eventEndDate : this.eventDate[1]

                }
                Api().get(`${this.$apiType('web')}report/submission`, {
                        responseType: 'blob',
                        params: params
                    })
                    .then(response => {
                        const url = window.URL.createObjectURL(new Blob([response.data]));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'Rekap Pengajuan.xlsx');
                        document.body.appendChild(link);
                        link.click();
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$loaderHide();
                    });
            }
          
    }
}

</script>

<style scoped>
    #modal-detail th{
        background-color: #F5F8FA;
    }
 

</style>
