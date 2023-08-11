<template>
    <Admin title="PeminjamanMapel">
        <div class="row mb-3">
            <div class="col-md">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman.*') ? 'active' : ''" :href="route('peminjaman.index')">Umum</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman_mapel.*') ? 'active' : ''" :href="route('peminjaman_mapel.index')">Mapel</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row d-flex align-items-center mb-3">
            <div class="col-3">
                <div class="nav-search">
                    <div class="input-group bg-white">
                        <input v-model="filter.keyword" type="text" placeholder="Cari..." class="form-control">
                        <div v-on:click="lists()" class="pointer input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-fw fa-search"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col text-right">
                <download-excel class="btn btn-sm btn-rounded btn-success" :fetch="exportData" :fields="export_fields" :before-generate="startDownload" :before-finish="finishDownload">
                    <div class="d-flex">
                        <div class="d-block mr-1">
                            <i class="fas fa-fw fa-file-export"></i> Export Data
                        </div>
                        <div class="d-block">
                            <vue-loading v-if="loading == true" type="spiningDubbles" color="#FFFFFF" :size="{ width: '13px', height: '13px' }"></vue-loading>
                        </div>
                    </div>
                </download-excel>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card mb-2">
                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                            <form method="post" v-on:submit.prevent="handleSubmit(lists)">
                                <div class="row">
                                    <div class="col">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <v-select v-model="filter.tingkat_id" label="nama" :options="tingkat" :reduce="tingkat => tingkat.id"></v-select>
                                            <small v-if="errors[0]" class="form-text text-danger text-muted">
                                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                            </small>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <v-select v-model="filter.kelas_id" label="nama" :options="kelas" :reduce="kelas => kelas.id"></v-select>
                                            <small v-if="errors[0]" class="form-text text-danger text-muted">
                                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                            </small>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-2">
                                        <button type="sumbit" class="btn btn-round btn-primary btn-sm btn-block">
                                            <i class="fas fa-fw fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card" v-if="Object.keys(rows).length === 0">
                    <div class="card-body">
                        <div class="text-center my-5">
                            <div class="title h1">
                                <i class="fas fa-fw fa-box-open"></i>
                            </div>
                            <div class="text-center">
                                <h4>Data Tidak Tersedia !</h4>
                                <p>Tambahkan data terlebih dahulu atau gunakan kata kunci lain untuk pencarian.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="card">
                    <div class="card-header">
                        <div class="badge badge-danger badge-pill">Terlambat</div>
                        <div class="badge badge-warning badge-pill">Hari Ini</div>
                        <div class="badge badge-success badge-pill">Selesai</div> 
                        <div class="badge badge-info badge-pill">Total Peminjaman</div> 
                    </div>
                    <div class="card-body">
                        <table class="table table-head-bg-primary">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Peminjaman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in rows.data" :key="row.id">
                                    <td>{{ row.nis }}</td>
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.tingkat.nama }} {{ row.kelas.nama }}</td>
                                    <td>
                                        <div v-if="row.terlambat > 0" class="badge badge-danger badge-pill">{{ row.terlambat }}</div>
                                        <div v-if="row.hari_ini > 0" class="badge badge-warning badge-pill">{{ row.hari_ini }}</div>
                                        <div v-if="row.selesai > 0" class="badge badge-success badge-pill">{{ row.selesai }}</div>
                                        <span v-if="(row.total == 0)">
                                            -
                                        </span>
                                        <div v-else class="badge badge-info badge-pill">
                                            {{ row.total }}
                                        </div>
                                    </td>
                                    <td>
                                        <inertia-link :href="route('peminjaman_mapel.show', { siswa: row.id })" class="btn btn-round btn-xs btn-info">
                                            <i class="fas fa-fw fa-info"></i>
                                        </inertia-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="Object.keys(rows).length > 0" class="card-footer ">
                        <pagination align="right" :data="rows" v-on:pagination-change-page="lists"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from '../../Shared/Admin.vue';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
export default {
    components: { Admin },
    data () {
        return {
            rows: {},
            tingkat: [],
            kelas: [],
            filter: {
                keyword: '',
                tingkat_id: '',
                kelas_id: ','
            },
            export_fields: {
                'Nomor': 'nomor',
                'NIS': 'nis',
                'Nama': 'nama',
                'Kelas': 'kelas',
                'Nama Mapel': 'nama_mapel',
                'Klasifikasi': 'klasifikasi',
                'Tenggat': 'tenggat',
                'Status': 'status',
            },
            loading: false,
        }
    },
    mounted () {
        this.formData();
    },
    methods: {
        lists (page = 1) {
            let filter = this.filter;
            this.$awn.asyncBlock(
                axios.get(route('peminjaman_mapel.lists') + '?page=' + page + '&keyword=' + filter.keyword + '&tingkat_id=' + filter.tingkat_id + '&kelas_id=' + filter.kelas_id),
                response => {
                    if (response.data.data.length == 0) {
                        this.rows = {};
                        this.$awn.warning('Tidak ada datang yang dimuat');
                    } else {
                        this.rows = response.data;
                        this.$awn.success(response.data.data.length + ' siswa berhasil dimuat');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        formData () {
            this.$awn.asyncBlock(
                axios.get(route('peminjaman_mapel.form')),
                response => {
                    this.tingkat = response.data.tingkat;
                    this.kelas = response.data.kelas;
                    this.$awn.success('Form berhasil berhasil dimuat');
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        async exportData () {
            const response = await axios.get(route('peminjaman_mapel.export'));
            if (response.data.length == 0) {
                this.$awn.warning('Tidak ada datang yang dimuat');
                this.finishDownload();
            } else {
                return response.data;
            }
        },
        startDownload () {
            this.loading = true;
        },
        finishDownload () {
            this.loading = false;
        },
    }
}
</script>