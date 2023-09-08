<template>
    <div class="d-flex flex-column flex-root" style="background-color: #DBF4D8; min-height: 100vh;">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="mt-10 d-flex flex-column flex-row-fluid" id="kt_wrapper">
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
                                    <span class="fw-bolder fs-4">Tambah Data</span>&ensp;
                                    <a href="javascript:void(0)" @click="$router.back()" class="text-gray-500">|&ensp;&ensp;Pengajuan </a>
                                    &ensp;-&ensp; Tambah Pengajuan
                                    <h1 style="font-size: 30px !important;" class="py-5  fw-bold">Tambah Pengajuan</h1>
                                </div>
                                <div class="col-lg-4 text-right justify-content-end d-flex">
                                    <button type="button" @click="$router.back()" class="btn btn-sm btn-white text-dark">
                                        <i class="fa fa-arrow-left text-dark"></i>&ensp;Kembali
                                    </button>
                                </div>
                            </div>
                            <div class="card card-flush" id="kt_profile_details_view">
                                <div v-if="loading" class="d-flex align-items-center justify-content-center"><app-loader></app-loader></div>
                                <div v-show="!loading" class="wraper">
                                    <div class="card card-xl-stretch mb-5 mb-xl-8" v-show="step == 1">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="1 me-10 ">
                                                <div class="content text-center">
                                                    <div class="badge  px-6 py-5 mb-5 fs-3 fw-bolder" style="background-color: #527D3C; border-radius:10px !important">1</div>
                                                    <h5>Detail Pesanan</h5>
                                                    <span class="text-muted">Masukkan Detail Pesanan</span>
                                                </div>
                                            </div>
                                            <div class="icon me-10">
                                                <svg width="74" height="2" viewBox="0 0 74 2" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.25 1H73.75" stroke="#D9DBE4" stroke-width="2" stroke-dasharray="5 5" /> </svg>
                                            </div>
                                            <div class="2">
                                                <div class="content text-center">
                                                    <div class="badge  px-6 py-5 mb-5 fs-3 fw-bolder badge-secondary" style=" border-radius:10px !important">2</div>
                                                    <h5>Daftar Pesanan</h5>
                                                    <span class="text-muted">Daftar Pesanan Mamin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div class="row">
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label fs-6"
                                                        :class="v$.single.name.$error ? 'text-danger' : ''">Nama Acara
                                                    </label>
                                                    <input class="form-control" type="text" placeholder="Cth: Rapat, acara sosialisasi" autocomplete="off" v-model="single.name" />
                                                    <div v-if="v$.single.name.$error" class="text-danger"> Nama tidak boleh kosong!
                                                    </div>
                                                    <div class="text-danger">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label class=" fs-6 form-label" :class="v$.single.eventDate.$error ? 'text-danger' : ''"> Tanggal Acara </label>
                                                    <app-datepicker type="date" placeholder="Pilih periode" :format="'DD/MM/YYYY'" :value-type="'YYYY-MM-DD'" :class="'w-100'" v-model:value="single.eventDate"> </app-datepicker>
                                                    <div v-if="v$.single.eventDate.$error" class="text-danger"> Nama tidak boleh kosong! </div>
                                                </div>
                                                <div class="col-lg-3 mb-3">
                                                    <label class=" fs-6 form-label " :class="v$.single.deliveryDate.$error ? 'text-danger' : ''"> Tanggal Pengiriman </label>
                                                    <app-datepicker type="date" placeholder="Pilih periode" :format="'DD/MM/YYYY'" :value-type="'YYYY-MM-DD'" :class="'w-100'" v-model:value="single.deliveryDate"> </app-datepicker>
                                                    <div v-if="v$.single.deliveryDate.$error" class="text-danger">Nama tidak boleh kosong! </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 ">
                                                    <label class="form-label fs-6">Nomor Surat Pendukung (Opsional)</label>
                                                    <input class="form-control" type="text" placeholder="Cth: 001/XJSM/2023" autocomplete="off" v-model="single.referenceNumber" />
                                                    <div class="my-10">
                                                        <label class="form-label fs-6">Unggah Surat Pendukung (Opsional)</label>
                                                        <div class=" py-10 dropzone dropzone-file-area dz-clickable"
                                                            id="dropzone-surat">
                                                            <div class="dz-message needsclick">
                                                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity="0.3" d="M31.875 38.125V13.125C31.875 11.7443 30.7557 10.625 29.375 10.625C27.9943 10.625 26.875 11.7443 26.875 13.125V38.125C26.875 39.5057 27.9943 40.625 29.375 40.625C30.7557 40.625 31.875 39.5057 31.875 38.125Z" fill="#009EF7" /> <path d="M30.1432 15.2975L33.8007 19.6865C34.7802 20.8621 36.5579 20.9427 37.6399 19.8607C38.6142 18.8864 38.6602 17.3216 37.7447 16.2917L31.2435 8.97777C30.249 7.85897 28.5009 7.85897 27.5064 8.97777L21.0051 16.2917C20.0897 17.3216 20.1357 18.8864 21.11 19.8607C22.192 20.9427 23.9696 20.8621 24.9492 19.6865L28.6067 15.2975C29.0064 14.8178 29.7434 14.8178 30.1432 15.2975Z" fill="#009EF7" /> <path d="M46.875 20.625H44.375C42.9943 20.625 41.875 21.7443 41.875 23.125C41.875 24.5057 42.9943 25.625 44.375 25.625C45.7557 25.625 46.875 26.7443 46.875 28.125V45.625C46.875 47.0058 45.7557 48.125 44.375 48.125H14.375C12.9943 48.125 11.875 47.0058 11.875 45.625V28.125C11.875 26.7443 12.9943 25.625 14.375 25.625C15.7557 25.625 16.875 24.5057 16.875 23.125C16.875 21.7443 15.7557 20.625 14.375 20.625H11.875C9.11357 20.625 6.875 22.8636 6.875 25.625V48.125C6.875 50.8865 9.11357 53.125 11.875 53.125H46.875C49.6365 53.125 51.875 50.8865 51.875 48.125V25.625C51.875 22.8636 49.6365 20.625 46.875 20.625Z" fill="#009EF7" /> </svg>
                                                                <div class="ms-4">
                                                                    <h5 class="kt-dropzone__msg-title">Drop files here or click to upload</h5>
                                                                    <span class="kt-dropzone__msg-desc text-primary">Upload up to 10 files with the format .jpg/.jpeg/.pdf</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview-file" v-if="$route.name == 'edit-pengajuan'">
                                                        <h5>Preview File: </h5>
                                                        <div class="wrap-preview d-flex" style="flex-wrap:wrap;">
                                                            <div  v-for="(context, index) in previewFile" v-show="!isFileDeleted(context?.id)" class="card m-2" style="border:1px solid lightgray; cursor:pointer; position:relative;">
                                                                <button @click="deleteFile(context?.id)" class="btn btn-close btn-sm" style="position:absolute; right:-5px; top:1px;"></button>
                                                                <a :href="`${context?.link}?token=${token}`"  target="_blank">
                                                                    <div class="card-body p-7 pb-3 ps-3 text-primary">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="icon">
                                                                                <i class="bi bi-file-earmark-arrow-down fa-2x me-3"></i>
                                                                            </div>
                                                                            <div class="info">
                                                                                <div>{{ context?.name }}</div>
                                                                                <div class="text-muted">{{ $formatBytes(context?.size) }}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <h2 class=" fw-normal" :class="v$.single.accountCodeId.$error ? 'text-danger' : ''">Kode Rekening</h2>
                                                    <div v-if="accountCode?.loading" class="d-flex align-items-center justify-content-center">
                                                        <app-loader></app-loader>
                                                    </div>
                                                    <div v-else v-for="(context, index) in accountCode?.list" :key="context.id" class="py-3">
                                                        <label style="width: 100%">
                                                            <div class="card" :class="{ 'selected': context?.id == single?.accountCodeId }" :style="{ backgroundColor: context?.id == single?.accountCodeId ? '#F1FAFF' : 'transparent', border: context?.id == single?.accountCodeId ? '1px dashed #3699FF' : '1px dashed lightgray' }">
                                                                <div class="card-body">
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input" id="account-code" name="account-code" type="radio" :value="context?.id" v-model="single.accountCodeId" />
                                                                        <div class="tulisans ms-5">
                                                                            <h5 class="">{{ context.name }}</h5>
                                                                            <div class="text-muted" v-html="context?.nameBank"></div>
                                                                            <span class="text-muted">No. Rek. {{ context?.code }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div v-if="v$.single.accountCodeId.$error" class="text-danger py-2">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <h2 class=" fw-normal" :class="v$.single.orderMethodId.$error ? 'text-danger' : ''">Metode Pemesanan</h2>
                                                    <div v-if="orderMethod?.loading" class="d-flex align-items-center justify-content-center">
                                                        <app-loader></app-loader>
                                                    </div>
                                                    <div v-else v-for="(context, index) in orderMethod?.list" :key="context.id" class="py-3">
                                                        <label style="width: 100%">
                                                            <div class="card" :class="{ 'selected': context?.id == single?.orderMethodId }" :style="{ backgroundColor: single.orderMethodId == context.id ? '#F1FAFF' : 'transparent', border: single.orderMethodId == context.id ? '1px dashed #3699FF' : '1px dashed lightgray' }">
                                                                <div class="card-body">
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input" id="eksekutor-internal" name="radio_eksekutor" type="radio" :value="context.id" v-model="single.orderMethodId" />
                                                                        <h5 class="mx-3">{{ context.name }}</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div v-if="v$.single.orderMethodId.$error" class="text-danger py-2">
                                                        Pilih Salah Satu!
                                                    </div>
                                                </div>
                                            </div>
                                            <center>
                                                <button class="btn  text-white mt-20" style="background-color: #527D3C;" @click="nextStep()">
                                                    Lanjut ke Pesanan
                                                    <svg width="23" class="ms-3s" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <g clip-path="url(#clip0_1744_892)"> <path opacity="0.3" d="M5.08341 10.0827C4.57715 10.0827 4.16675 10.4931 4.16675 10.9993C4.16675 11.5056 4.57715 11.916 5.08341 11.916H11.5001C12.0063 11.916 12.4167 11.5056 12.4167 10.9993C12.4167 10.4931 12.0063 10.0827 11.5001 10.0827H5.08341Z" fill="white" /> <path d="M10.8519 15.8512C10.4939 16.2091 10.4939 16.7895 10.8519 17.1475C11.2099 17.5055 11.7903 17.5055 12.1483 17.1475L17.6483 11.6475C17.9953 11.3005 18.0074 10.7417 17.6758 10.3799L12.6341 4.87994C12.292 4.50674 11.7122 4.48153 11.339 4.82362C10.9658 5.16572 10.9406 5.74557 11.2827 6.11876L15.7313 10.9718L10.8519 15.8512Z" fill="white" /> </g> <defs> <clipPath id="clip0_1744_892"> <rect width="22" height="22" fill="white" transform="translate(0.5)" /> </clipPath> </defs> </svg>
                                                </button>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="card card-xl-stretch mb-5 mb-xl-8" v-show="step == 2">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="1 me-10 ">
                                                <div class="content text-center">
                                                    <div class="badge  px-6 py-5 mb-5 fs-3 fw-bolder  badge-secondary" style=" border-radius:10px !important">1</div>
                                                    <h5>Detail Pesanan</h5>
                                                    <span class="text-muted">Masukkan Detail Pesanan</span>
                                                </div>
                                            </div>
                                            <div class="icon me-10">
                                                <svg width="74" height="2" viewBox="0 0 74 2" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M0.25 1H73.75" stroke="#D9DBE4" stroke-width="2" stroke-dasharray="5 5" /> </svg>
                                            </div>
                                            <div class="2">
                                                <div class="content text-center">
                                                    <div class="badge  px-6 py-5 mb-5 fs-3 fw-bolder" style=" background-color: #527D3C; border-radius:10px !important">2</div>
                                                    <h5>Pesanan Mamin</h5>
                                                    <span class="text-muted">Daftar Pesanan Mamin</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body pt-5">
                                            <div v-for="(context, index) in single?.orders" class="card rounded p-6 my-8" style="border:1px solid lightgray;">
                                                <div class="umkm">
                                                    <table class="w-100 mb-5">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pe-10">UMKM</td>
                                                                <td class="ps-10">
                                                                    <app-select-single v-model="context.umkm" :loading="selectList?.umkm?.loading" :placeholder="'Pilih UMKM'" :options="selectList?.umkm?.list" @change-search="getUmkm" :serverside="true" :show_button_clear="false"> </app-select-single>
                                                                </td>
                                                                <td class="text-end">
                                                                    <button v-if="index == 0" type="button" class="btn btn-success" @click="addOrder()">
                                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M14.4165 7.08203H1.58317C1.07691 7.08203 0.666504 7.49244 0.666504 7.9987C0.666504 8.50496 1.07691 8.91537 1.58317 8.91537H14.4165C14.9228 8.91537 15.3332 8.50496 15.3332 7.9987C15.3332 7.49244 14.9228 7.08203 14.4165 7.08203Z" fill="white" /> <path d="M8.9165 14.416L8.9165 1.58268C8.9165 1.07642 8.5061 0.666016 7.99984 0.666016C7.49358 0.666016 7.08317 1.07642 7.08317 1.58268L7.08317 14.416C7.08317 14.9223 7.49358 15.3327 7.99984 15.3327C8.5061 15.3327 8.9165 14.9223 8.9165 14.416Z" fill="white" /> </svg>
                                                                    </button>
                                                                    <button v-else type="button" class="btn btn-danger" @click="removeOrder(index)">
                                                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8887 5.81634L5.8142 14.8909C5.45622 15.2489 5.45622 15.8293 5.8142 16.1872C6.17218 16.5452 6.75258 16.5452 7.11056 16.1872L16.1851 7.11271C16.5431 6.75473 16.5431 6.17432 16.1851 5.81634C15.8271 5.45836 15.2467 5.45836 14.8887 5.81634Z" fill="white"/><path d="M16.1851 14.8907L7.11058 5.81615C6.7526 5.45817 6.1722 5.45817 5.81422 5.81615C5.45624 6.17413 5.45624 6.75453 5.81422 7.11251L14.8888 16.1871C15.2467 16.545 15.8271 16.545 16.1851 16.1871C16.5431 15.8291 16.5431 15.2487 16.1851 14.8907Z" fill="white"/></svg>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div v-for="(value, idx) in context?.productTypes" class="tipe-produk card rounded p-6 my-5" style="border:1px solid lightgray;">
                                                        <table class="w-100 mb-5">
                                                            <tr>
                                                                <td class="pe-20">Pilih Tipe Produk</td>
                                                                <td class="ps-8" style="width: 50%;">
                                                                    <app-select-single v-model="value.productType" :loading="selectList?.productType?.loading" :placeholder="'Pilih tipe produk'" :options="selectList?.productType?.list" @change-search="getProductType" :serverside="true" :show_button_clear="false"> </app-select-single></td>
                                                                <td class="text-end">
                                                                    <button v-if="idx == 0" class="btn btn-secondary text-success" type="button" @click="addProductType(index)">
                                                                        <svg width="22" class="me-3" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M17.4165 10.082H4.58317C4.07691 10.082 3.6665 10.4924 3.6665 10.9987C3.6665 11.505 4.07691 11.9154 4.58317 11.9154H17.4165C17.9228 11.9154 18.3332 11.505 18.3332 10.9987C18.3332 10.4924 17.9228 10.082 17.4165 10.082Z" fill="#50CD89" /> <path d="M11.9165 17.416L11.9165 4.58268C11.9165 4.07642 11.5061 3.66602 10.9998 3.66602C10.4936 3.66602 10.0832 4.07642 10.0832 4.58268L10.0832 17.416C10.0832 17.9223 10.4936 18.3327 10.9998 18.3327C11.5061 18.3327 11.9165 17.9223 11.9165 17.416Z" fill="#50CD89" /> </svg>
                                                                        Tambah Tipe
                                                                    </button>
                                                                    <button v-else class="btn btn-secondary text-danger" type="button" @click="removeProductType(index, idx)">
                                                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.4165 10.082H4.58317C4.07691 10.082 3.6665 10.4924 3.6665 10.9987C3.6665 11.505 4.07691 11.9154 4.58317 11.9154H17.4165C17.9228 11.9154 18.3332 11.505 18.3332 10.9987C18.3332 10.4924 17.9228 10.082 17.4165 10.082Z" fill="#F1416C"/></svg>
                                                                        Hapus Tipe
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <table class="w-100 mb-5">
                                                            <thead>
                                                                <tr class="mb-5">
                                                                    <th>Kecamatan Pengiriman</th>
                                                                    <th>Alamat Pengiriman</th>
                                                                    <th>Qty Produk</th>
                                                                    <th>Total Harga</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="(val, i) in value?.details">
                                                                    <td class="pe-5 py-1">
                                                                        <app-select-single v-model="val.subdistrict" :loading="selectList?.subdistrict?.loading" :placeholder="'Pilih Kecamatan'" :options="selectList?.subdistrict?.list" @change-search="getSubdistrict" :serverside="true" :show_button_clear="false"> </app-select-single></td>
                                                                    <td class="pe-5 py-1">
                                                                        <input class="form-control" type="text" placeholder="Cth: Jl. Asem III B No 7" autocomplete="off" v-model="val.destinationAddress" />
                                                                    </td>
                                                                    <td class="pe-5 py-1"><input class="form-control" type="text" placeholder="Cth: 100" autocomplete="off" v-model="val.qty" /></td>
                                                                    <td class="pe-5 py-1">
                                                                        <h1>Rp. {{ $rupiahFormat(countPrice(index, idx, i)) }}</h1>
                                                                    </td>
                                                                    <td class="py-3">
                                                                        <button v-if="i == 0" class="btn btn-success" @click="addDetail(index, idx)">
                                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M14.4165 7.08203H1.58317C1.07691 7.08203 0.666504 7.49244 0.666504 7.9987C0.666504 8.50496 1.07691 8.91537 1.58317 8.91537H14.4165C14.9228 8.91537 15.3332 8.50496 15.3332 7.9987C15.3332 7.49244 14.9228 7.08203 14.4165 7.08203Z" fill="white" /> <path d="M8.9165 14.416L8.9165 1.58268C8.9165 1.07642 8.5061 0.666016 7.99984 0.666016C7.49358 0.666016 7.08317 1.07642 7.08317 1.58268L7.08317 14.416C7.08317 14.9223 7.49358 15.3327 7.99984 15.3327C8.5061 15.3327 8.9165 14.9223 8.9165 14.416Z" fill="white" /></svg>
                                                                        </button>
                                                                        <button v-else class="btn btn-danger btn-sm" @click="removeDetail(index, idx, i)">
                                                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.8887 5.81634L5.8142 14.8909C5.45622 15.2489 5.45622 15.8293 5.8142 16.1872C6.17218 16.5452 6.75258 16.5452 7.11056 16.1872L16.1851 7.11271C16.5431 6.75473 16.5431 6.17432 16.1851 5.81634C15.8271 5.45836 15.2467 5.45836 14.8887 5.81634Z" fill="white"/><path d="M16.1851 14.8907L7.11058 5.81615C6.7526 5.45817 6.1722 5.45817 5.81422 5.81615C5.45624 6.17413 5.45624 6.75453 5.81422 7.11251L14.8888 16.1871C15.2467 16.545 15.8271 16.545 16.1851 16.1871C16.5431 15.8291 16.5431 15.2487 16.1851 14.8907Z" fill="white"/></svg>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <br>
                                                        <table>
                                                            <th>
                                                                <h1>Total Pesanan ({{ $rupiahFormat(countQtyProductTypes(value?.details)) || 0 }} Produk)</h1>
                                                            </th>
                                                            <th>
                                                                <h1>Rp {{ $rupiahFormat(totalPrice(index, idx)) }}</h1>
                                                            </th>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="card" style="background-color:#F5F8FA;">
                                                <div class="card-body">
                                                    <div class="total-pesanan py-3 d-flex align-items-center justify-content-between">
                                                        <h3>Total Pesanan ({{ totalOrderProduct() }} Produk)</h3>
                                                        <h3>Rp {{ $rupiahFormat(totalOrder()) }}</h3>
                                                    </div>
                                                    <div class="pajak-daerah py-3 d-flex align-items-center justify-content-between">
                                                        <h3>Pajak Daerah (10%)</h3>
                                                        <h3>Rp {{ $rupiahFormat(totalOrder()*10/100) }}</h3>
                                                    </div>
                                                    <div class="pajak-daerah py-3 d-flex align-items-center justify-content-between">
                                                        <h1>Total Pembayaran</h1>
                                                        <h1>Rp {{ $rupiahFormat(totalOrder() + (totalOrder()*10/100)) }}</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <center>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn  btn-secondary mt-10 me-5" @click="prevStep()">
                                                        <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg"> <path opacity="0.3" d="M17.9166 10.0827C18.4228 10.0827 18.8333 10.4931 18.8333 10.9993C18.8333 11.5056 18.4228 11.916 17.9166 11.916H10.5833C10.077 11.916 9.66658 11.5056 9.66658 10.9993C9.66658 10.4931 10.077 10.0827 10.5833 10.0827H17.9166Z" fill="#181C32" /> <path d="M12.1481 15.8512C12.5061 16.2091 12.5061 16.7895 12.1481 17.1475C11.7901 17.5055 11.2097 17.5055 10.8517 17.1475L5.35174 11.6475C5.00471 11.3005 4.99257 10.7417 5.3242 10.3799L10.3659 4.87994C10.708 4.50674 11.2878 4.48153 11.661 4.82362C12.0342 5.16572 12.0594 5.74557 11.7173 6.11876L7.26871 10.9718L12.1481 15.8512Z" fill="#181C32" /> </svg>
                                                        Sebelumnya
                                                    </button>
                                                    <button class="btn  text-white mt-10" style="background-color: #527D3C;" @click="this?.$route?.name == 'tambah-pengajuan' ? save() : update()">Simpan Data</button>
                                                </div>
                                            </center>
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

import useVuelidate from '@vuelidate/core';
import {
    required
} from '@vuelidate/validators'
export default {
    data() {
        return {
            baseUrl: baseUrl,
            token: localStorage.getItem('token'),
            loading: false,
            step: 1,
            dropzoneFile: '',
            moneyConfig: {
                masked: false,
                prefix: '',
                suffix: '',
                thousands: '.',
                decimal: ',',
                precision: 0,
                disableNegative: true,
                disabled: false,
                min: null,
                max: null,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },
            pageStatus: 'stanby',
            map: null,
            v$: useVuelidate(),
            selectList: {
                subdistrict: {
                    loading: false,
                    list: [],
                },
                productType: {
                    loading: false,
                    list: [],
                },
                umkm: {
                    loading: false,
                    list: [],
                }
            },
            orderMethod: {
                loading: false,
                list: [],
            },
            accountCode: {
                loading: false,
                list: [],
            },
            previewFile: '',
            single: {
                name: '',
                eventDate: '',
                deliveryDate: '',
                referenceNumber: '',
                accountCodeId: '',
                orderMethodId: '',
                deleteFiles: [],
                orders: [
                    {
                        umkm: '',
                        umkmId: '', //
                        productTypes: [
                            {
                                productType: '',
                                productTypeId: '', //
                                details: [
                                    {
                                        subdistrict: '',
                                        subdistrictId: '', //
                                        qty: 0,
                                        destinationAddress: '',
                                    }
                                ]
                            }
                        ]
                    }
                ],
            },
        }

    },
    beforeRouteLeave(to, from, next) {
            this.dropzoneFile.destroy();
            this.dropzoneFile.removeAllFiles();
            next();
        },
    validations() {
        return {
            single: {
                name: {required},
                eventDate: {required},
                deliveryDate: {required},
                accountCodeId: {required},
                orderMethodId: {required},
                referenceNumber: {required},
            },
        }
    },
    mounted() {

        if(this.$route.name == 'edit-pengajuan'){
            this.getData();
        }
        this.$initializeAppPlugins();
        this.getOrderMethod();
        this.getProductType();
        this.getAccountCode();
        this.initDropzone();
    },
    methods: {
        getData(){
            let that = this;

            this.loading = true;
            Api().get(`${this.$apiType('web')}transact/submission/${this.$route?.params?.id}`)
                .then(res => {
                    let data = res?.data?.data;
                    this.single.name = data?.name;
                    this.single.eventDate = data?.eventDate;
                    this.single.deliveryDate = data?.deliveryDate;
                    this.single.referenceNumber = data?.referenceNumber;
                    this.single.accountCodeId = data?.accountCode?.id;
                    this.single.orderMethodId = data?.orderMethod?.id;
                    this.previewFile = data?.files;
                    that.single.orders = [];
                    data?.orderHasUmkms?.forEach(function(item, index){
                        let umkm = item?.umkm;
                        umkm.text = umkm?.name;

                        let order = {
                            umkm: umkm,
                            umkmId: item?.umkm?.id,
                            productTypes: [],
                        };

                        item?.orderHasUmkmProductTypes?.forEach(function(value, idx){
                            let product = value?.productType;
                            product.text = value?.productType?.name;

                            let productType = {
                                productType: product,
                                productTypeId: value?.productType?.id,
                                details: [],
                            };

                            value?.orderHasUmkmProductTypeDetails?.forEach(function(val, i){
                                let detail = {
                                    subdistrict: {id: val?.subdistrict?.id, text: val?.subdistrict?.name},
                                    subdistrictId: val?.subdistrict?.id,
                                    qty: val?.qty,
                                    destinationAddress: val?.destinationAddress,
                                };

                                productType.details.push(detail);
                            });

                            order.productTypes.push(productType);
                        });

                        that.single.orders.push(order);
                    });
                })
                .catch(err => {
                    console.log(err);
                    this.$axiosHandleError(err);
                })
                .then(() => {
                    this.loading = false;
                });
        },
        nextStep() {
            this.step++;

        },
        prevStep() {
            this.step--;
        },
        initDropzone() {
            let that = this;
            if(this.$route.name == 'edit-pengajuan'){
                if (this?.dropzoneFile) {
                    this.dropzoneFile.removeAllFiles();
                    this.dropzoneFile.destroy();
                }
            }
            this.dropzoneFile = new Dropzone("#dropzone-surat", {
                url: this?.$route?.name == 'tambah-pengajuan' ? `${this?.baseUrl}/${this.$apiType('web')}transact/submission` : `${this?.baseUrl}/${this.$apiType('web')}transact/submission/${this?.$route?.params?.id}`,
                dictCancelUpload: "Cancel",
                maxFilesize: 20,
                parallelUploads: 10,
                uploadMultiple: true,
                maxFiles: 100,
                addRemoveLinks: true,
                acceptedFiles: ".jpg,.jpeg,.png,.pdf",
                autoProcessQueue: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
                paramName: 'files',
                init: function () {
                    this.on("error", function (file) {
                        that.$loaderHide();
                        if (!file.accepted) {
                            this.removeFile(file);
                            that.$swal("Silahkan periksa file Anda lagi");
                        } else if (file.status == "error") {
                            that.$swal("Terjadi kesalahan koneksi");
                        }
                    });

                    this.on("resetFiles", function (file) {
                        this.removeAllFiles();
                    });
                },
            });

        },
        getAccountCode() {
            this.accountCode.loading = true;
            Api().get(`${this.$apiType('global')}select-list/account-code`)
                .then(response => {
                    let data = response.data.data;
                    this.accountCode.list = data;
                }).catch(err => {
                    this.$axiosHandleError(err)
                }).then(() => {
                    this.accountCode.loading = false;
                })
        },
        getOrderMethod() {
            this.orderMethod.loading = true;
            Api().get(`${this.$apiType('global')}select-list/order-method`)
                .then((response) => {
                    let data = response.data.data;
                    this.orderMethod.list = data;
                }).catch((error) => {
                    this.$axiosHandleError(error);
                })
                .then(() => {
                    this.orderMethod.loading = false;
                });
        },
        deleteFile(id){
            let that = this;
            this.$swal({
                title: 'Hapus File?',
                text: "Ketika data edit disimpan, file akan terhapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F64E60',
                cancelButtonColor: '#f2f2f2',
                cancelButtonTextColor: "black",
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    let indexFile = that?.single?.deleteFiles?.findIndex(value => value == id);
                    if(indexFile == -1){
                        that.single.deleteFiles.push(id);
                    }
                }
            });
        },
        isFileDeleted(id){
            let indexFile = this.single.deleteFiles.findIndex(value => value == id);
            if(indexFile == -1){
                return false;
            }
            else{
                return true;
            }
        },
        save() {
            let that = this;

            this.v$.$touch();
            if(this.v$.$error){
                this.$toast.error("Silahkan lengkapi form terlebih dahulu!");
                    return false;
            }

            let formData = this?.single;
            formData?.orders?.map(function(value){
                value.umkmId = value?.umkm?.id;
                value?.productTypes.map(function(val){
                    val.productTypeId = val?.productType?.id;
                    val.details.map(function(item){
                        item.subdistrictId = item?.subdistrict?.id;
                    });
                });
            });

            if(this.dropzoneFile?.files?.length < 1){
                this.$loaderShow();
                Api().post(`${this.$apiType('web')}transact/submission`, formData)
                    .then(response => {
                        let data = response?.data?.data;
                        if (this.dropzoneFile?.files?.length > 0) {
                            this.uploadFile(data)
                        } else {
                            this.$swal({
                                title: "Berhasil!",
                                text: 'Menambahkan data Pengajuan',
                                icon: "success",
                            }).then(result => {
                                this.$router.push({path: '/pengajuan'});
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                        this.$axiosHandleError(err)
                    }).then(() => {
                        this.$loaderHide();
                    });
            }
            else{
                this.$loaderShow();
                this.dropzoneFile.on(`sending`, function(file, xhr, formData) {
                    formData.append(`name`, that?.single?.name);
                    formData.append(`eventDate`, that?.single?.eventDate);
                    formData.append(`deliveryDate`, that?.single?.deliveryDate);
                    formData.append(`referenceNumber`, that?.single?.referenceNumber);
                    formData.append(`accountCodeId`, that?.single?.accountCodeId);
                    formData.append(`orderMethodId`, that?.single?.orderMethodId);
                    that?.single?.orders.forEach(function(val, i){
                        formData.append(`orders[${i}][umkmId]`, val?.umkmId);
                        val?.productTypes?.forEach(function(value, idx){
                            formData.append(`orders[${i}][productTypes][${idx}][productTypeId]`, value?.productTypeId);
                            value?.details?.forEach(function(item, index){
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][subdistrictId]`, item?.subdistrictId);
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][qty]`, item?.qty);
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][destinationAddress]`, item?.destinationAddress);
                            });
                        });
                    });
                });
                this.dropzoneFile.processQueue();
                this.dropzoneFile.on('success', function(){
                    that.$loaderHide();
                    Swal.fire('Berhasil', 'Data berhasil disimpan.','success').then(()=>{
                        that.$router.push({path: '/pengajuan'});
                    });
                });
            }
        },
        update() {
            let that = this;

            this.v$.$touch();
            if(this.v$.$error){
                this.$toast.error("Silahkan lengkapi form terlebih dahulu!");
                    return false;
            }

            let formData = this?.single;
            formData?.orders?.map(function(value){
                value.umkmId = value?.umkm?.id;
                value?.productTypes.map(function(val){
                    val.productTypeId = val?.productType?.id;
                    val.details.map(function(item){
                        item.subdistrictId = item?.subdistrict?.id;
                    });
                });
            });

            if(this.dropzoneFile?.files?.length < 1){
                this.$loaderShow();
                Api().post(`${this.$apiType('web')}transact/submission/${this?.$route?.params?.id}`, formData)
                    .then(response => {
                        let data = response?.data?.data;
                        if (this.dropzoneFile?.files?.length > 0) {
                            this.uploadFile(data)
                        } else {
                            this.$swal({
                                title: "Berhasil!",
                                text: 'Menambahkan data Pengajuan',
                                icon: "success",
                            }).then(result => {
                                this.$router.push({path: '/pengajuan'});
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                        this.$axiosHandleError(err)
                    }).then(() => {
                        this.$loaderHide();
                    });
            }
            else{
                this.$loaderShow();
                this.dropzoneFile.on(`sending`, function(file, xhr, formData) {
                    formData.append(`name`, that?.single?.name);
                    formData.append(`eventDate`, that?.single?.eventDate);
                    formData.append(`deliveryDate`, that?.single?.deliveryDate);
                    formData.append(`referenceNumber`, that?.single?.referenceNumber);
                    formData.append(`accountCodeId`, that?.single?.accountCodeId);
                    formData.append(`orderMethodId`, that?.single?.orderMethodId);
                    that?.single?.orders.forEach(function(val, i){
                        formData.append(`orders[${i}][umkmId]`, val?.umkmId);
                        val?.productTypes?.forEach(function(value, idx){
                            formData.append(`orders[${i}][productTypes][${idx}][productTypeId]`, value?.productTypeId);
                            value?.details?.forEach(function(item, index){
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][subdistrictId]`, item?.subdistrictId);
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][qty]`, item?.qty);
                                formData.append(`orders[${i}][productTypes][${idx}][details][${index}][destinationAddress]`, item?.destinationAddress);
                            });
                        });
                    });
                });
                this.dropzoneFile.processQueue();
                this.dropzoneFile.on('success', function(){
                    that.$loaderHide();
                    Swal.fire('Berhasil', 'Data berhasil disimpan.','success').then(()=>{
                        that.$router.push({path: '/pengajuan'});
                    });
                });
            }
        },
        getSubdistrict(keyword, limit) {
            this.selectList.subdistrict.loading = true;
            Api().get(`${this.$apiType('global')}select-list/subdistrict?limit=${limit}&search=${keyword}`)
                .then((response) => {
                    let data = response?.data?.data;
                    data.map(function(item){
                        item.text = item.name;
                    });
                    this.selectList.subdistrict.list = data;
                }).catch((error) => {
                    this.$axiosHandleError(error);
                }).then(() => {
                    this.selectList.subdistrict.loading = false;
                });

        },
        getUmkm(keyword, limit) {
            let that = this
            this.selectList.umkm.loading = true;
            Api().get(`${this.$apiType('global')}select-list/umkm?length=${limit}&search=${keyword}`)
                .then((response) => {
                    let data = response.data.data;
                    data.map(function(item){
                        item.text = item.name;
                    });
                    this.selectList.umkm.list = data;
                }).catch((error) => {
                    this.$axiosHandleError(error)
                }).then(() => {
                    this.selectList.umkm.loading = false;
                });
        },
        getProductType() {
            this.selectList.productType.loading = true;
            Api().get(`${this.$apiType('global')}select-list/product-type`)
                .then((response) => {
                    let data = response.data.data;
                    data.map(function(item){
                        item.text = item.name;
                    });
                    this.selectList.productType.list = data;
                }).catch((error) => {
                    this.$axiosHandleError(error)
                })
                .then(() => {
                    this.selectList.productType.loading = false;
                });
        },
        addOrder(){
            this.single.orders.push({
                umkm: '',
                umkmId: '', //
                productTypes: [
                    {
                        productType: '',
                        productTypeId: '', //
                        details: [
                            {
                                subdistrict: '',
                                subdistrictId: '', //
                                qty: 0,
                                destinationAddress: '',
                            }
                        ]
                    }
                ]
            });
        },
        addProductType(){
            this.single.orders.productTypes.push({
                productType: '',
                productTypeId: '', //
                details: [
                    {
                        subdistrict: '',
                        subdistrictId: '', //
                        qty: 0,
                        destinationAddress: '',
                    }
                ]
            });
        },
        addDetail(indexOrder, indexProduct){
            this.single.orders[indexOrder].productTypes[indexProduct].details.push({
                subdistrict: '',
                subdistrictId: '', //
                qty: 0,
                destinationAddress: '',
            });
        },
        removeOrder(index){
            this.single.orders.slice(index, 1);
        },
        removeProductType(index, idx){
            this.single.orders[index].productTypes.splice(idx, 1);
        },
        removeDetail(index, idx, i){
            this.single.orders[index].productTypes[idx].details.splice(i, 1);
        },
        countPrice(index, idx, i){
            let that = this;

            let total = Number(that?.single?.orders[index]?.productTypes[idx]?.details[i]?.qty)*Number(that?.single?.orders[index]?.productTypes[idx]?.productType?.price);

            return isNaN(total) ? 0 : total;
        },
        totalPrice(index, idx){
            let that = this;

            let total = 0;
            this?.single?.orders[index]?.productTypes[idx]?.details?.forEach(function(val, i){
                total += Number(val?.qty)*Number(that?.single?.orders[index]?.productTypes[idx]?.productType?.price);
            });

            return isNaN(total) ? 0 : total;
        },
        totalOrderProduct(){
            let that = this;

            let total = 0;
            this?.single?.orders?.forEach(function(item, index){
                item?.productTypes?.forEach(function(value, idx){
                    value?.details?.forEach(function(val, i){
                        total += Number(val?.qty);
                    });
                });
            });

            return total;
        },
        countQtyProductTypes(data){
            let that = this;

            let total = 0;
            data.forEach(function(val,i){
                total += Number(val?.qty);
            });

            return isNaN(total) ? 0 : total;
        },
        totalOrder(){
            let that = this;

            let total = 0;
            this?.single?.orders?.forEach(function(item, index){
                item?.productTypes?.forEach(function(value, idx){
                    value?.details?.forEach(function(val, i){
                        total += Number(val?.qty)*Number(value?.productType?.price);
                    });
                });
            });

            return isNaN(total) ? 0 : total;
        },
    }
}


</script>

