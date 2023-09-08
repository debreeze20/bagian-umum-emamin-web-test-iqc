import {
    createRouter,
    createWebHistory
} from "vue-router";

import Api from "@/services/api";

import Login from "@/views/Login.vue";

import TambahPengajuan from "@/views/data-industri/FormPengajuan.vue"
import EditPengajuan from "@/views/data-industri/FormPengajuan.vue"
import TambahUmkm from "@/views/umkm/TambahUmkm.vue"
import EditUmkm from "@/views/umkm/EditUmkm.vue"
import DataIndustri from "@/views/data-industri/Index.vue";
import Dashboard from "@/views/Dashboard.vue";
import HistoryPesanan from "@/views/data-industri/HistoryPesanan.vue"
import mainStore from "@/store/index.js";
import DataUmkm from "@/views/umkm/Index.vue"
import DataProduk from "@/views/data-produk/Index.vue"
import Sector from "@/views/sector/Index.vue";
import SectorPerusahaan from "@/views/sector/perusahaan/Index.vue";
import SectorPerusahaanPortofolio from "@/views/sector/perusahaan/portofolio/Index.vue";
import Export from "@/views/export/Index.vue"
import RekapUmkm from "@/views/export/RekapUmkm.vue"
import NotFound from "@/views/errors/404.vue";
import ForbiddenAccess from "@/views/errors/403.vue";

const routes = [
    {
        path: '/sector/:id',
        component: Sector,
    },
    {
        path: '/sector/perusahaan/:id',
        component: SectorPerusahaan,
    },
    {
        path: '/sector/perusahaan/portofolio/:id',
        component: SectorPerusahaanPortofolio
    },
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            guest: true,
            title: 'Login - BAGIAN UMUM - E-MAMIN'
        }
    },
    {
        path: "/",
        name: "dashboard",
        component: Dashboard,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path: "/pengajuan",
        name: "data-pengajuan",
        component: DataIndustri,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path: "/export",
        name: "export",
        component: Export,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path: "/rekap-umkm",
        name: "rekap-umkm",
        component: RekapUmkm,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path: "/umkm",
        name: "data-umkm",
        component: DataUmkm,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path: "/data-produk",
        name: "data-produk",
        component: DataProduk,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'BAGIAN UMUM E-MAMIN'
        }
    },
    {
        path:"/tambah-pengajuan",
        name:"tambah-pengajuan",
        component: TambahPengajuan,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'Tambah Pengajuan - E-Mamin'
        }
    },
    {
        path:"/edit-pengajuan/:id",
        name:"edit-pengajuan",
        component: EditPengajuan,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'Tambah Pengajuan - E-Mamin'
        }
    },
    {
        path:"/umkm/tambah-umkm",
        name:"tambah-umkm",
        component: TambahUmkm,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'Tambah UMKM - E-Mamin'
        }

    },
    {
        path:"/umkm/edit-umkm/:id",
        name:"edit-umkm",
        component: EditUmkm,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'Edit UMKM - E-Mamin'
        }

    },
    {
        path: "/umkm/:id/history-pesanan",
        name: "history-pesanan",
        component: HistoryPesanan,
        meta: {
            auth: true,
            // access: [import.meta.env.VITE_ROLE_ADMIN,import.meta.env.VITE_ROLE_DEVELOPER],
            title: 'History - E-MAMIN'
        }
    },






    {
        path: "/404",
        component: NotFound,
      },
    //   {
    //     path: "/403",
    //     component: ForbiddenAccess,
    //     meta: {
    //       auth: true,
    //     },
    //   },
      {
        path: "/:pathMatch(.*)*",
        redirect: "/404",
      },
]

const router = createRouter({
    history: createWebHistory(SUBFOLDER_DOMAIN),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return {
            top: 0,
        };
    },
});
router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.auth)) {
        if (!localStorage.getItem("token")) {
            return next("/login");
        }  else {
            return Api().get(`api/auth/me`)
            .then(function (response) {
                mainStore.commit("profile/SET_PROFILE_DATA", response.data.data);

                return next();
            })
            .catch(function (e) {
                mainStore.commit("profile/SET_PROFILE_DATA", null);
                localStorage.clear();
                return next("/login");
            });
        }
    } else if (to.matched.some((record) => record.meta.guest)) {
        if (!localStorage.getItem("token")) {
            return next();
        } else {
            return next("/");
        }
    } else {
        return next();
    }
});
// router.beforeEach((to, from, next) => {
//     if (to.matched.some((record) => record.meta.title)) {
//         if (to.meta && to.meta.title) {
//             document.title = to.meta.title;
//         }
//     }

//     if (to.matched.some((record) => record.meta.auth)) {
//         if (!localStorage.getItem("token")) {
//             return next("/login");
//         } else {
//             if (mainStore.state.profile.isLoggedIn) {
//                 if (to.matched.some((record) => record.meta.access)) {
//                     if (to.meta && to.meta.access && to.meta.access.length > 0) {
//                         const hasAccess = to.meta.access.filter((e) => e == mainStore.state.profile.roleId
//                         );
//                         if (hasAccess.length == 0) {
//                             return next("/403");
//                         }
//                     }
//                 }
//                 return next();
//             } else {
//                 return Api().get(`api/auth/me`)
//                     .then(function (response) {
//                         mainStore.commit("profile/SET_PROFILE_DATA", response.data.data);
//                         // console.log(response.data.data.role.id);
//                         if (to.matched.some((record) => record.meta.access)) {
//                             if (to.meta && to.meta.access && to.meta.access.length > 0) {
//                                 const hasAccess = to.meta.access.filter((e) => e == response.data.data.role.id);
//                                 if (hasAccess.length == 0) {
//                                     return next("/403");
//                                 }
//                             }
//                         }

//                         return next();
//                     })
//                     .catch(function (e) {
//                         mainStore.commit("profile/SET_PROFILE_DATA", null);
//                         localStorage.clear();
//                         return next("/login");
//                     });
//             }
//         }
//     } else if (to.matched.some((record) => record.meta.guest)) {
//         if (!localStorage.getItem("token")) {
//             return next();
//         } else {
//             return next("/");
//         }
//     } else {
//         return next();
//     }
// });

export default router;
