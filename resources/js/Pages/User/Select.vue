<template>
    <Blank title="Select">
        <div class="row justify-content-center">
            <div class="col-md text-center">
                <img :src="asset('app/main/image/logo/logo.png')">
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-6 text-center">
                <h5>SELAMAT DATANG DI PERPUSTAKAAN IQRA SMP NEGERI 2 KAWALI</h5>
                <p>Dunia ini bagaikan sebuah buku yang bagus sekali, tetapi tidak ada gunanya bagi mereka yang tidak tahu membacanya</p>
                <h6>MARI BIASAKAN MEMBACA</h6>
                <h6>SALAM LITERASI</h6>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">
                        <small class="card-title">Siswa</small>
                    </div>
                    <div class="card-body p-5">
                        <i class="fas fa-user-graduate icon"></i>
                    </div>
                    <div class="card-footer">
                        <inertia-link :href="route('siswa.user')" class="btn btn-primary btn-sm">Selengkapnya</inertia-link>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">
                        <small class="card-title">Kunjungan</small>
                    </div>
                    <div class="card-body p-5">
                        <i class="fas fa-walking icon"></i>
                    </div>
                    <div class="card-footer">
                        <inertia-link :href="route('kunjungan.create')" class="btn btn-primary btn-sm">Selengkapnya</inertia-link>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">
                        <small class="card-title">Peminjaman Mapel</small>
                    </div>
                    <div class="card-body p-5">
                        <i class="fas fa-book icon"></i>
                    </div>
                    <div class="card-footer">
                         <inertia-link :href="route('peminjaman_mapel.create')" class="btn btn-primary btn-sm">Selengkapnya</inertia-link>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">
                        <small class="card-title">Peminjaman Umum</small>
                    </div>
                    <div class="card-body p-5">
                        <i class="fas fa-book-reader icon"></i>
                    </div>
                    <div class="card-footer">
                         <inertia-link :href="route('peminjaman.create')" class="btn btn-primary btn-sm">Selengkapnya</inertia-link>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a :href="route('welcome')" class="btn btn-link">Kembali</a>
            </div>
        </div>
    </Blank>
</template>

<script>
import Blank from '../../Shared/Blank.vue';
export default {
    components: { Blank },
    data () {
        return {

        }
    },
}
</script>

<style>
    .icon {
        font-size: 100px;
    }
</style>