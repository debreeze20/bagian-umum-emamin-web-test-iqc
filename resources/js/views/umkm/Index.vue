<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8!important; min-height:100vh;">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid " >
            <!--begin::Wrapper-->
            <div class="mt-20 d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <app-navbar></app-navbar>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid"  id="kt_content">
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-fluid" style="margin-top: 100px;">
                            <!--begin::Content disini-->
                        <div class="card card-flush" id="kt_profile_details_view">
                            <div class="card card-xl-stretch mb-5 mb-xl-8">
                                <div class="card-header border-0 pt-5 align-items-center">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bolder text-dark mb-2">Data Umkm</span>
                                    </h3>
                                    <div class="d-flex">
                                        <app-select-single class="me-5" v-model="single.type"
                                                        placeholder="Semua Status"
                                                        :options="listType"
                                                        :show_search="false" :serverside="false"
                                                        :show_button_clear="false" @option-change="getUmkm()"></app-select-single>
                                                    <button type="button" class="btn h-50 bg-dark" style="background-color: #527D3C !important;"
                                                        @click="tambahUmkm">
                                                        <span class="text-white">Tambah Data</span>
                                                    </button>
                                    </div>
                                </div>
                                <div class="card-body pt-5">
                                    <app-datatable :table_config="tableUmkm" @change-page="getUmkm"
                                        v-model:show_per_page="tableUmkm.config.show_per_page"
                                        v-model:search="tableUmkm.config.search"
                                        v-model:order="tableUmkm.config.order"
                                        v-model:current_page="tableUmkm.config.current_page">
                                        <template v-slot:body>
                                            <tr v-for="(context,index) in tableUmkm.feeder.data">
                                                <td class="text-center">
                                                    {{index + ((parseInt(tableUmkm.config.show_per_page) * (parseInt(tableUmkm.config.current_page) - 1))) + 1}}
                                                </td>
                                                <td class="text-left">
                                                    <div>{{context.name}}</div>
                                                    <div><span class="text-muted">{{context.address}}</span></div>
                                                </td>
                                                <td class="text-left"><div
                                                    v-if="context.isMbr == true"
                                                    class="text-center"
                                                  >
                                                  <span class="fw-bolder badge badge-success text-white p-3">

                                                    MBR
                                                  </span>
                                                  </div>
                                                  <div
                                                    v-if="context.isMbr == false"
                                                    class="text-center"
                                                  >
                                                    <span
                                                      class="fw-bolder badge badge-warning text-white p-3"
                                                      >Bukan MBR</span
                                                    >
                                                  </div></td>

                                                <td class="text-center">
                                                    <div class="dropdown" style="position: static !important">
                                                        <button class="btn btn-secondary btn-xs dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown"
                                                            style="padding: 5px 10px !important"
                                                            aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>

                                                                <a class="dropdown-item fs-12"
                                                                    href="javascript:void(0);"
                                                                    style="padding: 10px 5px !important"
                                                                    @click="detailUmkm(context.id)" > <svg class="me-2 flex-wrap" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3" d="M14.6667 8.00065C14.6667 4.31875 11.6819 1.33398 8.00004 1.33398C4.31814 1.33398 1.33337 4.31875 1.33337 8.00065C1.33337 11.6825 4.31814 14.6673 8.00004 14.6673C11.6819 14.6673 14.6667 11.6825 14.6667 8.00065Z" fill="#3F4254"/>
                                                                        <path d="M7.33337 7.33398V10.6673C7.33337 11.0355 7.63185 11.334 8.00004 11.334C8.36823 11.334 8.66671 11.0355 8.66671 10.6673V7.33398C8.66671 6.96579 8.36823 6.66732 8.00004 6.66732C7.63185 6.66732 7.33337 6.96579 7.33337 7.33398Z" fill="#3F4254"/>
                                                                        <path d="M8.00004 4.66667C7.63185 4.66667 7.33337 4.96514 7.33337 5.33333C7.33337 5.70152 7.63185 6 8.00004 6C8.36823 6 8.66671 5.70152 8.66671 5.33333C8.66671 4.96514 8.36823 4.66667 8.00004 4.66667Z" fill="#3F4254"/>
                                                                        </svg>
                                                                        Detail</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item fs-12"
                                                                    href="javascript:void(0);"
                                                                    style="padding: 10px 5px !important"
                                                                    @click="historyPesanan(context.id)"><svg class="me-2 flex-wrap" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_832_9418)">
                                                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M5.33329 2V2.33333C5.33329 2.88562 5.78101 3.33333 6.33329 3.33333H9.66663C10.2189 3.33333 10.6666 2.88562 10.6666 2.33333V2H12C12.7363 2 13.3333 2.59695 13.3333 3.33333V14C13.3333 14.7364 12.7363 15.3333 12 15.3333H3.99996C3.26358 15.3333 2.66663 14.7364 2.66663 14V3.33333C2.66663 2.59695 3.26358 2 3.99996 2H5.33329Z" fill="#3F4254"/>
                                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.33333 1.33268C7.33333 0.964492 7.63181 0.666016 8 0.666016C8.36819 0.666016 8.66667 0.964492 8.66667 1.33268H9.66667C9.85076 1.33268 10 1.48192 10 1.66602V2.33268C10 2.51678 9.85076 2.66602 9.66667 2.66602H6.33333C6.14924 2.66602 6 2.51678 6 2.33268V1.66602C6 1.48192 6.14924 1.33268 6.33333 1.33268H7.33333Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M10.6666 6H7.33329C6.9651 6 6.66663 6.29848 6.66663 6.66667C6.66663 7.03486 6.9651 7.33333 7.33329 7.33333H10.6666C11.0348 7.33333 11.3333 7.03486 11.3333 6.66667C11.3333 6.29848 11.0348 6 10.6666 6Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M5.99996 6.66667C5.99996 6.29848 5.70148 6 5.33329 6C4.9651 6 4.66663 6.29848 4.66663 6.66667C4.66663 7.03486 4.9651 7.33333 5.33329 7.33333C5.70148 7.33333 5.99996 7.03486 5.99996 6.66667Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M5.99996 9.33268C5.99996 8.96449 5.70148 8.66602 5.33329 8.66602C4.9651 8.66602 4.66663 8.96449 4.66663 9.33268C4.66663 9.70087 4.9651 9.99935 5.33329 9.99935C5.70148 9.99935 5.99996 9.70087 5.99996 9.33268Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M10.6666 8.66602H7.33329C6.9651 8.66602 6.66663 8.96449 6.66663 9.33268C6.66663 9.70087 6.9651 9.99935 7.33329 9.99935H10.6666C11.0348 9.99935 11.3333 9.70087 11.3333 9.33268C11.3333 8.96449 11.0348 8.66602 10.6666 8.66602Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M5.99996 12.0007C5.99996 11.6325 5.70148 11.334 5.33329 11.334C4.9651 11.334 4.66663 11.6325 4.66663 12.0007C4.66663 12.3688 4.9651 12.6673 5.33329 12.6673C5.70148 12.6673 5.99996 12.3688 5.99996 12.0007Z" fill="#3F4254"/>
                                                                        <path opacity="0.3" d="M10.6666 11.334H7.33329C6.9651 11.334 6.66663 11.6325 6.66663 12.0007C6.66663 12.3688 6.9651 12.6673 7.33329 12.6673H10.6666C11.0348 12.6673 11.3333 12.3688 11.3333 12.0007C11.3333 11.6325 11.0348 11.334 10.6666 11.334Z" fill="#3F4254"/>
                                                                        </g>
                                                                        <defs>
                                                                        <clipPath id="clip0_832_9418">
                                                                        <rect width="16" height="16" fill="white"/>
                                                                        </clipPath>
                                                                        </defs>
                                                                        </svg>
                                                                         History Pesanan</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item fs-12"
                                                                    href="javascript:void(0);"
                                                                    style="padding: 10px 5px !important"
                                                                    @click="editUmkm(context.id)"><svg class="me-2 flex-wrap" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path opacity="0.3" d="M14.2667 5.56942L12.8274 7.00806L8.99006 3.17074L10.4287 1.73136C10.6833 1.47688 11.0285 1.33398 11.3884 1.33398C11.7483 1.33398 12.0935 1.47688 12.3481 1.73136L14.2667 3.65007C14.5212 3.90461 14.6642 4.24977 14.6642 4.6097C14.6642 4.96963 14.5212 5.31488 14.2667 5.56942ZM2.45806 14.6221L6.59139 13.2441L2.75406 9.40674L1.37606 13.54C1.32549 13.691 1.31808 13.8532 1.35465 14.0081C1.39122 14.1631 1.47033 14.3048 1.58306 14.4172C1.69579 14.5297 1.83767 14.6084 1.99272 14.6446C2.14778 14.6808 2.30986 14.673 2.46072 14.6221H2.45806Z" fill="#3F4254"/>
                                                                        <path d="M3.71605 14.2007L2.46138 14.6193C2.31066 14.6695 2.14894 14.6767 1.99434 14.6402C1.83974 14.6037 1.69835 14.5249 1.58599 14.4126C1.47363 14.3003 1.39473 14.159 1.35812 14.0044C1.32152 13.8498 1.32864 13.6881 1.37871 13.5374L1.79738 12.282L3.71605 14.2007ZM2.75671 9.40397L6.59405 13.2413L12.83 7.00529L8.99271 3.16797L2.75671 9.40397Z" fill="#3F4254"/>
                                                                        </svg>

                                                                         Edit</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item fs-12"
                                                                    href="javascript:void(0);"
                                                                    style="padding: 10px 5px !important"
                                                                    @click="confirmDelete(context.id)"><svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M4 5.33398V13.6673C4 14.2196 4.44772 14.6673 5 14.6673H11C11.5523 14.6673 12 14.2196 12 13.6673V5.33398H4Z" fill="#7E8299"/>
                                                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M9.33337 3V2.66667C9.33337 2.29848 9.0349 2 8.66671 2H7.33337C6.96518 2 6.66671 2.29848 6.66671 2.66667V3H3.66671C3.48261 3 3.33337 3.14924 3.33337 3.33333V3.66667C3.33337 3.85076 3.48261 4 3.66671 4H12.3334C12.5175 4 12.6667 3.85076 12.6667 3.66667V3.33333C12.6667 3.14924 12.5175 3 12.3334 3H9.33337Z" fill="#7E8299"/>
                                                                        </svg>
                                                                         Hapus</a>
                                                            </li>
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

        <div class="modal fade" tabindex="-1" id="modal-detail-umkm">
            <div class="modal-dialog modal-dialog-centerd modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 text-left">
                            <h3 class="modal-title text-left" style="font-size:14px !important">
                                Detail UMKM
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

                                  <h6 class="text-gray-600">Nama</h6>
                                </div>
                                <div class="col-md-8">
                                    <span :class="`badge ${umkm.isMbr ? 'badge-success' : 'badge-warning'} me-5`">{{umkm.isMbr ? 'MBR' : 'Bukan MBR'}}</span>
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{umkm.name}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Pemilik</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{umkm.ownerName}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Nomor Whatsapp Pemilik</h6>
                                </div>
                                <div class="col-md-8 flex-wrap ">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    ><svg  class="me-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.28192 19.3432L7.60913 19.5068C8.97272 20.3249 10.4998 20.7067 12.0269 20.7067C16.8264 20.7067 20.7533 16.7798 20.7533 11.9803C20.7533 9.68964 19.8261 7.45349 18.19 5.81727C16.5537 4.18105 14.3721 3.25391 12.0269 3.25391C7.22742 3.25391 3.30048 7.18077 3.35505 12.0349C3.35505 13.671 3.84591 15.2527 4.66398 16.6162L4.88213 16.9434L4.00956 20.1613L7.28192 19.3432Z" fill="#00E676"/>
                                        <path d="M19.1177 4.94515C17.2634 3.03629 14.7 2 12.0821 2C6.51906 2 2.04676 6.5268 2.10126 12.0353C2.10126 13.7806 2.59212 15.4714 3.41027 16.9985L1.99219 22.1798L7.28256 20.8163C8.75513 21.6344 10.3913 22.0162 12.0276 22.0162C17.5361 22.0162 22.0084 17.4893 22.0084 11.9809C22.0084 9.30838 20.9721 6.79951 19.1178 4.94515H19.1177ZM12.0821 20.3255C10.6095 20.3255 9.13692 19.9438 7.88249 19.1802L7.55528 19.0166L4.39198 19.8346L5.21005 16.7259L4.99191 16.3986C2.59212 12.5263 3.73748 7.39944 7.66435 4.99965C11.5912 2.59993 16.6634 3.74529 19.0632 7.67216C21.463 11.599 20.3176 16.6713 16.3908 19.0711C15.1363 19.8891 13.6092 20.3254 12.0821 20.3254V20.3255ZM16.8816 14.2716L16.2817 13.9989C16.2817 13.9989 15.4091 13.6171 14.8637 13.3444C14.8091 13.3444 14.7546 13.2898 14.7 13.2898C14.5364 13.2898 14.4273 13.3444 14.3182 13.399C14.3182 13.399 14.2637 13.4535 13.5002 14.3261C13.4456 14.4352 13.3365 14.4898 13.2274 14.4898H13.1729C13.1184 14.4898 13.0093 14.4352 12.9547 14.3807L12.682 14.2716C12.0821 13.9989 11.5367 13.6716 11.1004 13.2353C10.9913 13.1263 10.8276 13.0172 10.7186 12.9081C10.3368 12.5263 9.95499 12.09 9.68235 11.5991L9.62778 11.49C9.57328 11.4355 9.57328 11.381 9.51871 11.2719C9.51871 11.1628 9.51871 11.0537 9.57328 10.9992C9.57328 10.9992 9.79143 10.7265 9.95499 10.5629C10.0641 10.4537 10.1186 10.2902 10.2277 10.1811C10.3368 10.0175 10.3914 9.79932 10.3368 9.63567C10.2823 9.36295 9.62778 7.89038 9.46421 7.56317C9.35506 7.39952 9.24607 7.34502 9.08242 7.29045H8.4825C8.37335 7.29045 8.26435 7.34502 8.1552 7.34502L8.10063 7.39952C7.99156 7.45409 7.88249 7.56317 7.77342 7.61766C7.66435 7.72681 7.60977 7.8358 7.5007 7.94495C7.11891 8.43581 6.90077 9.03574 6.90077 9.63567C6.90077 10.072 7.00984 10.5083 7.17349 10.8901L7.22806 11.0537C7.71892 12.09 8.37335 13.0172 9.24607 13.8353L9.46421 14.0534C9.62778 14.217 9.79143 14.3261 9.9005 14.4897C11.0459 15.4715 12.3548 16.1805 13.8274 16.5623C13.991 16.6168 14.2092 16.6168 14.3728 16.6713H14.9182C15.1909 16.6713 15.5181 16.5623 15.7363 16.4532C15.8999 16.3441 16.0089 16.3441 16.118 16.235L16.2272 16.1259C16.3362 16.0168 16.4453 15.9623 16.5544 15.8533C16.6634 15.7442 16.7725 15.6351 16.8271 15.526C16.9362 15.3078 16.9907 15.0351 17.0452 14.7625V14.3807C17.0452 14.3807 16.9907 14.3261 16.8816 14.2716V14.2716Z" fill="white"/>
                                        </svg>
                                        </span
                                  >
                                  <a :href="'https://wa.me/' + umkm.whatsappNumber.substring(1)" target="_blank">{{umkm.whatsappNumber}}</a>
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Kecamatan</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{umkm.subdistrict}}</span
                                  >
                                </div>
                              </div>
                            <div class="row py-3">
                                <div class="col-md-4">
                                  <h6 class="text-gray-600">Alamat</h6>
                                </div>
                                <div class="col-md-8">
                                  <span style="font-size: 14px" class="fw-bolder"
                                    >{{umkm.address}}</span
                                  >
                                </div>
                              </div>
                              <h2 class="py-3 mt-5 fw-bolder">PERIZINAN USAHA</h2>
                              <div class="table-responsive">
                                <table class="table table-detail-2">
                                  <thead>
                                    <tr>
                                      <th class=" text-left">
                                        <h5>NAMA DOKUMEN</h5>
                                      </th>
                                      <th class="text-left ">
                                        <h5 >NOMOR</h5>
                                      </th>
                                      <th class="text-center">
                                        <h5 >DOKUMEN</h5>
                                      </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td class="text-left py-5">KTP Pemilik</td>
                                      <td class="text-left py-5">{{umkm.nikNumber}}</td>
                                      <td>
                                        <template v-for="(contex,index) in dropzoneKtp">
                                            <a :href="contex.link + '?token=' + this.token + '&preview=1'" target="_blank"
                                            v-if="contex">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img v-if="contex?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'jpeg'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'png'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'pdf'" :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                    style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(contex.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(contex.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        </template>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td class="text-left py-5">NPWP Pemilik</td>
                                      <td class="text-left py-5">{{umkm.npwpNumber}}</td>
                                      <td>
                                        <template v-for="(contex,index) in dropzoneNpwp">
                                            <a :href="contex.link + '?token=' + this.token + '&preview=1'" target="_blank"
                                            v-if="contex">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img v-if="contex?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'jpeg'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'png'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'pdf'" :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                    style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(contex.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(contex.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        </template>
                                      </td>
                                    </tr>

                                    <tr>
                                      <td class="text-left py-5">SIUP / NIB</td>
                                      <td class="text-left py-5">{{umkm.nibNumber}}</td>
                                      <td>
                                          <template v-for="(contex,index) in dropzoneNib">
                                            <a :href="contex.link + '?token=' + this.token + '&preview=1'" target="_blank"
                                            v-if="contex">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img v-if="contex?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'jpeg'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'png'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'pdf'" :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                    style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(contex.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(contex.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        </template>
                                      </td>
                                    </tr>

                                    <tr >
                                      <td class="text-left py-5">Surat Rekomendasi Bank</td>
                                      <td class="text-left py-5">{{umkm.bankReferenceNumber}}</td>
                                      <td class="text-center ">
                                        <template v-for="(contex,index) in dropzoneBankReference">
                                            <a :href="contex.link + '?token=' + this.token + '&preview=1'" target="_blank"
                                            >
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <img v-if="contex?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'jpeg'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'png'" :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                    style="width:35px;" />
                                                    <img v-if="contex?.ext == 'pdf'" :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                    style="width:35px;" />
                                                </div>
                                                <div>
                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                        {{$noNullable(contex.name)}}
                                                    </div>
                                                    <div class="text-gray-500">
                                                        {{$formatBytes(contex.size)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        </template>
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
                dropzoneKtp:null,
                dropzoneNpwp:null,
                dropzoneNib:null,
                dropzoneBankReference:null,
                DEFAULT_PASSWORD: '',
                pageStatus: 'standby',
                drpzoneFileImport: null,
                token: '',
                listType: [
                    {id:0, text: 'Semua Status'},
                    {id:2, text: 'MBR'},
                    {id:3, text: 'Bukan MBR'}
                ],
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
                flag: 'insert',
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
                tableUmkm: {
                    feeder: {
                        column: [{
                                text: 'NO',
                                sort_column: false,
                                style: 'text-align: center;width:8%',
                            },
                            {
                                text: 'NAMA - ALAMAT',
                                sort_column: false,
                                style: 'text-align: left',
                            },
                            {
                                text: 'STATUS MBR',
                                sort_column: false,
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
                umkm: {
                    id: '',
                    name: '',
                    ownerName: '',
                    whatsappNumber: '',
                    subdistrict:'',
                    address: '',
                    nikNumber: '',
                    npwpNumber: '',
                    nibNumber: '',
                    bankReferenceNumber: '',
                    isMbr: '',

                },
                single: {
                    type: {},

                }
            }
        },
        // beforeRouteLeave(to, from, next) {
        //     this.dropzoneKtp.destroy();
        //     this.dropzoneNpwp.destroy();
        //     this.dropzoneBankReference.destroy();
        //     this.dropzoneNib.destroy();
        //     to();
        // },
        mounted() {
            this.$initializeAppPlugins();
            this.token = localStorage.getItem('token');
            this.getUmkm();
        },
        methods: {
            getUmkm() {
                this.tableUmkm.config.loading = true;
                this.tableUmkm.feeder.data = [];

                let params = {
                    page: this.tableUmkm.config.current_page,
                    length: this.tableUmkm.config.show_per_page,
                    orderDir: this.tableUmkm.config.order,
                    orderCol: this.tableUmkm.config.sort_by,
                    search: this.tableUmkm.config.search,
                    status:this.single.type.id
                }

                Api().get(`${this.$apiType('web')}master/umkm?status=${this.single.type.id}`, {
                        params
                    })
                    .then(response => {

                        let data = response.data.data;
                        let meta = response.data.meta
                        this.tableUmkm.feeder.data = data;
                        this.tableUmkm.config.total_data = meta.total;

                        this.tableUmkm.config.loading = false;
                    })
                    .catch(error => {

                        this.tableUmkm.config.loading = false;

                        this.tableUmkm.feeder.data = [];
                        this.tableUmkm.config.total_data = 0;

                        this.$axiosHandleError(error);
                    });
            },
            detailUmkm(id){
                this.$loaderShow();
                Api().get(`${this.$apiType("web")}master/umkm/${id}`)
                .then((res)=>{
                    let context = res?.data?.data;
                    this.umkm.id = context.id;
                    this.umkm.name = context.name;
                    this.umkm.ownerName = context.ownerName;
                    this.umkm.subdistrict = context.subdistrict.name;
                    this.umkm.address = context.address;
                    this.umkm.npwpNumber = context.npwpNumber;
                    this.umkm.nikNumber = context.nikNumber;
                    this.umkm.nibNumber = context.nibNumber;
                    this.umkm.bankReferenceNumber = context.bankReferenceNumber;
                    this.umkm.whatsappNumber = context.whatsappNumber;
                    this.dropzoneKtp = context?.ktpFile
                    this.dropzoneNib = context?.nibFile
                    this.dropzoneNpwp = context?.npwpFile
                    this.dropzoneBankReference = context.bankReferenceFile ? context.bankReferenceFile : null
                    this.umkm.isMbr = context?.isMbr
                    $("#modal-detail-umkm").modal("show");
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
            confirmDelete(id) {
                this.$swal({
                title: 'Apakah anda yakin?',
                text: "Menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F64E60',
                cancelButtonColor: '#FFFFFF',
                cancelButtonTextColor: "black",
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                }).then((result) => {
                if (result.isConfirmed) {
                this.deleteUmkm(id);
                }
                });
            },
            deleteUmkm(id){
                this.$loaderShow()
                Api().get(`${this.$apiType('web')}master/umkm/${id}`)
                .then(response => {
                    this.$swal({
                                title: "Berhasil!",
                                text: 'Menghapus data UMKM',
                                icon: "success",
                            }).then(result => {
                               this.getUmkm()

                            });
                }).catch(err =>{
                    this.$axiosHandleError(err)
                }).then(()=>{
                    this.$loaderHide()
                })
            },
            historyPesanan(id) {
                this.$router.push({
                    path: '/umkm/' + id + '/history-pesanan'
                })
            },
            tambahUmkm() {
                this.$router.push({
                    path: '/umkm/tambah-umkm',
                })
            },
            editUmkm(id) {
                this.$router.push({
                    path: '/umkm/edit-umkm/' + id ,
                })
            },

        }
    }

</script>

<style scoped>
    #modal-detail th{
        background-color: #F5F8FA;
    }


</style>
