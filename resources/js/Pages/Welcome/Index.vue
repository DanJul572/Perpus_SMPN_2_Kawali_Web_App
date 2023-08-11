<template>
    <Landing title="Welcome">
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" :href="route('admin.auth')">Masuk</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end">
                        <h1 class="text-uppercase text-white font-weight-bold">Sistem Informasi Perpustakaan Iqra</h1>
                        <h1 class="text-uppercase text-white font-weight-bold">SMP Negeri 2 Kawali</h1>
                        <hr class="divider my-4" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 font-weight-light mb-5">Buat pengolahan data perpustakaan lebih mudah dan cepat dengan aplikasi berteknologi modern!</p>
                        <a class="btn btn-primary btn-xl js-scroll-trigger" :href="route('dashboard.user')">Mulai Sekarang</a>
                    </div>
                </div>
            </div>
        </header>
    </Landing>
</template>

<script>
import Landing from "../../Shared/Landing.vue"
export default {
    components: { Landing },
    data () {
        return {

        }
    },
}
</script>