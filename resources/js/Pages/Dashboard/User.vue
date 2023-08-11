<template>
    <User title="Create">
        <div class="row mt-5 justify-content-center">
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
    </User>
</template>

<script>
import User from '../../Shared/User.vue';
export default {
    components: { User },
}
</script>
