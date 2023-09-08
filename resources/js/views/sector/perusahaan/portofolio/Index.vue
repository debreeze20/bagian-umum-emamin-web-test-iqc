<template>
    <div style="background:#fff;min-height:100vh;width:100%" class="pb-12">
        <template v-if="pageStatus == 'page-load'">
            <div class="d-flex justify-content-center" style="padding-top:80px !important;">
                <app-loader></app-loader>
            </div>
        </template>
        <template v-else>
            <app-navbar-landing-page></app-navbar-landing-page>
            <div class="d-flex justify-content-center align-items-center flex-column p-5"
                :style="`background: rgba(0, 0, 0, .3) url('${background}')`"
                style="background-size:cover;width:100%;background-position:center;min-height:400px;background-blend-mode:darken">
                <div class="fw-bolder text-white text-center" style="font-size:30px">Portfolio Perusahaan</div>
                <div class="fw-bolder text-white text-center" style="font-size:44px">{{data?.name}}</div>
            </div>
            <div style="background:#fff !important;">
                <div class="container pt-5">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div>
                            <div class="fs-1 text-gray-800 fw-bolder">{{data?.name}}</div>
                            <div class="fw-bolder" style="color:#7239EA">Tahun {{data?.yearNumber}}</div>
                        </div>
                        <div>
                            <button class="btn btn-light" style="background:#F5F8FA !important"
                                @click="$router.back()"><i class="fa fa-arrow-left"></i>&ensp;Kembali</button>
                        </div>
                    </div>
                    <div class="mb-12" style="padding-top:30px;">
                        <div v-html="data?.description"></div>
                    </div>
                    <div class="row mt-8">
                        <template v-for="(context, index) in data?.industryPortfolioFiles ?? []">
                        <div class="col-lg-4 col-md-6 mb-5"  v-if="context.fileType != 'banner'">
                            <img :src="`${context.link}`" style="border-radius:10px;" class="w-100" />
                        </div>
                    </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
    import Api from "@/services/api-landing-page";
    export default {
        data() {
            return {
                data: null,
                background: '',
                pageStatus: 'page-load',
            }
        },
        mounted() {
            this.$initializeAppPlugins();
            Api().get(`${this.$apiType('web')}transact/industry-portfolio/` + this.$route.params.id)
                .then(response => {
                    this.data = response.data.data;
                    let context = this.data;
                    let idxBanner = context.industryPortfolioFiles.findIndex((e) => e.fileType == 'banner');
                    if (idxBanner >= 0) {
                        this.background = context.industryPortfolioFiles[idxBanner].link +
                            `?token=${this.token}&date=${Math.random()}`;
                    }
                    this.pageStatus = 'standby';
                });
        },
        methods: {}
    }

</script>
