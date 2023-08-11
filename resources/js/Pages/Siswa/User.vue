<template>
    <User title="Siswa">
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
        </div>
        <div class="row">
            <div class="col-md text-center">
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
                <div class="card mb-2">
                    <div class="card-body">
                        <div v-if="Object.keys(rows).length === 0" class="my-5">
                            <div class="text-center">
                                <div class="title h1">
                                    <i class="fas fa-fw fa-box-open"></i>
                                </div>
                                <div class="text-center">
                                    <h4>Data Tidak Tersedia !</h4>
                                    <p>Tambahkan data terlebih dahulu atau gunakan kata kunci lain untuk pencarian.</p>
                                </div>
                            </div>
                        </div>
                        <table v-else class="table table-head-bg-primary">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Ambil NIS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in rows.data" :key="row.id">
                                    <td>{{ row.nis }}</td>
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.tingkat.nama }} - {{ row.kelas.nama }}</td>
                                    <td>
                                        <inertia-link v-tooltip.top-center="'Kunjungan'" :href="route('kunjungan.create', { nis: row.nis })" type="button" class="btn btn-round btn-xs btn-success">
                                            <i class="fas fa-fw fa-walking"></i>
                                        </inertia-link>
                                        <inertia-link v-tooltip.top-center="'Peminjaman Mapel'" :href="route('peminjaman_mapel.create', { nis: row.nis })" type="button" class="btn btn-round btn-xs btn-warning">
                                            <i class="fas fa-fw fa-book"></i>
                                        </inertia-link>
                                        <inertia-link v-tooltip.top-center="'Peminjaman Umum'" :href="route('peminjaman.create', { nis: row.nis })" type="button" class="btn btn-round btn-xs btn-info">
                                            <i class="fas fa-fw fa-book"></i>
                                        </inertia-link>
                                        <inertia-link v-tooltip.top-center="'Pengembalian Mapel'" :href="route('peminjaman_mapel.return', { nis: row.nis })" type="button" class="btn btn-round btn-xs btn-danger">
                                            <i class="fas fa-fw fa-hand-holding-heart"></i>
                                        </inertia-link>
                                        <inertia-link v-tooltip.top-center="'Pengembalian Umum'" :href="route('peminjaman.return', { nis: row.nis })" type="button" class="btn btn-round btn-xs btn-secondary">
                                            <i class="fas fa-fw fa-hand-holding-heart"></i>
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
export default {
    components: { User },
    data () {
        return {
            rows: {},
            tingkat: [],
            kelas: [],
            siswa_id: '',
            filter: {
                keyword: '',
                tingkat_id: '',
                kelas_id: ','
            }
        }
    },
    mounted () {
        this.formData();
    },
    methods: {
        lists (page = 1) {
            let filter = this.filter;
            this.$awn.asyncBlock(
                axios.get(route('siswa.lists') + '?page=' + page + '&keyword=' + filter.keyword + '&tingkat_id=' + filter.tingkat_id + '&kelas_id=' + filter.kelas_id),
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
                axios.get(route('siswa.form')),
                response => {
                    this.tingkat = response.data.tingkat;
                    this.kelas = response.data.kelas;
                    this.siswa_count = response.data.siswa_count;
                    this.$awn.success('Form berhasil berhasil dimuat');
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
    }
}
</script>

<style lang="scss">
.tooltip {
  display: block !important;
  z-index: 10000;

  .tooltip-inner {
    background: black;
    color: white;
    border-radius: 16px;
    padding: 5px 10px 4px;
  }

  .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
    border-color: black;
    z-index: 1;
  }

  &[x-placement^="top"] {
    margin-bottom: 5px;

    .tooltip-arrow {
      border-width: 5px 5px 0 5px;
      border-left-color: transparent !important;
      border-right-color: transparent !important;
      border-bottom-color: transparent !important;
      bottom: -5px;
      left: calc(50% - 5px);
      margin-top: 0;
      margin-bottom: 0;
    }
  }

  &[x-placement^="bottom"] {
    margin-top: 5px;

    .tooltip-arrow {
      border-width: 0 5px 5px 5px;
      border-left-color: transparent !important;
      border-right-color: transparent !important;
      border-top-color: transparent !important;
      top: -5px;
      left: calc(50% - 5px);
      margin-top: 0;
      margin-bottom: 0;
    }
  }

  &[x-placement^="right"] {
    margin-left: 5px;

    .tooltip-arrow {
      border-width: 5px 5px 5px 0;
      border-left-color: transparent !important;
      border-top-color: transparent !important;
      border-bottom-color: transparent !important;
      left: -5px;
      top: calc(50% - 5px);
      margin-left: 0;
      margin-right: 0;
    }
  }

  &[x-placement^="left"] {
    margin-right: 5px;

    .tooltip-arrow {
      border-width: 5px 0 5px 5px;
      border-top-color: transparent !important;
      border-right-color: transparent !important;
      border-bottom-color: transparent !important;
      right: -5px;
      top: calc(50% - 5px);
      margin-left: 0;
      margin-right: 0;
    }
  }

  &[aria-hidden='true'] {
    visibility: hidden;
    opacity: 0;
    transition: opacity .15s, visibility .15s;
  }

  &[aria-hidden='false'] {
    visibility: visible;
    opacity: 1;
    transition: opacity .15s;
  }
}
</style>