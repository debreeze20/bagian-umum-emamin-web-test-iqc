<template>
    <div id="kt_aside" class="aside aside-light aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
        data-kt-drawer-toggle="#kt_aside_mobile_toggle">
        <!--begin::Brand-->
        <div class="aside-logo flex-column-auto" id="kt_aside_logo">
            <!--begin::Logo-->
            <router-link to="/">
                <img alt="Logo" :src="`${$assetUrl()}extends/images/logo-2.png`" class="logo">
            </router-link>
            <!--end::Logo-->
            <!--begin::Aside toggler-->
            <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="aside-minimize">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="black"></path>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="black"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Aside toggler-->
        </div>
        <!--end::Brand-->
        <!--begin::Aside menu-->
        <div class="aside-menu flex-column-fluid">
            <!--begin::Aside Menu-->
            <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
                data-kt-scroll-offset="0" style="height: 471px;">
                <!--begin::Menu-->
                <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                    id="#kt_aside_menu" data-kt-menu="true">
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN])"
                        :class="isCurrentUrl(['dashboard']) ? 'active' : ''">
                        <router-link class="menu-link" to="/">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                            fill="#B5B5C3" />
                                        <path
                                            d="M8.70001 6C8.10001 5.7 7.39999 5.40001 6.79999 5.10001C7.79999 4.00001 8.90001 3 10.1 2.2C10.7 2.1 11.4 2 12 2C12.7 2 13.3 2.1 13.9 2.2C12 3.2 10.2 4.5 8.70001 6ZM12 8.39999C13.9 6.59999 16.2 5.30001 18.7 4.60001C18.1 4.00001 17.4 3.6 16.7 3.2C14.4 4.1 12.2 5.40001 10.5 7.10001C11 7.50001 11.5 7.89999 12 8.39999ZM7 20C7 20.2 7 20.4 7 20.6C6.2 20.1 5.49999 19.6 4.89999 19C4.59999 18 4.00001 17.2 3.20001 16.6C2.80001 15.8 2.49999 15 2.29999 14.1C4.99999 14.7 7 17.1 7 20ZM10.6 9.89999C8.70001 8.09999 6.39999 6.9 3.79999 6.3C3.39999 6.9 2.99999 7.5 2.79999 8.2C5.39999 8.6 7.7 9.80001 9.5 11.6C9.8 10.9 10.2 10.4 10.6 9.89999ZM2.20001 10.1C2.10001 10.7 2 11.4 2 12C2 12 2 12 2 12.1C4.3 12.4 6.40001 13.7 7.60001 15.6C7.80001 14.8 8.09999 14.1 8.39999 13.4C6.89999 11.6 4.70001 10.4 2.20001 10.1ZM11 20C11 14 15.4 9.00001 21.2 8.10001C20.9 7.40001 20.6 6.8 20.2 6.2C13.8 7.5 9 13.1 9 19.9C9 20.4 9.00001 21 9.10001 21.5C9.80001 21.7 10.5 21.8 11.2 21.9C11.1 21.3 11 20.7 11 20ZM19.1 19C19.4 18 20 17.2 20.8 16.6C21.2 15.8 21.5 15 21.7 14.1C19 14.7 16.9 17.1 16.9 20C16.9 20.2 16.9 20.4 16.9 20.6C17.8 20.2 18.5 19.6 19.1 19ZM15 20C15 15.9 18.1 12.6 22 12.1C22 12.1 22 12.1 22 12C22 11.3 21.9 10.7 21.8 10.1C16.8 10.7 13 14.9 13 20C13 20.7 13.1 21.3 13.2 21.9C13.9 21.8 14.5 21.7 15.2 21.5C15.1 21 15 20.5 15 20Z"
                                            fill="#B5B5C3" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN])"
                        :class="isCurrentUrl(['data-verifikasi-user']) ? 'active' : ''">
                        <router-link class="menu-link" to="/data-verifikasi-user">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/art/art002.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 4.00006L11.6314 2.56917C11.875 2.52349 12.125 2.52349 12.3686 2.56917L20 4.00006V13.2831C20 16.2174 18.4883 18.9448 16 20.5001L12.53 22.6688C12.2057 22.8715 11.7943 22.8715 11.47 22.6688L8 20.5001C5.51165 18.9448 4 16.2174 4 13.2831V4.00006Z"
                                            fill="#B5B5C3" />
                                        <path opacity="0.7" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M12 11C10.8954 11 10 10.1046 10 9C10 7.89543 10.8954 7 12 7C13.1046 7 14 7.89543 14 9C14 10.1046 13.1046 11 12 11Z"
                                            fill="#B5B5C3" />
                                        <path opacity="0.7" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.00036 16.4995C7.2157 13.5166 9.36773 12 11.9907 12C14.6507 12 16.836 13.4332 16.9988 16.5C17.0053 16.6222 16.9988 17 16.5815 17C14.5228 17 11.4637 17 7.40417 17C7.26484 17 6.98863 16.662 7.00036 16.4995Z"
                                            fill="#B5B5C3" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="d-flex justify-content-between w-100">
                                <span class="menu-title">Verifikasi User</span>
                                <div class="bg-danger text-white w-25px h-25px d-flex justify-content-center align-items-center"
                                    v-if="countNotif > 0" style="border-radius:100px;">
                                    {{countNotif > 9 ? '9+' : countNotif}}</div>
                            </div>

                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN])"
                        :class="isCurrentUrl(['data-industri']) ? 'active' : ''">
                        <router-link class="menu-link" to="/data-industri">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.5 21V18C13.5 17.4477 13.0523 17 12.5 17H11.5C10.9477 17 10.5 17.4477 10.5 18V21H5V4C5 2.89543 5.89543 2 7 2H17C18.1046 2 19 2.89543 19 4V21H13.5ZM9 4C8.44772 4 8 4.44772 8 5V6C8 6.55228 8.44772 7 9 7H10C10.5523 7 11 6.55228 11 6V5C11 4.44772 10.5523 4 10 4H9ZM14 4C13.4477 4 13 4.44772 13 5V6C13 6.55228 13.4477 7 14 7H15C15.5523 7 16 6.55228 16 6V5C16 4.44772 15.5523 4 15 4H14ZM9 8C8.44772 8 8 8.44772 8 9V10C8 10.5523 8.44772 11 9 11H10C10.5523 11 11 10.5523 11 10V9C11 8.44772 10.5523 8 10 8H9ZM9 12C8.44772 12 8 12.4477 8 13V14C8 14.5523 8.44772 15 9 15H10C10.5523 15 11 14.5523 11 14V13C11 12.4477 10.5523 12 10 12H9ZM14 12C13.4477 12 13 12.4477 13 13V14C13 14.5523 13.4477 15 14 15H15C15.5523 15 16 14.5523 16 14V13C16 12.4477 15.5523 12 15 12H14Z"
                                            fill="#B5B5C3" />
                                        <path
                                            d="M15 8H14C13.4477 8 13 8.44772 13 9V10C13 10.5523 13.4477 11 14 11H15C15.5523 11 16 10.5523 16 10V9C16 8.44772 15.5523 8 15 8Z"
                                            fill="white" />
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 21H20C20.5523 21 21 21.4477 21 22V22.4C21 22.7314 20.7314 23 20.4 23H3.6C3.26863 23 3 22.7314 3 22.4V22C3 21.4477 3.44772 21 4 21Z"
                                            fill="#B5B5C3" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Data Industri</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_INDUSTRY])"
                        :class="isCurrentUrl(['portofolio']) ? 'active' : ''">
                        <router-link class="menu-link" to="/portofolio">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/layouts/lay010.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
                                            fill="#5E6278" />
                                        <path
                                            d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
                                            fill="#5E6278" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Portofolio</span>
                        </router-link>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_INDUSTRY])"
                        :class="isCurrentUrl(['profile-perusahaan']) ? 'active' : ''">
                        <router-link class="menu-link" to="/profile-perusahaan">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com001.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M13.5 21V18C13.5 17.4477 13.0523 17 12.5 17H11.5C10.9477 17 10.5 17.4477 10.5 18V21H5V4C5 2.89543 5.89543 2 7 2H17C18.1046 2 19 2.89543 19 4V21H13.5ZM9 4C8.44772 4 8 4.44772 8 5V6C8 6.55228 8.44772 7 9 7H10C10.5523 7 11 6.55228 11 6V5C11 4.44772 10.5523 4 10 4H9ZM14 4C13.4477 4 13 4.44772 13 5V6C13 6.55228 13.4477 7 14 7H15C15.5523 7 16 6.55228 16 6V5C16 4.44772 15.5523 4 15 4H14ZM9 8C8.44772 8 8 8.44772 8 9V10C8 10.5523 8.44772 11 9 11H10C10.5523 11 11 10.5523 11 10V9C11 8.44772 10.5523 8 10 8H9ZM9 12C8.44772 12 8 12.4477 8 13V14C8 14.5523 8.44772 15 9 15H10C10.5523 15 11 14.5523 11 14V13C11 12.4477 10.5523 12 10 12H9ZM14 12C13.4477 12 13 12.4477 13 13V14C13 14.5523 13.4477 15 14 15H15C15.5523 15 16 14.5523 16 14V13C16 12.4477 15.5523 12 15 12H14Z"
                                            fill="#181C32" />
                                        <path
                                            d="M15 8H14C13.4477 8 13 8.44772 13 9V10C13 10.5523 13.4477 11 14 11H15C15.5523 11 16 10.5523 16 10V9C16 8.44772 15.5523 8 15 8Z"
                                            fill="white" />
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4 21H20C20.5523 21 21 21.4477 21 22V22.4C21 22.7314 20.7314 23 20.4 23H3.6C3.26863 23 3 22.7314 3 22.4V22C3 21.4477 3.44772 21 4 21Z"
                                            fill="#B5B5C3" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Profil Perusahaan</span>
                        </router-link>
                    </div>
                    <div data-kt-menu-trigger="click" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN])"
                        class="menu-item menu-accordion"
                        :class="isCurrentUrl(['master-data-kategori-sektor']) ? 'active show' : ''">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5 2H19C20.1046 2 21 2.89543 21 4V6C21 7.10457 20.1046 8 19 8H5C3.89543 8 3 7.10457 3 6V4C3 2.89543 3.89543 2 5 2ZM11 4C10.4477 4 10 4.44772 10 5C10 5.55228 10.4477 6 11 6H16C16.5523 6 17 5.55228 17 5C17 4.44772 16.5523 4 16 4H11ZM7 6C7.55228 6 8 5.55228 8 5C8 4.44772 7.55228 4 7 4C6.44772 4 6 4.44772 6 5C6 5.55228 6.44772 6 7 6Z"
                                            fill="#B5B5C3" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5 9H19C20.1046 9 21 9.89543 21 11V13C21 14.1046 20.1046 15 19 15H5C3.89543 15 3 14.1046 3 13V11C3 9.89543 3.89543 9 5 9ZM11 11C10.4477 11 10 11.4477 10 12C10 12.5523 10.4477 13 11 13H16C16.5523 13 17 12.5523 17 12C17 11.4477 16.5523 11 16 11H11ZM7 13C7.55228 13 8 12.5523 8 12C8 11.4477 7.55228 11 7 11C6.44772 11 6 11.4477 6 12C6 12.5523 6.44772 13 7 13Z"
                                            fill="#B5B5C3" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M5 16H19C20.1046 16 21 16.8954 21 18V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V18C3 16.8954 3.89543 16 5 16ZM11 18C10.4477 18 10 18.4477 10 19C10 19.5523 10.4477 20 11 20H16C16.5523 20 17 19.5523 17 19C17 18.4477 16.5523 18 16 18H11ZM7 20C7.55228 20 8 19.5523 8 19C8 18.4477 7.55228 18 7 18C6.44772 18 6 18.4477 6 19C6 19.5523 6.44772 20 7 20Z"
                                            fill="#B5B5C3" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Master Data</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion"
                            :class="isCurrentUrl(['master-data-kategori-sektor']) ? 'show' : ''" kt-hidden-height="117">
                            <div class="menu-item"
                                :class="isCurrentUrl(['master-data-kategori-sektor']) ? 'active' : ''">
                                <router-link class="menu-link" to="/master-data/kategori-sektor">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Kategori Sektor</span>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item" v-if="isSpecificHaveAccessMenu([ROLE_ADMIN])"
                        :class="isCurrentUrl(['report']) ? 'active' : ''">
                        <router-link class="menu-link" to="/report">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <span class="svg-icon svg-icon-2 icon-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M16 17V21C16 21.5523 15.5523 22 15 22H9C8.44772 22 8 21.5523 8 21V17H5C3.89543 17 3 16.1046 3 15V8C3 6.89543 3.89543 6 5 6H19C20.1046 6 21 6.89543 21 8V15C21 16.1046 20.1046 17 19 17H16ZM17.5 11C18.3284 11 19 10.3284 19 9.5C19 8.67157 18.3284 8 17.5 8C16.6716 8 16 8.67157 16 9.5C16 10.3284 16.6716 11 17.5 11ZM10 14V20H14V14H10Z" fill="#B5B5C3"/>
