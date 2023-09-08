<template>
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Aside-->
            <app-sidebar></app-sidebar>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <app-navbar></app-navbar>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::Content disini-->

                            <div class="card card-flush" id="kt_profile_details_view">
                                <div class="card card-xl-stretch mb-5 mb-xl-8">
                                    <div class="card-body pt-5">
                                        <div class="border p-3 mb-5" style="border-radius:15px">
                                            <div class="d-flex justify-content-center flex-wrap">
                                                <div @click="flagTab = 'identitas-perusahaan';getDetail()"
                                                    :class="flagTab == 'identitas-perusahaan' ? 'active' : ''"
                                                    class="py-3 px-8 c-pointer fw-bolder custom-tab-header">Identitas
                                                    Perusahaan</div>
                                                <div @click="flagTab = 'kbli';getDataTableKbli()"
                                                    :class="flagTab == 'kbli' ? 'active' : ''"
                                                    class="py-3 px-8 c-pointer fw-bolder custom-tab-header">Data NIB dan
                                                    KBLI</div>
                                                <div @click="flagTab = 'portofolio';getDataPortofolio()"
                                                    :class="flagTab == 'portofolio' ? 'active' : ''"
                                                    class="py-3 px-8 c-pointer fw-bolder custom-tab-header">Portfolio
                                                </div>
                                            </div>
                                        </div>
                                        <div v-show="flagTab == 'identitas-perusahaan'">
                                            <template v-if="loadDetailIndustry">
                                                <div class="d-flex justify-content-center mt-12 mb-12">
                                                    <app-loader></app-loader>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="row">
                                                    <div class="col-lg-2 mb-5">
                                                        <img :src="`${single.detail.logoUrl}?token=${token}`"
                                                            style="width:120px;height:120px" />
                                                    </div>
                                                    <div class="col-lg-10 mb-5">
                                                        <div class="fw-bolder fs-1">
                                                            {{$noNullable(single.detail.trademarkName)}}</div>
                                                        <div class="d-flex flex-wrap">
                                                            <div class="d-flex align-items-center mt-2 me-5">
                                                                <div>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3" fill-rule="evenodd"
                                                                            clip-rule="evenodd"
                                                                            d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z"
                                                                            fill="#7E8299" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z"
                                                                            fill="#7E8299" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z"
                                                                            fill="#7E8299" />
                                                                    </svg>

                                                                </div>
                                                                <div class="ps-2 text-gray-700">NIB
                                                                    {{$noNullable(single.detail.nib)}}</div>
                                                            </div>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <div>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M17.4999 7.89998L14.7999 14.8L13.3999 13.3999C14.1999 12.5999 14.1999 11.4001 13.3999 10.6001C12.5999 9.80006 11.3999 9.80006 10.5999 10.6001L9.19995 9.19991L16.0999 6.49996C16.9999 6.19996 17.7999 6.99998 17.4999 7.89998ZM12.7 11.3C12.3 10.9 11.6999 10.9 11.2999 11.3C10.8999 11.7 10.8999 12.2999 11.2999 12.6999C11.6999 13.0999 12.3 13.0999 12.7 12.6999C13.1 12.2999 13.1 11.7 12.7 11.3Z"
                                                                            fill="#7E8299" />
                                                                        <path opacity="0.3"
                                                                            d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM16.1 6.5L9.20001 9.19995L6.5 16.1001C6.2 17.0001 6.99999 17.8 7.89999 17.5L14.8 14.8L17.5 7.90002C17.8 7.00002 17 6.2 16.1 6.5Z"
                                                                            fill="#7E8299" />
                                                                    </svg>


                                                                </div>
                                                                <div class="ps-2 text-gray-700">
                                                                    {{$noNullable(single.detail.address)}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-wrap">
                                                            <div class="d-flex align-items-center mt-2 me-5">
                                                                <div>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3"
                                                                            d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"
                                                                            fill="#7E8299" />
                                                                        <path
                                                                            d="M12.0001 22C14.6001 22 17.0001 21 18.7001 19.4C17.9001 16.9 15.2001 15 12.0001 15C8.80006 15 6.10005 16.9 5.30005 19.4C7.00005 21 9.40006 22 12.0001 22Z"
                                                                            fill="#7E8299" />
                                                                    </svg>


                                                                </div>
                                                                <div class="ps-2 text-gray-700">
                                                                    {{$noNullable(single.detail.ownerName)}}</div>
                                                            </div>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <div>
                                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3"
                                                                            d="M7.14287 11.6655C7.06259 11.7457 6.95737 11.7963 6.84453 11.8088C6.57008 11.8393 6.32287 11.6416 6.29237 11.3671L5.76917 6.65829C5.76509 6.62159 5.76509 6.58455 5.76917 6.54786C5.79967 6.2734 6.04688 6.07563 6.32133 6.10613L11.0302 6.62933C11.143 6.64187 11.2482 6.69244 11.3285 6.77272C11.5238 6.96798 11.5238 7.28457 11.3285 7.47983L9.94279 8.86554L11.4443 10.367C11.6395 10.5623 11.6395 10.8788 11.4443 11.0741L10.7371 11.7812C10.5419 11.9765 10.2253 11.9765 10.03 11.7812L8.52858 10.2798L7.14287 11.6655Z"
                                                                            fill="#7E8299" />
                                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                                            d="M12.0799 14.7841L14.284 12.58C14.8927 11.9713 15.0436 11.0414 14.6586 10.2714L14.5337 10.0216C14.1487 9.25165 14.2996 8.32171 14.9084 7.71299L17.6412 4.98019C17.8364 4.78492 18.153 4.78492 18.3483 4.98019C18.3863 5.01819 18.4179 5.06207 18.4419 5.11013L19.5459 7.31808C20.3905 9.00719 20.0594 11.0472 18.7241 12.3826L12.7252 18.3814C11.2717 19.8349 9.12167 20.3425 7.17154 19.6925L4.75706 18.8876C4.49509 18.8003 4.35351 18.5171 4.44083 18.2552C4.46538 18.1815 4.50673 18.1146 4.56162 18.0597L7.21289 15.4085C7.82161 14.7997 8.75156 14.6488 9.52153 15.0338L9.77129 15.1587C10.5413 15.5437 11.4712 15.3928 12.0799 14.7841Z"
                                                                            fill="#7E8299" />
                                                                    </svg>


                                                                </div>
                                                                <div class="ps-2 text-gray-700">
                                                                    {{$noNullable(single.detail.phone)}}</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-wrap mt-3">
                                                            <span
                                                                class="badge badge-light-success me-3">{{$noNullable(single.detail.industryType)}}</span>
                                                            <span
                                                                class="badge badge-light-info">{{ $noNullable(single.detail.industrySector.toString()) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="fs-3 fw-bolder">
                                                            {{ $noNullable(single.detail.name) }}
                                                        </div>
                                                        <div class="pt-3 text-gray-800">
                                                            {{$noNullable(single.detail.description)}}</div>
                                                        <div class="fs-6 pt-5" style="font-weight:500">Koordinat Alamat
                                                            Industri</div>
                                                        <div class="mb-2" style="width:100%;height:400px;" id="map">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="p-5"
                                                            style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                            <div class="fw-bolder fs-2">Rp
                                                                {{ $rupiahFormat(single.detail.omzet) }}</div>
                                                            <div class="text-gray-600 pt-1">Omset Perbulan</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="p-5"
                                                            style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                            <div class="fw-bolder fs-2">
                                                                {{$noNullable(single.detail.industryAge)}} Tahun</div>
                                                            <div class="text-gray-600 pt-1">Usaha sudah berjalan</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mb-3">
                                                        <div class="p-5"
                                                            style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                            <div class="fw-bolder fs-2">
                                                                {{$noNullable(single.detail.employeeCount)}}
                                                                {{ $noNullable(single.detail.employeeType) }}</div>
                                                            <div class="text-gray-600 pt-1">Jumlah Karyawan</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="p-5"
                                                            style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                            <div class="fw-bolder fs-2">
                                                                {{ $noNullable(single.detail.hasIndustryLegality) }},
                                                                <span class="fs-7"
                                                                    style="font-weight:normal !important">{{$noNullable(single.detail.industryLegalityNote)}}</span>
                                                            </div>
                                                            <div class="text-gray-600 pt-1">Berbadan Hukum</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="p-5"
                                                            style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                            <div class="fw-bolder fs-2">
                                                                {{ $noNullable(single.detail.marketingTool) }}</div>
                                                            <div class="text-gray-600 pt-1">Memasarkan produk/jasa baik
                                                                secara daring/luring </div>
                                                        </div>
                                                    </div>
                                                    <div class="border p-5 mb-5" style="border-radius:5px">
                                                        <div style="color:#7239EA" class="fw-bolder fs-2">Situs
                                                            Penjualan
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3"
                                                            v-if="single.detail.website">
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M16.36 14C16.44 13.34 16.5 12.68 16.5 12C16.5 11.32 16.44 10.66 16.36 10H19.74C19.9 10.64 20 11.31 20 12C20 12.69 19.9 13.36 19.74 14M14.59 19.56C15.19 18.45 15.65 17.25 15.97 16H18.92C17.9512 17.6683 16.4141 18.932 14.59 19.56ZM14.34 14H9.66C9.56 13.34 9.5 12.68 9.5 12C9.5 11.32 9.56 10.65 9.66 10H14.34C14.43 10.65 14.5 11.32 14.5 12C14.5 12.68 14.43 13.34 14.34 14ZM12 19.96C11.17 18.76 10.5 17.43 10.09 16H13.91C13.5 17.43 12.83 18.76 12 19.96ZM8 8H5.08C6.03886 6.32721 7.5748 5.06149 9.4 4.44C8.8 5.55 8.35 6.75 8 8ZM5.08 16H8C8.35 17.25 8.8 18.45 9.4 19.56C7.57862 18.9317 6.04485 17.6677 5.08 16ZM4.26 14C4.1 13.36 4 12.69 4 12C4 11.31 4.1 10.64 4.26 10H7.64C7.56 10.66 7.5 11.32 7.5 12C7.5 12.68 7.56 13.34 7.64 14M12 4.03C12.83 5.23 13.5 6.57 13.91 8H10.09C10.5 6.57 11.17 5.23 12 4.03ZM18.92 8H15.97C15.657 6.76146 15.1936 5.5659 14.59 4.44C16.43 5.07 17.96 6.34 18.92 8ZM12 2C6.47 2 2 6.5 2 12C2 14.6522 3.05357 17.1957 4.92893 19.0711C5.85752 19.9997 6.95991 20.7362 8.17317 21.2388C9.38642 21.7413 10.6868 22 12 22C14.6522 22 17.1957 20.9464 19.0711 19.0711C20.9464 17.1957 22 14.6522 22 12C22 10.6868 21.7413 9.38642 21.2388 8.17317C20.7362 6.95991 19.9997 5.85752 19.0711 4.92893C18.1425 4.00035 17.0401 3.26375 15.8268 2.7612C14.6136 2.25866 13.3132 2 12 2Z"
                                                                        fill="#3F4254" />
                                                                </svg>
                                                            </div>
                                                            <div class="ps-3 fs-6">
                                                                <a :href="single.detail.website"
                                                                    target="_blank">{{single.detail.website}}</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3"
                                                            v-if="single.detail.marketingLink">
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12 13C10.6739 13 9.40215 12.4732 8.46447 11.5355C7.52678 10.5979 7 9.32608 7 8H9C9 8.79565 9.31607 9.55871 9.87868 10.1213C10.4413 10.6839 11.2044 11 12 11C12.7956 11 13.5587 10.6839 14.1213 10.1213C14.6839 9.55871 15 8.79565 15 8H17C17 9.32608 16.4732 10.5979 15.5355 11.5355C14.5979 12.4732 13.3261 13 12 13ZM12 3C12.7956 3 13.5587 3.31607 14.1213 3.87868C14.6839 4.44129 15 5.20435 15 6H9C9 5.20435 9.31607 4.44129 9.87868 3.87868C10.4413 3.31607 11.2044 3 12 3ZM19 6H17C17 5.34339 16.8707 4.69321 16.6194 4.08658C16.3681 3.47995 15.9998 2.92876 15.5355 2.46447C15.0712 2.00017 14.52 1.63188 13.9134 1.3806C13.3068 1.12933 12.6566 1 12 1C10.6739 1 9.40215 1.52678 8.46447 2.46447C7.52678 3.40215 7 4.67392 7 6H5C3.89 6 3 6.89 3 8V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V8C21 7.46957 20.7893 6.96086 20.4142 6.58579C20.0391 6.21071 19.5304 6 19 6Z"
                                                                        fill="#3F4254" />
                                                                </svg>

                                                            </div>
                                                            <div class="ps-3 fs-6">
                                                                <a :href="single.detail.marketingLink"
                                                                    target="_blank">{{single.detail.marketingLink}}</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3"
                                                            v-if="single.detail.twitter">
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M22.46 6C21.69 6.35 20.86 6.58 20 6.69C20.88 6.16 21.56 5.32 21.88 4.31C21.05 4.81 20.13 5.16 19.16 5.36C18.37 4.5 17.26 4 16 4C13.65 4 11.73 5.92 11.73 8.29C11.73 8.63 11.77 8.96 11.84 9.27C8.28001 9.09 5.11001 7.38 3.00001 4.79C2.63001 5.42 2.42001 6.16 2.42001 6.94C2.42001 8.43 3.17001 9.75 4.33001 10.5C3.62001 10.5 2.96001 10.3 2.38001 10V10.03C2.38001 12.11 3.86001 13.85 5.82001 14.24C5.19074 14.4122 4.5301 14.4362 3.89001 14.31C4.16162 15.1625 4.69355 15.9084 5.41103 16.4429C6.1285 16.9775 6.99546 17.2737 7.89001 17.29C6.37364 18.4904 4.494 19.1393 2.56001 19.13C2.22001 19.13 1.88001 19.11 1.54001 19.07C3.44001 20.29 5.70001 21 8.12001 21C16 21 20.33 14.46 20.33 8.79C20.33 8.6 20.33 8.42 20.32 8.23C21.16 7.63 21.88 6.87 22.46 6Z"
                                                                        fill="#3F4254" />
                                                                </svg>

                                                            </div>
                                                            <div class="ps-3 fs-6">
                                                                <a :href="single.detail.twitter"
                                                                    target="_blank">{{single.detail.twitter}}</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3"
                                                            v-if="single.detail.facebook">
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z"
                                                                        fill="#3F4254" />
                                                                </svg>

                                                            </div>
                                                            <div class="ps-3 fs-6">
                                                                <a :href="single.detail.facebook"
                                                                    target="_blank">{{single.detail.facebook}}</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mt-3"
                                                            v-if="single.detail.instagram">
                                                            <div>
                                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M12 2C14.717 2 15.056 2.01 16.122 2.06C17.187 2.11 17.912 2.277 18.55 2.525C19.21 2.779 19.766 3.123 20.322 3.678C20.8305 4.1779 21.224 4.78259 21.475 5.45C21.722 6.087 21.89 6.813 21.94 7.878C21.987 8.944 22 9.283 22 12C22 14.717 21.99 15.056 21.94 16.122C21.89 17.187 21.722 17.912 21.475 18.55C21.2247 19.2178 20.8311 19.8226 20.322 20.322C19.822 20.8303 19.2173 21.2238 18.55 21.475C17.913 21.722 17.187 21.89 16.122 21.94C15.056 21.987 14.717 22 12 22C9.283 22 8.944 21.99 7.878 21.94C6.813 21.89 6.088 21.722 5.45 21.475C4.78233 21.2245 4.17753 20.8309 3.678 20.322C3.16941 19.8222 2.77593 19.2175 2.525 18.55C2.277 17.913 2.11 17.187 2.06 16.122C2.013 15.056 2 14.717 2 12C2 9.283 2.01 8.944 2.06 7.878C2.11 6.812 2.277 6.088 2.525 5.45C2.77524 4.78218 3.1688 4.17732 3.678 3.678C4.17767 3.16923 4.78243 2.77573 5.45 2.525C6.088 2.277 6.812 2.11 7.878 2.06C8.944 2.013 9.283 2 12 2ZM12 7C10.6739 7 9.40215 7.52678 8.46447 8.46447C7.52678 9.40215 7 10.6739 7 12C7 13.3261 7.52678 14.5979 8.46447 15.5355C9.40215 16.4732 10.6739 17 12 17C13.3261 17 14.5979 16.4732 15.5355 15.5355C16.4732 14.5979 17 13.3261 17 12C17 10.6739 16.4732 9.40215 15.5355 8.46447C14.5979 7.52678 13.3261 7 12 7ZM18.5 6.75C18.5 6.41848 18.3683 6.10054 18.1339 5.86612C17.8995 5.6317 17.5815 5.5 17.25 5.5C16.9185 5.5 16.6005 5.6317 16.3661 5.86612C16.1317 6.10054 16 6.41848 16 6.75C16 7.08152 16.1317 7.39946 16.3661 7.63388C16.6005 7.8683 16.9185 8 17.25 8C17.5815 8 17.8995 7.8683 18.1339 7.63388C18.3683 7.39946 18.5 7.08152 18.5 6.75ZM12 9C12.7956 9 13.5587 9.31607 14.1213 9.87868C14.6839 10.4413 15 11.2044 15 12C15 12.7956 14.6839 13.5587 14.1213 14.1213C13.5587 14.6839 12.7956 15 12 15C11.2044 15 10.4413 14.6839 9.87868 14.1213C9.31607 13.5587 9 12.7956 9 12C9 11.2044 9.31607 10.4413 9.87868 9.87868C10.4413 9.31607 11.2044 9 12 9Z"
                                                                        fill="#3F4254" />
                                                                </svg>

                                                            </div>
                                                            <div class="ps-3 fs-6">
                                                                <a :href="single.detail.instagram"
                                                                    target="_blank">{{single.detail.instagram}}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="border p-5" style="border-radius:5px">
                                                        <div style="color:#7239EA" class="fw-bolder fs-2">Pemilik
                                                        </div>
                                                        <div class="row mt-5">
                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{ $noNullable(single.detail.ownerName) }}</div>
                                                                    <div class="text-gray-600">Nama Lengkap</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{$noNullable(single.detail.email)}}
                                                                    </div>
                                                                    <div class="text-gray-600">Email</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{$noNullable(single.detail.phone)}}</div>
                                                                    <div class="text-gray-600">Telepon</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{ $noNullable(single.detail.age) }} tahun</div>
                                                                    <div class="text-gray-600">Usia</div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{$noNullable(single.detail.lastEducation)}}
                                                                    </div>
                                                                    <div class="text-gray-600">Pendidikan Terakhir</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{$noNullable(single.detail.ownerJobStatus)}}
                                                                    </div>
                                                                    <div class="text-gray-600">Status pekerjaan
                                                                        berkaitan
                                                                        dengan Industri Kreatif </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mb-3">
                                                                <div class="p-5"
                                                                    style="border:1px dashed #eff2f5!important;border-radius: 5px;">
                                                                    <div class="fs-3 fw-bolder">
                                                                        {{$noNullable(single.detail.ownerAddress)}}
                                                                    </div>
                                                                    <div class="text-gray-600">Alamat Tempat Tinggal
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <template v-if="flagTab == 'kbli'">
                                            <div class="fs-2 fw-bolder text-gray-700">Daftar KBLI Perusahaan</div>
                                            <div class="fw-bolder pb-5" style="color:#7239EA">Nomor NIB:
                                                {{$noNullable(single.detail.nib)}}
                                            </div>
                                            <app-datatable :table_config="tableConfig" @change-page="getDataTableKbli"
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
                                                        <td class="text-left">{{context.code}}</td>
                                                        <td class="text-left">{{context.name}}</td>
                                                        <td>{{context.yearNumber}}</td>
                                                        <td class="text-center">

                                                            <button class="btn btn-secondary btn-xs mx-2" type="button"
                                                                @click="editKbli(context.id)"
                                                                style="padding:5px 10px !important;">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M11.9607 6.0805L6.38415 11.9762C6.21888 12.1509 5.98897 12.2499 5.74846 12.2499L3.20857 12.2499C2.72532 12.2499 2.33357 11.8582 2.33357 11.3749L2.33357 8.81264C2.33357 8.58536 2.422 8.367 2.58015 8.20378L8.21459 2.38837C8.55085 2.04131 9.1048 2.03255 9.45187 2.36882C9.45518 2.37202 9.45847 2.37526 9.46172 2.37852L11.9437 4.86051C12.2787 5.19552 12.2862 5.73631 11.9607 6.0805Z"
                                                                        fill="#7E8299" />
                                                                </svg>

                                                            </button>
                                                            <button class="btn btn-secondary btn-xs mx-2" type="button"
                                                                @click="deleteKbli(context.id)"
                                                                style="padding:5px 10px !important;">
                                                                <svg width="14" height="14" viewBox="0 0 14 14"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M3.5 4.66675V11.9584C3.5 12.4417 3.89175 12.8334 4.375 12.8334H9.625C10.1082 12.8334 10.5 12.4417 10.5 11.9584V4.66675H3.5Z"
                                                                        fill="#7E8299" />
                                                                    <path opacity="0.3" fill-rule="evenodd"
                                                                        clip-rule="evenodd"
                                                                        d="M8.1665 2.625V2.33333C8.1665 2.01117 7.90534 1.75 7.58317 1.75H6.4165C6.09434 1.75 5.83317 2.01117 5.83317 2.33333V2.625H3.20817C3.04709 2.625 2.9165 2.75558 2.9165 2.91667V3.20833C2.9165 3.36942 3.04709 3.5 3.20817 3.5H10.7915C10.9526 3.5 11.0832 3.36942 11.0832 3.20833V2.91667C11.0832 2.75558 10.9526 2.625 10.7915 2.625H8.1665Z"
                                                                        fill="#7E8299" />
                                                                </svg>


                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </app-datatable>
                                        </template>
                                        <template v-if="flagTab == 'portofolio'">
                                            <div class="fs-2 fw-bolder text-gray-700">Daftar Portofolio Sambel Dede
                                                Satoe</div>
                                            <div class="fw-bolder pb-3" style="color:#7239EA">Nomor NIB:
                                                {{$noNullable(single.detail.nib)}}
                                            </div>
                                            <div class="row mt-5">
                                                <template v-if="loadPortofolio">
                                                    <div class="d-flex justify-content-center mt-8">
                                                        <app-loader></app-loader>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="row mt-5">
                                                        <div class="col-lg-3 mb-8"
                                                            v-for="(context, index) in listDataPortofolio">
                                                            <div class="w-100 c-pointer"
                                                                @click="redirectPortofolio(context.id)"
                                                                style="background: #FFFFFF;box-shadow: 0px 1px 24px rgba(0, 0, 0, 0.08);height: 100%;">
                                                                <img :src="context.industryPortfolioFileCover ? `${context.industryPortfolioFileCover.link}?token=${token}` : ''"
                                                                    style="width:100%;height:130px;object-position: center;object-fit:cover;border-radius:5px" />
                                                                <div class="p-3">
                                                                    <div class="fs-6 text-gray-800">{{context.name}}
                                                                    </div>
                                                                    <div style="color:#7239ea" class="fw-bolder pb-2">
                                                                        Tahun
                                                                        {{context.yearNumber}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
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

        <div class="modal fade" tabindex="-1" id="modal-form-kbli">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 text-center">
                            <h3 class="modal-title text-center" style="font-size:18px !important;">
                                Edit Data KBLI</h3>
                            <div class="text-gray-500">Silahkan lengkapi form berikut untuk
                                memperbarui data</div>
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
                        <div class="mb-3">
                            <label class="form-label fs-6"
                                :class="v$.single.kbli.number.$error ? 'text-danger' : ''">Nomor KBLI</label>
                            <input class="form-control" type="text" v-model="single.kbli.number" placeholder="Cth: 4108"
                                autocomplete="off" />
                            <div v-if="v$.single.kbli.number.$error" class="text-danger"> Nomor KBLI tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6" :class="v$.single.kbli.name.$error ? 'text-danger' : ''">Nama
                                KBLI</label>
                            <input class="form-control" type="text" v-model="single.kbli.name"
                                placeholder="Cth: Aktifitas Hukum" autocomplete="off" />
                            <div v-if="v$.single.kbli.name.$error" class="text-danger"> Nama KBLI tidak boleh kosong!
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fs-6"
                                :class="v$.single.kbli.year.$error ? 'text-danger' : ''">Tahun</label>
                            <app-datepicker type="year" placeholder="Pilih tahun" :format="'YYYY'" :value-type="'YYYY'"
                                v-model:value="single.kbli.year">
                            </app-datepicker>
                            <div v-if="v$.single.kbli.year.$error" class="text-danger"> Tahun tidak boleh kosong!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light text-dark" data-bs-dismiss="modal">Batal</button>
                        <button class="btn bg-primary-custom" type="button" @click="updateKbli">
                            <span class="indicator-label text-dark">Simpan</span>
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
        required
    } from '@vuelidate/validators'
    export default {
        data() {
            return {
                flagTab: 'identitas-perusahaan',
                map: null,
                v$: useVuelidate(),
                loadPortofolio: false,
                loadDetailIndustry: false,
                listDataPortofolio: [],
                uniqueString: '',                
                marker: null,
                token: '',
                surabaya: {
                    lat: -7.250445,
                    lng: 112.768845,
                },
                tableConfig: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center;width:8%',
                            },
                            {
                                text: 'NOMOR KBLI',
                                sort_by: 'code',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'NAMA KBLI',
                                sort_by: 'name',
                                sort_column: true,
                                style: 'text-align: left',
                            },
                            {
                                text: 'TAHUN',
                                sort_by: 'year_number',
                                sort_column: true,
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
                        loading: false,
                        show_search: true,
                    }
                },
                single: {                   
                    kbli: {
                        id: '',
                        year: '',
                        name: '',
                        number: '',
                    },
                    detail: {
                        logoUrl: '',
                        name: '',
                        trademarkName: '',
                        nib: '',
                        address: '',
                        phone: '',
                        ownerName: '',
                        email: '',
                        age: '',
                        ownerAddress: '',
                        ownerJobStatus: '',
                        lastEducation: '',
                        industryType: '',
                        industrySector: [],
                        description: '',
                        latitude: '',
                        longtitude: '',
                        omzet: '',
                        industryAge: '',
                        employeeCount: '',
                        employeeType: '',
                        hasIndustryLegality: '',
                        industryLegalityNote: '',
                        marketingTool: '',
                        website: '',
                        marketingLink: '',
                        twitter: '',
                        facebook: '',
                        instagram: '',

                    }
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
            if (this.$route.query.flag == 'portofolio') {
                this.flagTab = this.$route.query.flag;
                this.getDataPortofolio();
            } else {
                this.getDetail();
            }
            this.uniqueString = Math.random();
            this.token = localStorage.getItem('token');
        },

        methods: {
            getDetail() {
                this.loadDetailIndustry = true;
                Api().get(`${this.$apiType('web')}transact/industry/${this.$route.params.id}`)
                    .then(response => {
                        let context = response.data.data;

                        this.single.detail.logoUrl = context.industryLogoFile ? context.industryLogoFile.link + `?token=${this.token}&date=${this.uniqueString}` : '';
                        this.single.detail.name = context.name;
                        this.single.detail.trademarkName = context.trademarkName;
                        this.single.detail.nib = context.nib;
                        this.single.detail.address = context.address;
                        this.single.detail.phone = context.ownerPhoneNumber;
                        this.single.detail.ownerName = context.ownerName;
                        this.single.detail.email = context.ownerEmail;
                        this.single.detail.age = context.industryAge;
                        this.single.detail.ownerAddress = context.ownerAddress;
                        this.single.detail.ownerJobStatus = context.ownerJobStatus;
                        this.single.detail.lastEducation = context.ownerEducation ? context.ownerEducation.name :
                            '';
                        this.single.detail.industryType = context.industryTypeName;
                        for(let i = 0; i < context.industrySectors.length; i++){
                            this.single.detail.industrySector.push(context.industrySectors[i].name);
                        }                        
                        this.single.detail.description = context.description;
                        this.single.detail.latitude = context.latitude;
                        this.single.detail.longtitude = context.longitude;
                        this.single.detail.omzet = context.monthlyIncome;
                        this.single.detail.industryAge = context.industryAge;
                        this.single.detail.employeeCount = context.employeeAmount;
                        this.single.detail.employeeType = context.employeeStatus;
                        this.single.detail.hasIndustryLegality = context.hasIndustryLegalEntityTypeName;
                        if (context.hasIndustryLegalEntityType == 'already') {
                            this.single.detail.industryLegalityNote = context.industryLegalEntity;
                        } else if (context.hasIndustryLegalEntityType == 'not_yet') {
                            this.single.detail.industryLegalityNote = context.challengeObstacle;
                        }

                        this.single.detail.marketingTool = context.marketingTool;
                        this.single.detail.website = context.websiteLink;
                        this.single.detail.marketingLink = context.marketingLink;
                        this.single.detail.twitter = context.twitterLink;
                        this.single.detail.facebook = context.facebookLink;
                        this.single.detail.instagram = context.instagramLink;
                        this.loadDetailIndustry = false;

                        setTimeout(() => {
                            this.initMap();
                        }, 500);
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    });
            },
            resetDataDetail() {
                this.single.detail.logoUrl = '';
                this.single.detail.name = '';
                this.single.detail.trademarkName = '';
                this.single.detail.nib = '';
                this.single.detail.address = '';
                this.single.detail.phone = '';
                this.single.detail.ownerName = '';
                this.single.detail.email = '';
                this.single.detail.age = '';
                this.single.detail.ownerAddress = '';
                this.single.detail.ownerJobStatus = '';
                this.single.detail.lastEducation = '';
                this.single.detail.industryType = '';
                this.single.detail.industrySector = [];
                this.single.detail.description = '';
                this.single.detail.latitude = '';
                this.single.detail.longtitude = '';
                this.single.detail.omzet = '';
                this.single.detail.industryAge = '';
                this.single.detail.employeeCount = '';
                this.single.detail.employeeType = '';
                this.single.detail.hasIndustryLegality = '';
                this.single.detail.industryLegalityNote = '';
                this.single.detail.marketingTool = '';
                this.single.detail.website = '';
                this.single.detail.marketingLink = '';
                this.single.detail.twitter = '';
                this.single.detail.facebook = '';
                this.single.detail.instagram = '';
            },
            initMap() {               
                var options = {
                    zoom: 10,
                    center: this.surabaya
                }
                this.map = new google.maps.Map(document.getElementById('map'), options);
                

                if (this.single.detail.latitude && this.single.detail.longtitude) {
                    const latLng = new google.maps.LatLng(this.single.detail.latitude, this.single.detail.longtitude);
                    this.marker = new google.maps.Marker({
                        map: this.map,
                        position: latLng,
                        draggable: false,
                    });

                    this.marker.setIcon(this.$assetUrl() + 'extends/images/icon-marker.png');
                }                                
            },
            editKbli(id) {
                this.resetKbli();


                const index = this.tableConfig.feeder.data.findIndex((e) => e.id == id);
                if (index >= 0) {
                    let context = this.tableConfig.feeder.data[index];

                    this.single.kbli.id = context.id;
                    this.single.kbli.name = context.name;
                    this.single.kbli.number = context.code;
                    this.single.kbli.year = context.yearNumber;
                    $("#modal-form-kbli").modal('show');
                }

            },
            deleteKbli(id) {
                this.$swal({
                    title: 'Hapus KBLI?',
                    text: "Data akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F64E60',
                    cancelButtonColor: '#f2f2f2',
                    cancelButtonTextColor: "black",
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$loaderShow();
                        Api().delete(`${this.$apiType('web')}transact/industry-kbli/${id}`)
                            .then(response => {
                                this.$swal({
                                    title: "Berhasil!",
                                    text: 'KBLI berhasil dihapus.',
                                    icon: "success",
                                }).then(result => {

                                    this.tableConfig.config.current_page = 1;

                                    this.getDataTableKbli();

                                });
                            })
                            .catch(error => {
                                this.$axiosHandleError(error);
                            }).then(() => {
                                this.$loaderHide();
                            });
                    }
                });
            },
            getDataTableKbli() {
                this.tableConfig.config.loading = true;
                this.tableConfig.feeder.data = [];

                let params = {
                    page: this.tableConfig.config.current_page,
                    length: this.tableConfig.config.show_per_page,
                    orderDir: this.tableConfig.config.order,
                    orderCol: this.tableConfig.config.sort_by,
                    search: this.tableConfig.config.searchl,
                    industryId: this.$route.params.id
                }

                Api().get(`${this.$apiType('web')}transact/industry-kbli`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;

                        this.tableConfig.feeder.data = data;
                        this.tableConfig.config.total_data = response.data.total;

                        this.tableConfig.config.loading = false;
                    })
                    .catch(error => {

                        this.tableConfig.config.loading = false;

                        this.tableConfig.feeder.data = [];
                        this.tableConfig.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            updateKbli() {

                this.v$.$touch();
                if (this.v$.$error) {
                    return false;
                }

                let formData = {
                    code: this.single.kbli.number,
                    name: this.single.kbli.name,
                    yearNumber: this.single.kbli.year,
                }

                this.$loaderShow();

                Api().post(`${this.$apiType('web')}transact/industry-kbli/${this.single.kbli.id}`, formData)
                    .then(response => {
                        $(".modal").modal('hide');

                        this.$swal({
                            title: "Berhasil!",
                            text: 'Memperbarui data kbli perusahaan',
                            icon: "success",
                        }).then(result => {
                            this.getDataTableKbli();
                        });
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$loaderHide();
                    });
            },
            resetKbli() {
                this.v$.$reset();

                this.single.kbli.id = '';
                this.single.kbli.year = '';
                this.single.kbli.name = '';
                this.single.kbli.number = '';
            },
            getDataPortofolio() {
                this.loadPortofolio = true;
                let params = {
                    industryId: this.$route.params.id
                }
                Api().get(`${this.$apiType('web')}transact/industry-portfolio`, {
                        params
                    })
                    .then(response => {
                        this.listDataPortofolio = response.data.data;
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.loadPortofolio = false;
                    })
            },
            redirectPortofolio(id) {
                this.$router.push({
                    path: '/portofolio/' + id + '/detail',
                })
            }
        }
    }

</script>
