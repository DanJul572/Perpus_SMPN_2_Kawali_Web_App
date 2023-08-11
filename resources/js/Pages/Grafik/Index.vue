<template>
    <Admin title="Grafik">
        <div class="row justify-contents-center">
            <div class="col">
                <div class="card">
                    <div class="card-body p-0">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                            <form method="post" v-on:submit.prevent="handleSubmit(lists)">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <input v-model="filter.mulai_tanggal" type="date" :class="classInput(errors[0])">
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <input v-model="filter.sampai_tanggal" type="date" :class="classInput(errors[0])">
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <select v-model="filter.tipe" :class="classInput(errors[0])">
                                                    <option value="minggu">Per Minggu</option>
                                                    <option value="bulan">Per Bulan</option>
                                                    <option value="tahun">Per Tahun</option>
                                                </select>
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-rounded btn-primary btn-block">
                                                <i class="fas fa-fw fa-filter"></i> Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        Peminjaman Umum
                    </div>
                    <div class="card-body text-center">
                        <peminjaman-umum v-if="data_peminjaman_umum.waktu.length > 0" :data="data_peminjaman_umum"></peminjaman-umum>
                        <p v-else><i class="fas fa-fw fa-box-open"></i> Data tidak tersedia</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        Peminjaman Mapel
                    </div>
                    <div class="card-body text-center">
                        <peminjaman-mapel v-if="data_peminjaman_mapel.waktu.length > 0" :data="data_peminjaman_mapel"></peminjaman-mapel>
                        <p v-else><i class="fas fa-fw fa-box-open"></i> Data tidak tersedia</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        Kunjungan
                    </div>
                    <div class="card-body text-center">
                        <kunjungan v-if="data_kunjungan.waktu.length > 0" :data="data_kunjungan"></kunjungan>
                        <p v-else><i class="fas fa-fw fa-box-open"></i> Data tidak tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from '../../Shared/Admin.vue';
import PeminjamanUmum from './PeminjamanUmum.vue';
import PeminjamanMapel from './PeminjamanMapel.vue';
import Kunjungan from './Kunjungan.vue';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
export default {
    components: { Admin, PeminjamanUmum, PeminjamanMapel, Kunjungan },
    data () {
        return {
            data_peminjaman_umum: {
                waktu: [],
                count: []
            },
            data_peminjaman_mapel: {
                waktu: [],
                count: []
            },
            data_kunjungan: {
                waktu: [],
                count: []
            },
            filter: {
                mulai_tanggal: '',
                sampai_tanggal: '',
                tipe: '',
            }
        }
    },
    mounted () {
        
    },
    methods: {
        lists () {
            let filter = this.filter;
            this.data_peminjaman_umum.waktu = [];
            this.data_peminjaman_umum.count = [];
            this.data_peminjaman_mapel.waktu = [];
            this.data_peminjaman_mapel.count = [];
            this.data_kunjungan.waktu = [];
            this.data_kunjungan.count = [];
            if (filter.mulai_tanggal > filter.sampai_tanggal) {
                this.$awn.warning('Format tanggal tidak benar');
            } else {
                this.$awn.asyncBlock(
                    axios.get(route('grafik.lists') + '?mulai_tanggal=' + filter.mulai_tanggal + '&sampai_tanggal=' + filter.sampai_tanggal + '&tipe=' + filter.tipe),
                    response => {
                        this.data_peminjaman_umum = response.data.peminjaman_umum;
                        this.data_peminjaman_mapel = response.data.peminjaman_mapel;
                        this.data_kunjungan = response.data.kunjungan;
                        this.$awn.success('Data berhasil dimuat');
                    },
                    error => {
                        this.$awn.alert(error.message);
                    }
                );
            }
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
    }
}
</script>