<path opacity="0.3" d="M15 2H9C8.44772 2 8 2.44772 8 3C8 3.55228 8.44772 4 9 4H15C15.5523 4 16 3.55228 16 3C16 2.44772 15.5523 2 15 2Z" fill="black"/>
</svg>


                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <span class="menu-title">Report</span>
                        </router-link>
                    </div>
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside menu-->
    </div>
</template>

<script>
    import Api from "@/services/api";
    export default {
        data() {
            return {
                countNotif: 0,
                ROLE_ADMIN: '',
                ROLE_INDUSTRY: ''
            }
        },
        mounted() {
            this.ROLE_INDUSTRY =
                import.meta.env.VITE_ROLE_INDUSTRY;
            this.ROLE_ADMIN =
                import.meta.env.VITE_ROLE_ADMIN;

            if (this.$store.state.profile.roleId == this.ROLE_ADMIN) {
                Api().get(`${this.$apiType('web')}transact/industry/count-need-verified`, {
                        params: {
                            onlyNeedVerified: 1
                        }
                    })
                    .then(response => {
                        this.countNotif = response.data.data;
                    });
            }
        },
        methods: {
            isCurrentUrl(routeName) {
                let response = false;
                for (let i = 0; i < routeName.length; i++) {
                    if (this.$route.name.indexOf(routeName[i]) != -1) {
                        return true;
                    }
                }

                return response;
            },
            isSpecificHaveAccessMenu(role) {
                let response = false;
                if (
                    role.filter((e) => e == this.$store.state.profile.roleId).length > 0
                ) {
                    response = true;
                }

                return response;
            },
        },
    }

</script>
