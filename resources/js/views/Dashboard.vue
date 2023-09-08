<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8; min-height: 100vh; ">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid" >
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
                            <div class="row">
                                <div class="col-lg-4" >
                                    <div class="card p-6 rounded" style="position: fixed;">
                                        <div id="chart">
                                            <apexchart type="pie" width="380" :options="status.chartOptions" :series="status.series"></apexchart>
                                          </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card p-6 mb-5">
                                        <div class="head d-flex align-items-center justify-content-between">
                                            <div class="kiri">
                                                <h1>Transaksi Bulanan</h1>
                                                <span class="text-gray-700">Statistik transaksi bulanan.</span>
                                            </div>
                                        <div class="kanan">
                                            <app-datepicker type="year" placeholder="Pilih Tahun" :format="'YYYY'" v-model:value="filter.year2" :clearable="false"
                                        :value-type="'YYYY'" :class="'w-100 py-5'" @change="chartTransaksi">
                                        </app-datepicker>
                                        </div>
                                        </div>
                                        <div id="chart" v-if="!loading">
                                            <apexchart type="line" height="350" :options="transaction.chartOptions" :series="transaction.series"></apexchart>
                                          </div>
                                          <template v-else>
                                            <div class="loader d-flex align-items-center justify-content-center"><app-loader></app-loader></div>
                                        </template>
                                    </div>
                                    <div class="card p-6 mb-5">
                                        <div class="head d-flex align-items-center justify-content-between">
                                            <div class="kiri">
                                                <h1>Jumlah Pesanan Sesuai Tipe Produk Bulanan</h1>
                                                <span class="text-gray-700">Statistik jumlah pesanan (Pcs) berdasarkan tipe produk </span>
                                            </div>
                                        <div class="kanan">
                                            <app-datepicker type="year" placeholder="Pilih Tahun" :format="'YYYY'" v-model:value="filter.year3" @change="chartTipeProduk" :clearable="false"
                                        :value-type="'YYYY'" :class="'w-100 py-5'">
                                        </app-datepicker>
                                        </div>
                                        </div>
                                        <div id="chart" v-if="!loading1">
                                            <apexchart type="line" height="350" :options="productType.chartOptions" :series="productType.series"></apexchart>
                                          </div>
                                          <template v-else>
                                            <div class="loader d-flex align-items-center justify-content-center"><app-loader></app-loader></div>
                                        </template>
                                    </div>
                                    <div class="card p-6 mb-5">
                                        <div class="head d-flex align-items-center justify-content-between">
                                            <div class="kiri">
                                                <h1>Jumlah Pesanan Bulanan</h1>
                                                <span class="text-gray-700">Statistik transaksi bulanan.</span>
                                            </div>
                                        <div class="kanan">
                                            <app-datepicker type="year" v-model:value="filter.year1" placeholder="Pilih Tahun" :format="'YYYY'" :clearable="false"
                                        :value-type="'YYYY'" :class="'w-100 py-5'" @change="chartPesanan">
                                        </app-datepicker>
                                        </div>
                                        </div>
                                        <div id="chart" v-if="!loading2">
                                            <apexchart type="line" height="350" :options="totalTransaction.chartOptions" :series="totalTransaction.series"></apexchart>
                                        </div>
                                        <template v-else>
                                            <div class="loader d-flex align-items-center justify-content-center"><app-loader></app-loader></div>
                                        </template>
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
                filter: {
                    year1: `${new Date().getFullYear()}`,
                    year2: `${new Date().getFullYear()}`,
                    year3: `${new Date().getFullYear()}`,
                },
                listTransaksi: [],
                listPesanan :[],
                listTipeProduk: [],
                loading : false,
                loading1: false,
                loading2 :false,
                status: {  
                series: [],
                chartOptions: {
                    colors: ['#FB9D24','#9CD795'],
                    chart: {
                    width: 380,
                    type: 'pie',
                    },
                    labels: ['MBR', 'Non MBR'],
                    responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                        width: 200
                        },
                        legend: {
                        position: 'right'
                        }
                    }
                    }]
                },
                },
                transaction: {
                series: [{
                    name: "Nilai Transaksi Bulanan",
                    data: []
                },
                {
                    name: "Nilai Transaksi Komulatif",
                    data: []
                }
                ],
                chartOptions: {
                    labels : [],
                    chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'straight'
                    },
                    tooltip: {
                    enabled: true,
                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    offsetY: 30,
                    offsetX: 60
                    },
                    legend: {
                    horizontalAlign: 'center',
                    offsetX: 40
                    },
                    grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                    },
                    yaxis: {
                    labels: {
                    formatter: function (value) {
                        if(value < 1000000){
                        var parts = value.toString().split(".");
                        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return 'Rp' + ' ' + parts.join(".");
                        }else {
                            var formatter = value / 1000000;
                            var parts = formatter.toString().split(".");
                            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            return parts.join(".") + 'jt';
                        }
                    },
                    },
                },
                    xaxis: {
                    categories: [],
                    }
                },
                },
                productType: {
                series: [],
                chartOptions: {
                    chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'straight'
                    },
                    tooltip: {
                    enabled: true,
                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    offsetY: 30,
                    offsetX: 60
                    },
                    legend: {
                    horizontalAlign: 'center',
                    offsetX: 40
                    },
                    grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                    },
                    xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec'],
                    }
                },
                },
                totalTransaction: {
                series: [{
                    name: "Jumlah Pesanan Bulanan",
                    data: []
                },
                {
                    name: 'Komulatif',
                    data: []
                }
                ],
                chartOptions: {
                    labels : [],
                    chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    },
                    dataLabels: {
                    enabled: false
                    },
                    stroke: {
                    curve: 'straight'
                    },
                    tooltip: {
                    enabled: true,
                    position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                    offsetY: 30,
                    offsetX: 60
                    },
                    legend: {
                    horizontalAlign: 'center',
                    offsetX: 40,
                    colors: ['#FB9D24','#9CD795']
                    },
                    grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                    },
                    xaxis: {
                    categories: [],
                    }
                },
                },
            }
        },
        mounted() {
    
            this.$initializeAppPlugins();
            this.token = localStorage.getItem('token');
            this.chartStatusUmkm()
            this.chartPesanan()
            this.chartTransaksi()
            this.chartTipeProduk()
        },
        methods: {
            chartStatusUmkm(){
                Api().get(`${this.$apiType('web')}dashboard/status-umkm`)
                .then(response => {
                    let data = response?.data?.data
                    this.status.series[0] = data?.mbr || 0
                    this.status.series[1] = data?.nonMbr || 0
                }).catch(err => {
                    this.$axiosHandleError(err)
                })
            },
            chartTipeProduk(){
                let that = this
                this.loading1 = true
                Api().get(`${this.$apiType('web')}dashboard/transaction-product?year=${this.filter.year3}`)
                .then(response =>{
                    let data = response?.data?.data;
                        that.productType.series = []
                        $.each(data, function(i,val){
                            let existData = that.productType.series.findIndex(value => value?.name == val?.productTypeName);
                            if(existData == -1){
                                that.productType.series.push({
                                    name: val?.productTypeName,
                                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                                });
                            }
                            let newData = that.productType.series.findIndex(value => value?.name == val?.productTypeName);
                            that.productType.series[newData].data[Number(val?.month)-1] = val?.total;
                        });                    
                }).catch(err => {
                    this.$axiosHandleError(err)
                }).then(()=> {
                    this.loading1 = false
                })
            },
            chartTransaksi(){
                let that = this
                this.loading = true
                Api().get(`${this.$apiType('web')}dashboard/transaction?year=${this.filter.year2}`)
                .then(response => {
                    let data = response?.data?.data
                    this.listTransaksi = data
                    let categories = []
                    this.transaction.series[0].data = []
                    this.transaction.series[1].data = []
                    let monthNames = [
                        "Jan", "Feb", "Mar", "Apr", "May", "June",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                    ];

                    this.listTransaksi.transaction.forEach(function(val, i) {
                        that.transaction.series[0].data.push(val?.totalPayment);

                        // Memeriksa apakah nilai bulan valid
                        if (val?.month >= 1 && val?.month <= 12) {
                            let monthLabel = monthNames[val?.month - 1]; // Mengambil nama bulan sesuai indeks
                            categories.push(monthLabel);
                        }
                    });

                    this.listTransaksi.jumlahKumulatif.forEach(function(val, i) {
                        that.transaction.series[1].data.push(val?.kumulatif);
                    });

                    this.transaction.chartOptions.xaxis.categories = categories;
                }).catch(err => {
                    console.log(err)
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.loading = false
                })
            },
            chartPesanan(){
                let that = this
                this.loading2 = true
                Api().get(`${this.$apiType('web')}dashboard/transaction-order?year=${this.filter.year1}`)
                .then(response => {
                    let data = response?.data?.data
                    this.listPesanan = data
                    let categories = []
                    this.totalTransaction.series[0].data = []
                    this.totalTransaction.series[1].data = []
                    let monthNames = [
                        "Jan", "Feb", "Mar", "Apr", "May", "June",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                    ];
                    this.listPesanan.order.forEach(function(val,i){
                        that.totalTransaction.series[0].data.push(val?.totalQty)
                        if (val?.month >= 1 && val?.month <= 12) {
                            let monthLabel = monthNames[val?.month - 1]; // Mengambil nama bulan sesuai indeks
                            categories.push(monthLabel);
                        }
                    })
                    this.listPesanan.jumlahKumulatif.forEach(function(val,i){
                        that.totalTransaction.series[1].data.push(val?.kumulatif)
                    })
                    this.totalTransaction.chartOptions.xaxis.categories = categories
                }).catch(err => {
                    this.$axiosHandleError(err)
                    console.log(err)
                }).then(()=>{
                    this.loading2 = false
                })
            }

        }
    }

</script>

<style scoped>
    #modal-detail th{
        background-color: #F5F8FA;
    }
 

</style>
