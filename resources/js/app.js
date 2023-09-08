import './bootstrap';

import {
    createApp
} from "vue/dist/vue.esm-bundler.js";

import MainApp from "./components/App.vue";

import VueDatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';

import NavbarLandingPage from "@/components/template/NavbarLandingPage.vue";

import Navbar from "@/components/template/Navbar.vue";
import Sidebar from "@/components/template/Sidebar.vue";
import ScrollTop from "@/components/template/ScrollTop.vue";
import Tabs from "@/components/template/Tabs.vue"


import routes from "./router";

import globalPlugin from "@/plugins/global.js";

import SelectSingle from "@/components/ui/SelectSingle.vue";
import SelectMultiple from "@/components/ui/SelectMultiple.vue";
import Datatable from "@/components/ui/Datatable.vue";
import Pagination from "@/components/template/Pagination.vue";
import Loader from "@/components/ui/Loader.vue";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

import Editor from '@tinymce/tinymce-vue'

import VueApexCharts from "vue3-apexcharts";

import Toaster from "@meforma/vue-toaster";

import {
    Money3Component
} from 'v-money3'

import mainStore from "@/store/index.js";

const app = createApp({
    MainApp
});

app.component('app-editor', Editor)

app.component("main-app", MainApp);
app.component('app-pagination', Pagination);

app.component('app-navbar', Navbar);
app.component('app-navbar-landing-page', NavbarLandingPage);
app.component('app-loader', Loader);
app.component('app-sidebar', Sidebar);
app.component('app-tabs', Tabs);
app.component('app-scroll-top', ScrollTop);

app.component('app-select-single', SelectSingle);
app.component('app-select-multiple', SelectMultiple);

app.component("app-datatable", Datatable);

app.component('app-money', Money3Component);

app.component('app-datepicker', VueDatePicker);

app.use(routes);

app.use(VueApexCharts);

app.use(VueSweetalert2);

app.use(globalPlugin);

app.use(Toaster, {
    position: "top-right",
    dismissible: true,
    duration: 3000,
});

app.use(mainStore);

app.mount("#app");
