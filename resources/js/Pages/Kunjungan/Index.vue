<template>
    <Admin title="Kunjungan">
        <div class="row d-flex align-items-center mb-3">
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
                <button v-on:click="[showModal(), cleanForm()]" class="btn btn-round btn-primary btn-sm">
                     <i class="fas fa-fw fa-plus"></i> Tambah Kunjungan
                </button>
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
                                            <input type="date" v-model="filter.start" :class="classInput(errors[0])">
                                            <small v-if="errors[0]" class="form-text text-danger text-muted">
                                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                            </small>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <input type="date" v-model="filter.end" :class="classInput(errors[0])">
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
                <div class="card">
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
                    <div v-else class="card-body">
                        <table class="table table-head-bg-primary">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in rows.data" :key="row.id">
                                    <td>{{ row.siswa.nis }}</td>
                                    <td>{{ row.siswa.nama }}</td>
                                    <td>{{ row.siswa.tingkat.nama }} - {{ row.siswa.kelas.nama }}</td>
                                    <td>{{ row.created_at | moment('D MMMM YYYY - H : m') }}</td>
                                    <td>
                                        <button v-on:click="destroy(row.id)" type="button" class="btn btn-round btn-xs btn-danger">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
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
        <!-- Modal -->
        <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="myModalTitle">
                                    <i class="fas fa-fw fa-walking"></i> Form Kunjungan
                                </h6>
                                <button v-on:click="hideModal()" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>NIS :</small>
                                        <input v-model="form.nis" type="text" :class="classInput(errors[0])">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-sm btn-secondary" v-on:click="hideModal()">
                                    <i class="fas fa-fw fa-times-circle"></i> Tutup
                                </button>
                                <button type="submit" class="btn btn-round btn-sm btn-primary">
                                    <i class="fas fa-fw fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </ValidationObserver>
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
            form: {
                nis: '',
            },
            filter: {
                start: '',
                end: '',
            },
            export_fields: {
                'Nomor': 'nomor',
                'NIS': 'nis',
                'Nama': 'nama',
                'Kelas': 'kelas',
                'Waktu': 'waktu',
            },
            loading: false,
        }
    },
    methods: {
        lists (page = 1) {
            let filter = this.filter;
            if (filter.start > filter.end) {
                this.$awn.info('Format tanggal tidak benar');
                return;
            }
            this.$awn.asyncBlock(
                axios.get(route('kunjungan.lists') + '?page=' + page + '&start=' + filter.start + '&end=' + filter.end),
                response => {
                    if (response.data.data.length == 0) {
                        this.rows = {};
                        this.$awn.warning('Tidak ada datang yang dimuat');
                    } else {
                        this.rows = response.data;
                        this.$awn.success(response.data.data.length + ' kunjungan berhasil dimuat');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        save () {
            this.$awn.asyncBlock(
                axios.post(route('kunjungan.store'), this.form),
                    response => {
                        if (response.data.status == 'tidak terdaftar') {
                            this.$awn.info('Siswa dengan NIS ' + this.form.nis + ' tidak terdaftar');
                        } else {
                            this.cleanForm();
                            this.hideModal();
                            if ((this.filter.start) && (this.filter.end)) {
                                this.lists();
                            }
                            this.$awn.success('Kunjungan berhasil ditambahkan');
                        }
                    },
                    error => {
                        this.cleanForm();
                        this.hideModal();
                        this.$awn.alert(error.message);
                    }
                );
        },
        destroy (id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.get(route('kunjungan.destroy', { kunjungan: id })),
                    () => {
                        this.lists();
                        this.$awn.success('kunjungan berhasil dihapus');
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
                'Kunjungan akan dihapus secara permanen',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        async exportData () {
            const response = await axios.get(route('kunjungan.export'));
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
        cleanForm () {
            this.form.nis = '';
            this.$refs.form.reset();
        },
        classInput(error) {
            if (error) {
                return 'form-control is-invalid';
            } else {
                return 'form-control';
            }
        },
        showModal () {
            $('#myModal').modal('show');
        },
        hideModal () {
            $('#myModal').modal('hide');
        },
    }
}
</script>