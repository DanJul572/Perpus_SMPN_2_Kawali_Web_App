<template>
    <User title="Create">
        <div class="row mb-3">
            <div class="col-md">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman.*') ? 'active' : ''" :href="route('peminjaman.return')">Umum</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman_mapel.*') ? 'active' : ''" :href="route('peminjaman_mapel.return')">Mapel</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ValidationObserver v-slot="{ handleSubmit }" ref="search_form">
                                    <form method="post" v-on:submit.prevent="handleSubmit(peminjaman)">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <div class="input-group">
                                                <input v-model="form.nis" type="text" placeholder="Masukan NIS Siswa" :class="classInput(errors[0])">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-fw fa-search"></i></button>
                                                </div>
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </div>
                                        </ValidationProvider>
                                    </form>
                                </ValidationObserver>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div v-if="mapel.length === 0" class="my-5">
                                    <div class="text-center">
                                        <div class="title h1">
                                            <i class="fas fa-fw fa-box-open"></i>
                                        </div>
                                        <div class="text-center">
                                            <h4>Data Tidak Tersedia !</h4>
                                            <p>Gunakan kata kunci lain untuk pencarian.</p>
                                        </div>
                                    </div>
                                </div>
                                <table v-else class="table table-head-bg-primary mt-3">
                                    <thead>
                                        <tr>
                                            <th>Klasifikasi</th>
                                            <th>Nama</th>
                                            <th>Rak</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in mapel" :key="row.id">
                                            <td>{{ row.klasifikasi }}</td>
                                            <td>{{ row.nama }}</td>
                                            <td>{{ row.rak }}</td>
                                            <td>{{ row.kategori.nama }}</td>
                                            <td>
                                                <button v-on:click="returned(row.id)" type="button" class="btn btn-round btn-xs btn-success">
                                                    <i class="fas fa-fw fa-check"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </User>
</template>

<script>
import User from '../../Shared/User.vue';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
extend('integer', value => {
    if (/^\d+$/.test(value)) {
        return true;
    } else {
        return 'Field ini harus berupa angka';
    }
});
export default {
    components: { User },
    props: ['nis'],
    data () {
        return {
            form: {
                nis: '',
            },
            mapel: [],
            siswa: {}
        }
    },
    mounted () {
        if (this.nis) {
            this.form.nis = this.nis;
        }
    },
    methods: {
        returned (peminjaman_id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.post(route('peminjaman_mapel.returned', { siswa: this.siswa.id }), { peminjaman_id: peminjaman_id }),
                    () => {
                        let index = this.mapel.findIndex(x => x.id == peminjaman_id);
                        this.mapel.splice(index, 1);
                        this.$awn.success('Peminajaman berhasil dikembalikan');
                    },
                    error => {
                        this.$awn.alert(error.message);
                    }
                )
            }
            let onCancle = () => {
                return;
            }
            this.$awn.confirm(
                'Peminjaman akan dikembalikan',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        peminjaman () {
            this.mapel = [];
            this.$awn.asyncBlock(
                axios.get(route('siswa.mapel', { nis: this.form.nis })),
                response => {
                    if (response.data.status == 'tidak ada') {
                        this.$awn.warning('Siswa dengan NIS "' + this.form.nis + '" tidak ditemukan');
                    } else if (response.data.mapel.length == 0) {
                        this.$awn.warning('Data peminjaman tidak ditemukan');
                    } else {
                        this.siswa = response.data.siswa;
                        this.mapel = response.data.mapel;
                        this.$awn.success(response.data.mapel.length + ' peminjaman berhasil dimuat');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
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
