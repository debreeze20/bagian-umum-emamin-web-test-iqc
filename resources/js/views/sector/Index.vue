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
                :style="`background: rgba(0, 0, 0, .3) url('${single.background}')`"
                style="background-size:cover;width:100%;background-position:center;min-height:400px;background-blend-mode:darken">
                <div class="fw-bolder text-white text-center" style="font-size:30px">Subsektor</div>
                <div class="fw-bolder text-white text-center" style="font-size:44px">{{single.name}}
                </div>
            </div>
            <div class="container">
                <div class="fs-1 fw-bolder text-center pt-12" style="font-size:36px !important;">Daftar Industri
                    {{ single.name }}</div>
                <div class="text-center fs-5 pt-4 text-gray-600" style="line-height:2;">{{ single.description }}</div>
                <div class="d-flex mb-8 mt-12 align-items-center border p-5" style="border-radius:5px">
                    <div class="me-5"><i class="fa fa-search" style="font-size:18px"></i></div>
                    <input type="text" placeholder="Cari nama merek dagang, nama perusahaan" class="form-control"
                        v-model="search" autocomplete="off" @input="changeSearch"
                        style="border:0 !important;box-shadow:unset !important;outline:none !important;padding:0 !important" />
                </div>
                <template v-if="pageStatus == 'industry-load'">
                    <div class="d-flex justify-content-center" style="padding-top:80px !important;">
                        <app-loader></app-loader>
                    </div>
                </template>
                <div class="row" v-else>
                    <div class="text-gray-600 text-center pt-10 pb-10" v-if="listData.length == 0">Tidak Ada Data</div>
                    <div class="col-lg-4 col-md-6 mb-5" v-for="context in listData">
                        <div class="p-5 c-pointer" @click="$router.push({path:'/sector/perusahaan/' + context.id})"
                            style="background: #FFFFFF;box-shadow: 0px 0px 20px rgba(76, 87, 125, 0.04);border-radius: 12px;height:100%">
                            <img :src="context.industryLogoFile ? context.industryLogoFile.link : `${$assetUrl()}extends/images/noimage.png`"
                                style="width:60px;height:60px;border-radius:5px;" class="mb-5" />
                            <div class="fw-bolder fs-4">{{context.trademarkName}}</div>
                            <div class="pt-2 text-gray-600">{{context.name}}</div>
                            <div v-if="context.websiteLink" class="d-flex align-items-center pt-5">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.36 14C16.44 13.34 16.5 12.68 16.5 12C16.5 11.32 16.44 10.66 16.36 10H19.74C19.9 10.64 20 11.31 20 12C20 12.69 19.9 13.36 19.74 14M14.59 19.56C15.19 18.45 15.65 17.25 15.97 16H18.92C17.9512 17.6683 16.4141 18.932 14.59 19.56ZM14.34 14H9.66C9.56 13.34 9.5 12.68 9.5 12C9.5 11.32 9.56 10.65 9.66 10H14.34C14.43 10.65 14.5 11.32 14.5 12C14.5 12.68 14.43 13.34 14.34 14ZM12 19.96C11.17 18.76 10.5 17.43 10.09 16H13.91C13.5 17.43 12.83 18.76 12 19.96ZM8 8H5.08C6.03886 6.32721 7.5748 5.06149 9.4 4.44C8.8 5.55 8.35 6.75 8 8ZM5.08 16H8C8.35 17.25 8.8 18.45 9.4 19.56C7.57862 18.9317 6.04485 17.6677 5.08 16ZM4.26 14C4.1 13.36 4 12.69 4 12C4 11.31 4.1 10.64 4.26 10H7.64C7.56 10.66 7.5 11.32 7.5 12C7.5 12.68 7.56 13.34 7.64 14M12 4.03C12.83 5.23 13.5 6.57 13.91 8H10.09C10.5 6.57 11.17 5.23 12 4.03ZM18.92 8H15.97C15.657 6.76146 15.1936 5.5659 14.59 4.44C16.43 5.07 17.96 6.34 18.92 8ZM12 2C6.47 2 2 6.5 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C5.85752 19.9997 6.95991 20.7362 8.17317 21.2388C9.38642 21.7413 10.6868 22 12 22C14.6522 22 17.1957 20.9464 19.0711 19.0711C20.9464 17.1957 22 14.6522 22 12C22 10.6868 21.7413 9.38642 21.2388 8.17317C20.7362 6.95991 19.9997 5.85752 19.0711 4.92893C18.1425 4.00035 17.0401 3.26375 15.8268 2.7612C14.6136 2.25866 13.3132 2 12 2Z"
                                        fill="#3F4254" />
                                </svg>

                                <div class="ps-3"><a target="_blank" @click.stop="console.log('work')"
                                        :href="context.websiteLink">{{context.websiteLink}}</a></div>
                            </div>
                            <div class="d-flex flex-wrap mt-8">
                                <a @click.stop="console.log('work')" v-if="context.twitterLink" class="me-3"
                                    :href="context.twitterLink" target="_blank"><svg width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M21.75 5.96017C21.0328 6.26954 20.2524 6.4922 19.4485 6.57892C20.2831 6.08306 20.9081 5.2997 21.2063 4.37579C20.4231 4.8417 19.5651 5.16841 18.6703 5.34142C18.2964 4.94163 17.8441 4.62315 17.3417 4.40581C16.8392 4.18847 16.2974 4.07693 15.75 4.07813C13.5352 4.07813 11.7539 5.87345 11.7539 8.07657C11.7539 8.38595 11.7914 8.69532 11.8524 8.99298C8.53596 8.81954 5.57815 7.23517 3.61174 4.80938C3.25344 5.42137 3.06568 6.1182 3.06799 6.82735C3.06799 8.21485 3.77346 9.43829 4.84924 10.1578C4.21527 10.1329 3.59614 9.9586 3.04221 9.64923V9.69845C3.04221 11.6414 4.41565 13.2516 6.24612 13.6219C5.90243 13.7112 5.54887 13.7568 5.19377 13.7578C4.93362 13.7578 4.68752 13.732 4.43909 13.6969C4.94534 15.2813 6.41956 16.432 8.17502 16.4695C6.80159 17.5453 5.08127 18.1781 3.21331 18.1781C2.87815 18.1781 2.56877 18.1664 2.24768 18.1289C4.01956 19.2656 6.1219 19.9219 8.38596 19.9219C15.736 19.9219 19.7578 13.8328 19.7578 8.54767C19.7578 8.37423 19.7578 8.20079 19.7461 8.02735C20.5242 7.45782 21.2063 6.75235 21.75 5.96017Z"
                                            fill="#308CD9" />
                                    </svg>
                                </a>
                                <a @click.stop="console.log('work')" v-if="context.facebookLink" class="me-3"
                                    :href="context.facebookLink" target="_blank">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2311_33680)">
                                            <path
                                                d="M24 12.0735C24 5.40447 18.6269 -0.00152588 11.9999 -0.00152588C5.36995 -2.58789e-05 -0.00305176 5.40448 -0.00305176 12.075C-0.00305176 18.1005 4.38595 23.0955 10.1219 24.0015V15.564H7.07695V12.075H10.1249V9.41247C10.1249 6.38697 11.9174 4.71597 14.6579 4.71597C15.9719 4.71597 17.3444 4.95147 17.3444 4.95147V7.92147H15.8309C14.3414 7.92147 13.8764 8.85297 13.8764 9.80847V12.0735H17.2034L16.6724 15.5625H13.8749V24C19.6109 23.094 24 18.099 24 12.0735Z"
                                                fill="#3890FB" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2311_33680">
                                                <rect width="24" height="24" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                <a @click.stop="console.log('work')" v-if="context.instagramLink" class="me-3"
                                    :href="context.instagramLink" target="_blank">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.465 1.066C8.638 1.012 9.012 1 12 1C14.988 1 15.362 1.013 16.534 1.066C17.706 1.119 18.506 1.306 19.206 1.577C19.939 1.854 20.604 2.287 21.154 2.847C21.714 3.396 22.146 4.06 22.422 4.794C22.694 5.494 22.88 6.294 22.934 7.464C22.988 8.639 23 9.013 23 12C23 14.988 22.987 15.362 22.934 16.535C22.881 17.705 22.694 18.505 22.422 19.205C22.146 19.9391 21.7133 20.6042 21.154 21.154C20.604 21.714 19.939 22.146 19.206 22.422C18.506 22.694 17.706 22.88 16.536 22.934C15.362 22.988 14.988 23 12 23C9.012 23 8.638 22.987 7.465 22.934C6.295 22.881 5.495 22.694 4.795 22.422C4.06092 22.146 3.39582 21.7133 2.846 21.154C2.28638 20.6047 1.85331 19.9399 1.577 19.206C1.306 18.506 1.12 17.706 1.066 16.536C1.012 15.361 1 14.987 1 12C1 9.012 1.013 8.638 1.066 7.466C1.119 6.294 1.306 5.494 1.577 4.794C1.85372 4.06008 2.28712 3.39531 2.847 2.846C3.39604 2.2865 4.06047 1.85344 4.794 1.577C5.494 1.306 6.294 1.12 7.464 1.066H7.465ZM16.445 3.046C15.285 2.993 14.937 2.982 12 2.982C9.063 2.982 8.715 2.993 7.555 3.046C6.482 3.095 5.9 3.274 5.512 3.425C4.999 3.625 4.632 3.862 4.247 4.247C3.88205 4.60205 3.60118 5.03428 3.425 5.512C3.274 5.9 3.095 6.482 3.046 7.555C2.993 8.715 2.982 9.063 2.982 12C2.982 14.937 2.993 15.285 3.046 16.445C3.095 17.518 3.274 18.1 3.425 18.488C3.601 18.965 3.882 19.398 4.247 19.753C4.602 20.118 5.035 20.399 5.512 20.575C5.9 20.726 6.482 20.905 7.555 20.954C8.715 21.007 9.062 21.018 12 21.018C14.938 21.018 15.285 21.007 16.445 20.954C17.518 20.905 18.1 20.726 18.488 20.575C19.001 20.375 19.368 20.138 19.753 19.753C20.118 19.398 20.399 18.965 20.575 18.488C20.726 18.1 20.905 17.518 20.954 16.445C21.007 15.285 21.018 14.937 21.018 12C21.018 9.063 21.007 8.715 20.954 7.555C20.905 6.482 20.726 5.9 20.575 5.512C20.375 4.999 20.138 4.632 19.753 4.247C19.3979 3.88207 18.9657 3.60121 18.488 3.425C18.1 3.274 17.518 3.095 16.445 3.046ZM10.595 15.391C11.3797 15.7176 12.2534 15.7617 13.0669 15.5157C13.8805 15.2697 14.5834 14.7489 15.0556 14.0422C15.5278 13.3356 15.7401 12.4869 15.656 11.6411C15.572 10.7953 15.197 10.005 14.595 9.405C14.2112 9.02148 13.7472 8.72781 13.2363 8.54515C12.7255 8.36248 12.1804 8.29536 11.6405 8.34862C11.1006 8.40187 10.5792 8.57418 10.1138 8.85313C9.64845 9.13208 9.25074 9.51074 8.9493 9.96185C8.64786 10.413 8.45019 10.9253 8.37052 11.462C8.29084 11.9986 8.33115 12.5463 8.48854 13.0655C8.64593 13.5847 8.91648 14.0626 9.28072 14.4647C9.64496 14.8668 10.0938 15.1832 10.595 15.391ZM8.002 8.002C8.52702 7.47697 9.15032 7.0605 9.8363 6.77636C10.5223 6.49222 11.2575 6.34597 12 6.34597C12.7425 6.34597 13.4777 6.49222 14.1637 6.77636C14.8497 7.0605 15.473 7.47697 15.998 8.002C16.523 8.52702 16.9395 9.15032 17.2236 9.8363C17.5078 10.5223 17.654 11.2575 17.654 12C17.654 12.7425 17.5078 13.4777 17.2236 14.1637C16.9395 14.8497 16.523 15.473 15.998 15.998C14.9377 17.0583 13.4995 17.654 12 17.654C10.5005 17.654 9.06234 17.0583 8.002 15.998C6.94166 14.9377 6.34597 13.4995 6.34597 12C6.34597 10.5005 6.94166 9.06234 8.002 8.002ZM18.908 7.188C19.0381 7.06527 19.1423 6.91768 19.2143 6.75397C19.2863 6.59027 19.3248 6.41377 19.3274 6.23493C19.33 6.05609 19.2967 5.87855 19.2295 5.71281C19.1622 5.54707 19.0624 5.39651 18.936 5.27004C18.8095 5.14357 18.6589 5.04376 18.4932 4.97652C18.3275 4.90928 18.1499 4.87598 17.9711 4.87858C17.7922 4.88119 17.6157 4.91965 17.452 4.9917C17.2883 5.06374 17.1407 5.1679 17.018 5.298C16.7793 5.55103 16.6486 5.88712 16.6537 6.23493C16.6588 6.58274 16.7992 6.91488 17.0452 7.16084C17.2911 7.40681 17.6233 7.54723 17.9711 7.5523C18.3189 7.55737 18.655 7.42669 18.908 7.188Z"
                                            fill="#E14586" />
                                    </svg>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-12 pt-12">
                    <app-pagination :total_data="totalPage" @change-page="getData" :limit="9" :loading="pageStatus == 'industry-load'"
                        v-model:current_page="currentPage"></app-pagination>
                </div>
            </div>
        </template> </div>
