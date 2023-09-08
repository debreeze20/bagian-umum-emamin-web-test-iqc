import moment from 'moment'
import isHtml from 'is-html';

export default {
    install(app, options) {
        app.config.globalProperties.$formatBytes = (bytes, decimals = 2) => {
                if (!+bytes) return '0 Bytes'

                const k = 1024
                const dm = decimals < 0 ? 0 : decimals
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

                const i = Math.floor(Math.log(bytes) / Math.log(k))

                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
            },
            app.config.globalProperties.$moment = moment,
            app.config.globalProperties.$validatorForbiddenHtml = value => {
                if(!value){
                    return {
                        $valid: true
                    }
                }
                if (!isHtml(value)) return {
                    $valid: true
                }
                return {
                    $valid: false,
                    message: 'Tidak boleh mengandung text HTML,CSS,Javascript',                    
                }
            },
            app.config.globalProperties.$assetUrl = () => {
                return assetUrl;
            },
            app.config.globalProperties.$noNullable = (text) => {
                if (text) {
                    return text;
                }
                return '-';
            },
            app.config.globalProperties.$rupiahFormat = (text) => {
                if (!text) {
                    return '0';
                }
                return new Intl.NumberFormat("id-ID", {
                    maximumFractionDigits: 0
                }).format(text);
            },
            app.config.globalProperties.$axiosHandleError = (error, callback = null) => {
                const provide = app._context.provides;
                let res = error.response ? error.response.data : null;
                let code = error.response ? error.response.status : null;

                if (code == 400) {
                    provide
                        .$swal({
                            title: "Oopss...",
                            icon: "error",
                            text: res?.meta?.message,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ok",
                        })
                        .then((result) => {
                            if (callback) {
                                callback;
                            }
                        });
                } else if (code == 403) {
                    provide
                        .$swal({
                            title: "Oopss...",
                            icon: "error",
                            text: res?.meta?.message,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ok",
                        })
                        .then((result) => {
                            if (callback) {
                                callback;
                            }
                        });
                } else if (code == 401) {
                    localStorage.clear();
                    window.location.replace(baseUrl + "/login");
                } else if (code == 422) {
                    console.log(res);
                    let resOther = "";
                    if (res?.data?.errors) {
                        const entries = Object.entries(res?.data?.errors || {});

                        for (const [name, errMsg] of entries) {
                            resOther += `<br>. ${errMsg}`;
                        }
                    } else {
                        const entries = Object.entries(res?.data || {});

                        for (const [name, errMsg] of entries) {
                            resOther += `<br>. ${errMsg}`;
                        }
                    }

                    provide
                        .$swal({
                            title: "Oopss...",
                            icon: "error",
                            html: res?.meta?.message +
                                `<br><div class="text-left text-muted p-2">` +
                                resOther +
                                `</div>`,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ok",
                        })
                        .then((result) => {
                            if (callback) {
                                callback;
                            }
                        });
                } else if (code == 404) {
                    provide
                        .$swal({
                            title: "Oopss...",
                            icon: "error",
                            text: "Request/Resource not found!",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ok",
                        })
                        .then((result) => {
                            if (callback) {
                                callback;
                            }
                        });
                } else {
                    provide
                        .$swal({
                            title: "Oopss...",
                            icon: "error",
                            text: "Terjadi kesalahan koneksi",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Ok",
                        })
                        .then((result) => {
                            if (callback) {
                                callback;
                            }
                        });
                }


            },
            app.config.globalProperties.$loaderShow = () => {
                let loadingClass = 'ewp-loading'
                let loadingDiv = document.createElement('div')
                loadingDiv.className = loadingClass
                $('body').append(loadingDiv)
            },
            app.config.globalProperties.$loaderHide = (error) => {
                let loadingClass = 'ewp-loading'
                $('.' + loadingClass).hide()
            },
            app.config.globalProperties.$initializeAppPlugins = (error) => {
                window.$(".drawer-overlay").remove();
                setTimeout(() => {
                    KTDialer.init();
                    KTDrawer.init();
                    KTImageInput.init();
                    KTMenu.createInstances()
                    KTPasswordMeter.init();
                    KTScroll.init();
                    KTScrolltop.init();
                    KTSticky.init();
                    KTSwapper.init();
                    KTToggle.init();
                    KTUtil.onDOMContentLoaded((function () {
                        KTApp.init()
                    })), window.addEventListener("load", (function () {
                        KTApp.initPageLoader()
                    })), "undefined" != typeof module && void 0 !== module.exports && (module.exports = KTApp);

                    KTUtil.onDOMContentLoaded((function () {
                        KTLayoutAside.init()
                    }));


                    KTUtil.onDOMContentLoaded((function () {
                        KTLayoutSearch.init()
                    }));

                    KTUtil.onDOMContentLoaded((function () {
                        KTLayoutToolbar.init()
                    }));

                }, 100);

                setTimeout(() => {
                    $('body').attr('data-kt-drawer-aside', 'off');
                    $('body').attr('data-kt-drawer', 'off');
                    $('body').attr('data-kt-aside-minimize', 'off');

                    $(".drawer-overlay").remove();
                }, 10);


                window.$("#kt_aside_mobile_toggle").on('click', function () {
                    setTimeout(() => {


                        $('.drawer-overlay').each(function () {
                            let checkLength = $(".drawer-overlay").length;

                            if (checkLength > 1) {
                                $(this).remove();
                            }

                        });
                    }, 10);
                });
            },
            app.config.globalProperties.$apiType = (type) => {
                if (type == "global") {
                    return "api/";
                } else {
                    return "api-web/";
                }
            }
    }
};
