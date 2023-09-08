<template>
    <div class="d-flex flex-column flex-root">
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
                                  <span class="fw-bolder fs-4">Edit UMKM</span>&ensp;<a
                                    href="javascript:void(0)"
                                    @click="$router.back()"
                                    class="text-gray-500"
                                    >|&ensp;&ensp;Data UMKM </a
                                  >&ensp;-&ensp; Edit Data
                                  <h1 style="font-size: 30px !important;" class="py-5  fw-bold">Edit Data UMKM</h1>
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
                                    <div class="card-body pt-5">
                                        <div class="row py-3">
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label fs-6"
                                                :class="v$.single.name.$error ? 'text-danger' : ''" >Nama UMKM
                                                </label>
                                                <input class="form-control" type="text" v-model="single.name"
                                                    placeholder="Cth: Rww" autocomplete="off" />
                                                <div v-if="v$.single.name.$error"
                                                    class="text-danger"> Nama UMKM
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                                <div class="text-danger" >
                                                    </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label fs-6"
                                                :class="v$.single.ownerName.$error ? 'text-danger' : ''" >Nama Pemilik
                                                </label>
                                                <input class="form-control" type="text" v-model="single.ownerName"
                                                    placeholder="Cth: Rapat, acara sosialisasi" autocomplete="off" />
                                                <div v-if="v$.single.ownerName.$error"
                                                    class="text-danger"> Nama Pemilik
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                                <div class="text-danger" >
                                                    </div>
                                            </div>
                                           
                                        </div>
                                        <div class="row py-3">
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label fs-6"
                                                :class="v$.single.whatsappNumber.$error ? 'text-danger' : ''" >Nomor Whatsapp Pemilik
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text" style="color:#5E6278"><span class="svg-icon svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo8/dist/../src/media/svg/icons/Communication/Active-call.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M13.0799676,14.7839934 L15.2839934,12.5799676 C15.8927139,11.9712471 16.0436229,11.0413042 15.6586342,10.2713269 L15.5337539,10.0215663 C15.1487653,9.25158901 15.2996742,8.3216461 15.9083948,7.71292558 L18.6411989,4.98012149 C18.836461,4.78485934 19.1530435,4.78485934 19.3483056,4.98012149 C19.3863063,5.01812215 19.4179321,5.06200062 19.4419658,5.11006808 L20.5459415,7.31801948 C21.3904962,9.0071287 21.0594452,11.0471565 19.7240871,12.3825146 L13.7252616,18.3813401 C12.2717221,19.8348796 10.1217008,20.3424308 8.17157288,19.6923882 L5.75709327,18.8875616 C5.49512161,18.8002377 5.35354162,18.5170777 5.4408655,18.2551061 C5.46541191,18.1814669 5.50676633,18.114554 5.56165376,18.0596666 L8.21292558,15.4083948 C8.8216461,14.7996742 9.75158901,14.6487653 10.5215663,15.0337539 L10.7713269,15.1586342 C11.5413042,15.5436229 12.4712471,15.3927139 13.0799676,14.7839934 Z" fill="#000000"/>
                                                            <path d="M14.1480759,6.00715131 L13.9566988,7.99797396 C12.4781389,7.8558405 11.0097207,8.36895892 9.93933983,9.43933983 C8.8724631,10.5062166 8.35911588,11.9685602 8.49664195,13.4426352 L6.50528978,13.6284215 C6.31304559,11.5678496 7.03283934,9.51741319 8.52512627,8.02512627 C10.0223249,6.52792766 12.0812426,5.80846733 14.1480759,6.00715131 Z M14.4980938,2.02230302 L14.313049,4.01372424 C11.6618299,3.76737046 9.03000738,4.69181803 7.1109127,6.6109127 C5.19447112,8.52735429 4.26985715,11.1545872 4.51274152,13.802405 L2.52110319,13.985098 C2.22450978,10.7517681 3.35562581,7.53777247 5.69669914,5.19669914 C8.04101739,2.85238089 11.2606138,1.72147333 14.4980938,2.02230302 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span></span>
                                                    <input class="form-control" type="text" v-model="single.whatsappNumber"
                                                        placeholder="Cth: 0318903129" autocomplete="off" />
                                                </div>
                                                <div v-if="v$.single.whatsappNumber.$error"
                                                    class="text-danger"> Nomor Whatsapp Pemilik
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label fs-6"
                                                :class="v$.single.subdistrict.$error ? 'text-danger' : ''">Kecamatan</label>
                                            <app-select-single v-model="single.subdistrict" :loading="pageStatus == 'subdistrict-load'"
                                                :placeholder="'Pilih Kecamatan'" :options="subdistrict"
                                                @change-search="getSubdistrict" :serverside="true" :show_button_clear="false">
                                            </app-select-single>
                                            <div v-if="v$.single.subdistrict.$error" class="text-danger">
                                                Pilih Salah Satu!
                                            </div>
                                            </div>
                                        </div>
                                        <div class="py-3">
                                            <label class="form-label fs-6"
                                            :class="v$.single.address.$error ? 'text-danger' : ''" >Alamat Lengkap UMKM
                                            </label>
                                            <input class="form-control" type="text" v-model="single.address"
                                                placeholder="Cth: Jl. Tandes Lor Gang 3 No 38 ( Depan masjid Nurul Iman)" autocomplete="off" />
                                            <div v-if="v$.single.address.$error"
                                                class="text-danger"> Alamat
                                                tidak
                                                boleh kosong!
                                            </div>
                                        </div>
                                        <div class="form-check form-check-custom form-check-solid py-3">
                                            <input class="form-check-input" id="product-type" name="isMbr" :value="single.isMbr" type="checkbox" v-model="single.isMbr" />
                                            <h5 class="mx-3">Masyarakat MBR</h5>
                                          </div>
                                          <div class="row">
                                            <div class="py-3 col-lg-6">
                                                <label class="form-label fs-6"
                                                :class="v$.single.nikNumber.$error ? 'text-danger' : ''" >NIK Pemilik
                                                </label>
                                                <input class="form-control" type="text" v-model="single.nikNumber"
                                                    placeholder="Cth: 357 808 090 774 0004" autocomplete="off" />
                                                <div v-if="v$.single.nikNumber.$error"
                                                    class="text-danger"> Nomor NIK
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                                <div class="py-3">
                                                    <div class="d-inline flex" v-for="(context, index) in dropzoneKtp">
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3 " style="position: relative;" >
                                                                <div @click="removeImage(context.id)" class="bg-danger text-light text-center" style="position:absolute; top:0; right:0; border-radius:100%; width:20px; height:20px; cursor:pointer;">x</div>
                                                                <a  :href="context.link + '?token=' + this.token + '&preview=1' " target="_blank">
                                                                    <img class="py-2" v-if="context?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'png' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'jpeg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'pdf' " :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                                    style="width:50px;" />
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                                    {{$noNullable(context?.name)}}
                                                                </div>
                                                                <div class="text-gray-500">
                                                                    {{$formatBytes(context?.size)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-lg-6 mt-5 mb-5">
                                                <label class="form-label fs-6">Unggah KTP (Opsional)</label>
                                              <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-ktp">
                                                  <div class="dz-message needsclick">
                                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M31.875 38.125V13.125C31.875 11.7443 30.7557 10.625 29.375 10.625C27.9943 10.625 26.875 11.7443 26.875 13.125V38.125C26.875 39.5057 27.9943 40.625 29.375 40.625C30.7557 40.625 31.875 39.5057 31.875 38.125Z" fill="#009EF7"/>
                                                        <path d="M30.1432 15.2975L33.8007 19.6865C34.7802 20.8621 36.5579 20.9427 37.6399 19.8607C38.6142 18.8864 38.6602 17.3216 37.7447 16.2917L31.2435 8.97777C30.249 7.85897 28.5009 7.85897 27.5064 8.97777L21.0051 16.2917C20.0897 17.3216 20.1357 18.8864 21.11 19.8607C22.192 20.9427 23.9696 20.8621 24.9492 19.6865L28.6067 15.2975C29.0064 14.8178 29.7434 14.8178 30.1432 15.2975Z" fill="#009EF7"/>
                                                        <path d="M46.875 20.625H44.375C42.9943 20.625 41.875 21.7443 41.875 23.125C41.875 24.5057 42.9943 25.625 44.375 25.625C45.7557 25.625 46.875 26.7443 46.875 28.125V45.625C46.875 47.0058 45.7557 48.125 44.375 48.125H14.375C12.9943 48.125 11.875 47.0058 11.875 45.625V28.125C11.875 26.7443 12.9943 25.625 14.375 25.625C15.7557 25.625 16.875 24.5057 16.875 23.125C16.875 21.7443 15.7557 20.625 14.375 20.625H11.875C9.11357 20.625 6.875 22.8636 6.875 25.625V48.125C6.875 50.8865 9.11357 53.125 11.875 53.125H46.875C49.6365 53.125 51.875 50.8865 51.875 48.125V25.625C51.875 22.8636 49.6365 20.625 46.875 20.625Z" fill="#009EF7"/>
                                                        </svg>
                                                      <div class="ms-4">
                                                          <h5 class="kt-dropzone__msg-title">
                                                              Drop files here or click to upload
                                                          </h5>
                                                          <span class="kt-dropzone__msg-desc text-primary">
                                                            Upload up to 10 files with the format .jpg/.jpeg/.pdf
                                                          </span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div> 
                                        </div>
                                          <div class="row">
                                            <div class="py-3 col-lg-6">
                                                <label class="form-label fs-6"
                                                :class="v$.single.npwpNumber.$error ? 'text-danger' : ''" >Nomor NPWP Pemilik
                                                </label>
                                                <input class="form-control" type="text" v-model="single.npwpNumber"
                                                    placeholder="Cth: 01.855.081.4-412.000" autocomplete="off" />
                                                <div v-if="v$.single.npwpNumber.$error"
                                                    class="text-danger"> Nomor NPWP
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                                <div class="py-3">
                                                    <template v-for="(item, index) in dropzoneNpwp" :key="index">
                                                        
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3" style="position: relative;">
                                                                <div @click="removeNpwp(item.id)" class="bg-danger text-light text-center" style="position:absolute; top:0; right:0; border-radius:100%; width:20px; height:20px; cursor:pointer;">x</div>
                                                                <a  :href="item.link + '?token=' + this.token + '&preview=1' " target="_blank">
                                                                    <img class="py-2" v-if="item?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="item?.ext == 'png' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="item?.ext == 'jpeg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="item?.ext == 'pdf' " :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                                    style="width:50px;" />
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                                    {{$noNullable(item.name)}}
                                                                </div>
                                                                <div class="text-gray-500">
                                                                    {{$formatBytes(item.size)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                    </template>
                                                </div>
                                            </div>
                                            <div class=" col-lg-6 mt-5 mb-5">
                                                <label class="form-label fs-6">Unggah NPWP (Opsional)</label>
                                              <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-npwp">
                                                  <div class="dz-message needsclick">
                                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M31.875 38.125V13.125C31.875 11.7443 30.7557 10.625 29.375 10.625C27.9943 10.625 26.875 11.7443 26.875 13.125V38.125C26.875 39.5057 27.9943 40.625 29.375 40.625C30.7557 40.625 31.875 39.5057 31.875 38.125Z" fill="#009EF7"/>
                                                        <path d="M30.1432 15.2975L33.8007 19.6865C34.7802 20.8621 36.5579 20.9427 37.6399 19.8607C38.6142 18.8864 38.6602 17.3216 37.7447 16.2917L31.2435 8.97777C30.249 7.85897 28.5009 7.85897 27.5064 8.97777L21.0051 16.2917C20.0897 17.3216 20.1357 18.8864 21.11 19.8607C22.192 20.9427 23.9696 20.8621 24.9492 19.6865L28.6067 15.2975C29.0064 14.8178 29.7434 14.8178 30.1432 15.2975Z" fill="#009EF7"/>
                                                        <path d="M46.875 20.625H44.375C42.9943 20.625 41.875 21.7443 41.875 23.125C41.875 24.5057 42.9943 25.625 44.375 25.625C45.7557 25.625 46.875 26.7443 46.875 28.125V45.625C46.875 47.0058 45.7557 48.125 44.375 48.125H14.375C12.9943 48.125 11.875 47.0058 11.875 45.625V28.125C11.875 26.7443 12.9943 25.625 14.375 25.625C15.7557 25.625 16.875 24.5057 16.875 23.125C16.875 21.7443 15.7557 20.625 14.375 20.625H11.875C9.11357 20.625 6.875 22.8636 6.875 25.625V48.125C6.875 50.8865 9.11357 53.125 11.875 53.125H46.875C49.6365 53.125 51.875 50.8865 51.875 48.125V25.625C51.875 22.8636 49.6365 20.625 46.875 20.625Z" fill="#009EF7"/>
                                                        </svg>
                                                      <div class="ms-4">
                                                          <h5 class="kt-dropzone__msg-title">
                                                              Drop files here or click to upload
                                                          </h5>
                                                          <span class="kt-dropzone__msg-desc text-primary">
                                                            Upload up to 10 files with the format .jpg/.jpeg/.pdf
                                                          </span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div> 
                                        </div>
                                          <div class="row">
                                            <div class="py-3 col-lg-6">
                                                <label class="form-label fs-6"
                                                :class="v$.single.nibNumber.$error ? 'text-danger' : ''" >Nomor SIUP / NIB
                                                </label>
                                                <input class="form-control" type="text" v-model="single.nibNumber"
                                                    placeholder="Cth: 503/9541.A/436.6.11/2015" autocomplete="off" />
                                                <div v-if="v$.single.nibNumber.$error"
                                                    class="text-danger"> Nomor SIUP / NIB
                                                    tidak
                                                    boleh kosong!
                                                </div>
                                                <div class="py-3">
                                                    <div class="d-inline flex" v-for="(context, index) in dropzoneNib">
                                                        
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3 " style="position: relative;">
                                                                <div @click="remove(context.id)" class="bg-danger text-light text-center" style="position:absolute; top:0; right:0; border-radius:100%; width:20px; height:20px; cursor:pointer;">x</div>
                                                                <a  :href="context.link + '?token=' + this.token + '&preview=1' " target="_blank">
                                                                    <img class="py-2" v-if="context?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'png' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'jpeg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                    style="width:50px;" />
                                                                    <img class="py-2" v-if="context?.ext == 'pdf' " :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                                    style="width:50px;" />
                                                                </a>
                                                            </div>
                                                            <div>
                                                                <div  class="fw-bolder text-primary" style="word-break: break-word;">
                                                                    {{$noNullable(context?.name)}}
                                                                </div>
                                                                <div class="text-gray-500">
                                                                    {{$formatBytes(context?.size)}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" col-lg-6 mt-5 mb-5">
                                                <label class="form-label fs-6">Unggah SIUP / NIB (Opsional)</label>
                                              <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-nib">
                                                  <div class="dz-message needsclick">
                                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M31.875 38.125V13.125C31.875 11.7443 30.7557 10.625 29.375 10.625C27.9943 10.625 26.875 11.7443 26.875 13.125V38.125C26.875 39.5057 27.9943 40.625 29.375 40.625C30.7557 40.625 31.875 39.5057 31.875 38.125Z" fill="#009EF7"/>
                                                        <path d="M30.1432 15.2975L33.8007 19.6865C34.7802 20.8621 36.5579 20.9427 37.6399 19.8607C38.6142 18.8864 38.6602 17.3216 37.7447 16.2917L31.2435 8.97777C30.249 7.85897 28.5009 7.85897 27.5064 8.97777L21.0051 16.2917C20.0897 17.3216 20.1357 18.8864 21.11 19.8607C22.192 20.9427 23.9696 20.8621 24.9492 19.6865L28.6067 15.2975C29.0064 14.8178 29.7434 14.8178 30.1432 15.2975Z" fill="#009EF7"/>
                                                        <path d="M46.875 20.625H44.375C42.9943 20.625 41.875 21.7443 41.875 23.125C41.875 24.5057 42.9943 25.625 44.375 25.625C45.7557 25.625 46.875 26.7443 46.875 28.125V45.625C46.875 47.0058 45.7557 48.125 44.375 48.125H14.375C12.9943 48.125 11.875 47.0058 11.875 45.625V28.125C11.875 26.7443 12.9943 25.625 14.375 25.625C15.7557 25.625 16.875 24.5057 16.875 23.125C16.875 21.7443 15.7557 20.625 14.375 20.625H11.875C9.11357 20.625 6.875 22.8636 6.875 25.625V48.125C6.875 50.8865 9.11357 53.125 11.875 53.125H46.875C49.6365 53.125 51.875 50.8865 51.875 48.125V25.625C51.875 22.8636 49.6365 20.625 46.875 20.625Z" fill="#009EF7"/>
                                                        </svg>
                                                      <div class="ms-4">
                                                          <h5 class="kt-dropzone__msg-title">
                                                              Drop files here or click to upload
                                                          </h5>
                                                          <span class="kt-dropzone__msg-desc text-primary">
                                                            Upload up to 10 files with the format .jpg/.jpeg/.pdf
                                                          </span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div> 
                                        </div>
                                          <div class="row">
                                            <div class="py-3 col-lg-6">
                                                <label class="form-label fs-6"
                                                >Nomor Surat Referensi Bank (Opsional)
                                                </label>
                                                <input class="form-control" type="text" v-model="single.bankReferenceNumber"
                                                    placeholder="Cth: 503/9541.A/436.6.11/2015" autocomplete="off" />
                                                    <div class="py-3">
                                                        <template v-for="(context,index) in dropzoneBankReference">
                                                          
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-3" style="position:relative" >
                                                                    <div @click="removeBank(context.id)" class="bg-danger text-light text-center" style="position:absolute; top:0; right:0; border-radius:100%; width:20px; height:20px; cursor:pointer;">x</div>
                                                                    <a  :href="context.link + '?token=' + this.token + '&preview=1' " target="_blank">
                                                                        <img class="py-2" v-if="context?.ext == 'jpg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                        style="width:50px;" />
                                                                        <img class="py-2" v-if="context?.ext == 'png' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                        style="width:50px;" />
                                                                        <img class="py-2" v-if="context?.ext == 'jpeg' " :src="$assetUrl() + 'extends/images/ic_files_img.png'"
                                                                        style="width:50px;" />
                                                                        <img class="py-2" v-if="context?.ext == 'pdf' " :src="$assetUrl() + 'extends/images/ic_files_pdf.png'"
                                                                        style="width:50px;" />
                                                                    </a>
                                                                  
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bolder text-primary" style="word-break: break-word;">
                                                                        {{$noNullable(context.name)}}
                                                                    </div>
                                                                    <div class="text-gray-500">
                                                                        {{$formatBytes(context.size)}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                      
                                                        </template>
                                                    </div>
                                            </div>
                                            <div class=" col-lg-6 mt-5 mb-5">
                                                <label class="form-label fs-6">Unggah Surat Referensi Bank (Opsional)</label>
                                              <div class="dropzone dropzone-file-area dz-clickable" id="dropzone-bank-reference">
                                                  <div class="dz-message needsclick">
                                                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3" d="M31.875 38.125V13.125C31.875 11.7443 30.7557 10.625 29.375 10.625C27.9943 10.625 26.875 11.7443 26.875 13.125V38.125C26.875 39.5057 27.9943 40.625 29.375 40.625C30.7557 40.625 31.875 39.5057 31.875 38.125Z" fill="#009EF7"/>
                                                        <path d="M30.1432 15.2975L33.8007 19.6865C34.7802 20.8621 36.5579 20.9427 37.6399 19.8607C38.6142 18.8864 38.6602 17.3216 37.7447 16.2917L31.2435 8.97777C30.249 7.85897 28.5009 7.85897 27.5064 8.97777L21.0051 16.2917C20.0897 17.3216 20.1357 18.8864 21.11 19.8607C22.192 20.9427 23.9696 20.8621 24.9492 19.6865L28.6067 15.2975C29.0064 14.8178 29.7434 14.8178 30.1432 15.2975Z" fill="#009EF7"/>
                                                        <path d="M46.875 20.625H44.375C42.9943 20.625 41.875 21.7443 41.875 23.125C41.875 24.5057 42.9943 25.625 44.375 25.625C45.7557 25.625 46.875 26.7443 46.875 28.125V45.625C46.875 47.0058 45.7557 48.125 44.375 48.125H14.375C12.9943 48.125 11.875 47.0058 11.875 45.625V28.125C11.875 26.7443 12.9943 25.625 14.375 25.625C15.7557 25.625 16.875 24.5057 16.875 23.125C16.875 21.7443 15.7557 20.625 14.375 20.625H11.875C9.11357 20.625 6.875 22.8636 6.875 25.625V48.125C6.875 50.8865 9.11357 53.125 11.875 53.125H46.875C49.6365 53.125 51.875 50.8865 51.875 48.125V25.625C51.875 22.8636 49.6365 20.625 46.875 20.625Z" fill="#009EF7"/>
                                                        </svg>
                                                      <div class="ms-4">
                                                          <h5 class="kt-dropzone__msg-title">
                                                              Drop files here or click to upload
                                                          </h5>
                                                          <span class="kt-dropzone__msg-desc text-primary">
                                                            Upload up to 10 files with the format .jpg/.jpeg/.pdf
                                                          </span>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div> 
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-white border border-secondary text-gray-600 me-5" @click="$router.back()">Kembali</button>
                                        <button class="btn bg-dark" type="submit"  @click="update()">
                                            <span class="indicator-label text-white">Simpan Data</span>
                                        </button>
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

    import useVuelidate from '@vuelidate/core'
    import {
        required
    } from '@vuelidate/validators'
    export default {
        data() {
            return {
                pageStatus: 'stanby',
                token: '',
                dropzoneKtp: null,
                dropzoneNib: null,
                dropzoneNpwp: null,
                dropzoneBankReference: null,
                form: {
                    dropzoneKtp: null,
                    dropzoneNib: null,
                    dropzoneNpwp: null,
                    dropzoneBankReference: null
                },
                v$: useVuelidate(),
                single: {   
                    name : ' ',               
                    ownerName : ' ',
                    whatsappNumber: '',
                    isMbr: false,
                    nikNumber: '',
                    npwpNumber: '',
                    nibNumber: '',
                    bankReferenceNumber: '',             
                    id: '',
                    event: '',
                    dateEvent: '',
                    dateShipping: '',
                    address: '',
                    subdistrict: {},
                    orderMethod: '',
                    typeProduct: [],
                    umkm : {}
                },
                subdistrict : [],
                orderMethod: [],
                typeProduct: [],
                umkm: [],
                deletedFileId:[]

            }
        },
        validations() {
            return {
                single: {
                    
                        subdistrict: {
                            required
                        },
                        name: {
                            required
                        },
                        ownerName: {
                            required
                        },
                        whatsappNumber: {
                            required
                        },
                        nikNumber:{
                            required
                        },
                        npwpNumber:{
                            required
                        },
                        productType:{
                            required
                        },
                        nibNumber:{
                            required
                        },
                        address:{
                            required
                        }

                },
            }
        },
        mounted() {
            this.$initializeAppPlugins();
            this.detailUmkm();
            this.initDropzone();
        },
        methods: {  
            initDropzone() {
                let that = this;
                if(this.form.dropzoneKtp){
                    this.form.dropzoneKtp.destroy();
                    $('.dz-preview.dz-complete.dz-image-preview').remove();
                }
                if(this.form.dropzoneNib){
                    this.form.dropzoneNib.destroy();
                    $('.dz-preview.dz-complete.dz-image-preview').remove();
                }
                if(this.form.dropzoneNpwp){
                    this.form.dropzoneNpwp.destroy();
                    $('.dz-preview.dz-complete.dz-image-preview').remove();
                }
                if(this.form.dropzoneBankReference){
                    this.form.dropzoneBankReference.destroy();
                    $('.dz-preview.dz-complete.dz-image-preview').remove();
                }
                this.form.dropzoneKtp = new Dropzone("#dropzone-ktp", {
                    url: `/`,
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 100,
                    uploadMultiple: true,
                    maxFiles: 100,
                    addRemoveLinks: true,
                    acceptedFiles: ".jpg,.jpeg,.png,.pdf",
                    autoProcessQueue: false,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    },
                    init: function () {
                        
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal("Silahkan periksa file Anda lagi");
                            } else if (file.status == "error") {
                                this.removeFile(file);
                                that.$swal("Terjadi kesalahan koneksi");
                            }
                        });

                        this.on("resetFiles", function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
                this.form.dropzoneNpwp = new Dropzone("#dropzone-npwp", {
                    url: `/`,
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 100,
                    uploadMultiple: true,
                    maxFiles: 100,
                    addRemoveLinks: true,
                    acceptedFiles: ".jpg,.jpeg,.png,.pdf",
                    autoProcessQueue: false,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    },
                    init: function () {
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal("Silahkan periksa file Anda lagi");
                            } else if (file.status == "error") {
                                this.removeFile(file);
                                that.$swal("Terjadi kesalahan koneksi");
                            }
                        });

                        this.on("resetFiles", function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
                this.form.dropzoneNib = new Dropzone("#dropzone-nib", {
                    url: `/`,
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 100,
                    uploadMultiple: true,
                    maxFiles: 100,
                    addRemoveLinks: true,
                    acceptedFiles: ".jpg,.jpeg,.png,.pdf",
                    autoProcessQueue: false,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    },
                    init: function () {
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal("Silahkan periksa file Anda lagi");
                            } else if (file.status == "error") {
                                this.removeFile(file);
                                that.$swal("Terjadi kesalahan koneksi");
                            }
                        });

                        this.on("resetFiles", function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
                this.form.dropzoneBankReference = new Dropzone("#dropzone-bank-reference", {
                    url: `/`,
                    dictCancelUpload: "Cancel",
                    maxFilesize: 20,
                    parallelUploads: 100,
                    uploadMultiple: true,
                    maxFiles: 100,
                    addRemoveLinks: true,
                    acceptedFiles: ".jpg,.jpeg,.png,.pdf",
                    autoProcessQueue: false,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    Authorization: "Bearer " + localStorage.getItem("token"),
                    },
                    init: function () {
                        this.on("addedfile", function (file) {
                            if (this.files.length > 1) {
                                this.removeFile(this.files[0]);
                            }
                        });
                        this.on("error", function (file) {
                            if (!file.accepted) {
                                this.removeFile(file);
                                that.$swal("Silahkan periksa file Anda lagi");
                            } else if (file.status == "error") {
                                this.removeFile(file);
                                that.$swal("Terjadi kesalahan koneksi");
                            }
                        });

                        this.on("resetFiles", function (file) {
                            this.removeAllFiles();
                        });
                    },
                });
            },
            detailUmkm(){
                Api().get(`${this.$apiType('web')}master/umkm/${this.$route.params.id}`)
                .then(response =>{
                    let data = response.data.data;
                    this.single.name = data?.name;
                    this.single.ownerName = data?.ownerName;
                    this.single.isMbr = data?.isMbr;
                    this.single.address = data?.address;
                    this.single.whatsappNumber = data?.whatsappNumber;
                    this.single.nikNumber = data?.nikNumber;
                    this.single.npwpNumber = data?.npwpNumber;
                    this.single.nibNumber = data?.nibNumber;
                    this.single.bankReferenceNumber = data?.bankReferenceNumber;
                    this.single.subdistrict =  {
                        id: data?.subdistrict?.id,
                        text:data?.subdistrict?.name
                    };
                    this.dropzoneNib = data?.nibFile;
                    this.dropzoneKtp = data?.ktpFile;
                    this.dropzoneNpwp = data?.npwpFile;
                    this.dropzoneBankReference = data?.bankReferenceFile

                }).catch((err)=>{
                    this.$axiosHandleError(err);
                })
            },
           
        getSubdistrict(keyword, limit){
            this.pageStatus = 'subdistrict-load';

            Api().get(`${this.$apiType('global')}select-list/subdistrict?limit=${limit}&search=${keyword}`)
            .then((response) => {
                this.subdistrict = [];
                for(let i = 0; i < response.data.data.length; i++){
                    this.subdistrict.push({
                        id: response.data.data[i].id,
                        text: response.data.data[i].name
                    })
                }
            }).catch((error) =>{
                this.subdistrict = []
                this.$axiosHandleError(error);
            }).then(()=>{
                this.pageStatus = 'standby'
            })

        },
        removeImage(id){
            let that = this
            this.$swal.fire({
                title : 'Yakin hapus file yang anda pilih ?',
                text: ' File yang telah dihapus tidak dapat dikembalikan lagi',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f1416c',
                cancelButtonColor: 'lightgray',

            }).then(result =>{
                if(result.isConfirmed){
                    that.deletedFileId?.push(id);
                    let umkmId = that.dropzoneKtp?.findIndex(val => val?.id == id);
                    that.dropzoneKtp?.splice(umkmId, 1);
                
                }
               
            });
                
        },
        remove(id){
            let that = this
            this.$swal.fire({
                title : 'Yakin hapus file yang anda pilih ?',
                text: ' File yang telah dihapus tidak dapat dikembalikan lagi',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f1416c',
                cancelButtonColor: 'lightgray',

            }).then(result =>{
                if(result.isConfirmed){
                    that.deletedFileId?.push(id);

                    let nibId = that.dropzoneNib?.findIndex(valx => valx?.id == id);
              
                    that.dropzoneNib?.splice(nibId, 1);

                }
               
            });
                
        },
        removeNpwp(id){
            let that = this
            this.$swal.fire({
                title : 'Yakin hapus file yang anda pilih ?',
                text: ' File yang telah dihapus tidak dapat dikembalikan lagi',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f1416c',
                cancelButtonColor: 'lightgray',

            }).then(result =>{
                if(result.isConfirmed){
                    that.deletedFileId?.push(id);

                    let npwpId = that.dropzoneNpwp?.findIndex(valx => valx?.id == id);

                    that.dropzoneNpwp?.splice(npwpId, 1);
                   
                }
              
            });
                
        },
        removeBank(id){
            let that = this
            this.$swal.fire({
                title : 'Yakin hapus file yang anda pilih ?',
                text: ' File yang telah dihapus tidak dapat dikembalikan lagi',
                icon: 'warning',
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f1416c',
                cancelButtonColor: 'lightgray',

            }).then(result =>{
                if(result.isConfirmed){
                    that.deletedFileId?.push(id);  
                    let bankId = that.dropzoneBankReference?.findIndex(valx => valx?.id == id);
                    that.dropzoneBankReference?.splice(bankId, 1);
                }
            });
                
        },
        update(){
            // this.v$.$touch();
            // if(this.v$.$error){
            //     this.$toast.error("Silahkan lengkapi form terlebih dahulu!");
            //         return false;
            // }
            let that = this
            let formData = new FormData();
            formData.append('name', this.single.name);
            formData.append('ownerName', this.single.ownerName);
            formData.append('whatsappNumber', this.single.whatsappNumber);
            formData.append('subdistrictId', this.single.subdistrict.id);
            formData.append('address', this.single.address);
            formData.append('isMbr', this.single.isMbr);
            formData.append('nikNumber', this.single.nikNumber);
            formData.append('npwpNumber', this.single.npwpNumber);
            formData.append('nibNumber', this.single.nibNumber);
            formData.append('bankReferenceNumber', this.single.bankReferenceNumber ?? '');
   
            if (!$.isEmptyObject(this.form.dropzoneKtp?.files)) {
                    for (let file in this.form.dropzoneKtp.files) {
                     formData.append(`fileKtp[${file}]`, this.form.dropzoneKtp.files[file]);
                    }
                }
            if (!$.isEmptyObject(this.form.dropzoneNib?.files)) {
                    for (let file in this.form.dropzoneNib.files) {
                        formData.append(`fileNib[${file}]`, this.form.dropzoneNib.files[file]);
                    }
                }
            if (!$.isEmptyObject(this.form.dropzoneNpwp.files)) {
                    for (let file in this.form.dropzoneNpwp.files) {
                        formData.append(`fileNpwp[${file}]`, this.form.dropzoneNpwp.files[file]);
                    }
                }
            if (!$.isEmptyObject(this.form.dropzoneBankReference?.files)) {
                    for (let file in this.form.dropzoneBankReference?.files) {
                        formData.append(`fileBankReference[${file}]`, this.form.dropzoneBankReference?.files[file]);
                    }
                }
            for(let x = 0; x < this.deletedFileId.length; x++){
                formData.append(`deleteFileId[${x}]`, this.deletedFileId[x] )
            }
                this.$loaderShow();
                Api().post(`${this.$apiType('web')}master/umkm/${this.$route.params.id}`, formData)
                    .then(response => {
                        this.$swal({
                            title: "Berhasil!",
                            text: 'Edit Data UMKM',
                            icon: "success",
                        }).then(result => {

                            this.$router.push({
                                path:'/umkm'
                            })
                            
                        });
                      
                    })
                    .catch(error => {
                        this.$axiosHandleError(error);
                    }).then(() => {
                        this.$loaderHide();
                    });
        }
        },
    }
    

</script>