</template>
<script>
    import Api from "@/services/api-landing-page";
    export default {
        data() {
            return {
                pageStatus: 'page-load',
                listData: [],
                totalPage: 0,
                currentPage: 1,
                search: '',
                single: {
                    background: '',
                    name: '',
                    description: '',
                }
            }
        },
        mounted() {
            this.getDetail();

        },
        methods: {
            changeSearch: _.debounce(function ($event) {
                this.currentPage = 1;
                this.getData();
            }, 1000),
            getDetail() {
                Api().get(`${this.$apiType('web')}master/industry-sector/${this.$route.params.id}`)
                    .then(response => {
                        let context = response.data.data;
                        this.single.name = context.name;
                        this.single.description = context.description;
                        this.single.background = context.industrySectorFile ? context.industrySectorFile.link : '';
                        this.getData();
                    });
            },
            getData() {
                this.pageStatus = 'industry-load';
                let params = {
                    search: this.search,
                    length: 9,
                    page: this.currentPage,
                    onlyHasApproved: 1,
                    industrySectorId: this.$route.params.id,
                }
                Api().get(`${this.$apiType('web')}transact/industry/open`, {
                        params
                    })
                    .then(response => {
                        let context = response.data;
                        this.listData = context.data;

                        this.totalPage = context.meta.total;
                        this.pageStatus = 'standby';
                    });
            }
        }
    }

</script>
