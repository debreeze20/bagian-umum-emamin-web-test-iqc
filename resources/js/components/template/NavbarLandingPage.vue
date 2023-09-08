<template>
    <nav class="navbar navbar-expand-lg navbar-custom-landing navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" :href="urlLandingPage">
                <img :src="`${$assetUrl()}extends/images/logo-1-white-high.png`" style="width:180px" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse nav-group-landing navbar-collapse align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" :href="urlLandingPage">BERANDA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :href="urlLandingPage + '#row-about'">TENTANG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :href="urlLandingPage + '#row-subsektor'">SEKTOR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" :href="urlLandingPage">KONTAK</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-sm text-white" @click="$router.push({path: '/register'})" style="background:#7239EA">GABUNG</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default {
        data(){
            return {
                urlLandingPage: ''
            }
            
        },
        mounted(){
            this.urlLandingPage =
                import.meta.env.VITE_LANDINGPAGE_URL
        }
    }

</script>
<style scoped>
    .navbar-custom-landing {
        position: absolute;
        top: 0;
        width: 100%;
        background: transparent !important;
        padding: 15px;

    }
    .navbar-custom-landing .nav-group-landing .nav-item .nav-link{
        padding:0 20px;
        font-weight: 600;
        color:#fff
    }

    @media(max-width:991px){
        .navbar-custom-landing{
            background-color: black !important;
            position: static;
        }
        .navbar-custom-landing .nav-group-landing .nav-item .nav-link{
            padding: 15px 0 !important;
        }
       
        .nav-group-landing.show{
            background-color: black;
            margin-top: 15px;
        }
        .navbar-custom-landing .navbar-toggler{
            outline: none !important;
            border: 0 !important;
            box-shadow: unset !important;
            color:#fff !important
        }
        .navbar-custom-landing .navbar-toggler i{
            color:#fff !important;
            font-size:25px;
        }
        .navbar-custom-landing .navbar-nav{
            align-items: flex-start !important;
        }
    }

</style>
