<template>
    <Admin title="Siswa">
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
                <download-excel
                v-if="failed_import.length > 0"
                class="btn btn-danger btn-rounded btn-sm"
                :data="failed_import"
                :fields="import_fields"
                worksheet="My Worksheet"
                name="failed_import.xls">
                    <i class="fas fa-fw fa-exclamation-triangle"></i> Gagal Ditambahkan
                </download-excel>
                <button v-on:click="showModal('import')" class="btn btn-round btn-primary btn-sm">
                    <i class="fas fa-fw fa-file-import"></i> Import Data
                </button>
                <button v-on:click="[showModal('save'), cleanForm(), update_status = false]" class="btn btn-round btn-primary btn-sm">
                    <i class="fas fa-fw fa-plus"></i> Tambah Siswa
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
                <div v-if="Object.keys(rows).length === 0" class="card">
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
                    <div class="card-header d-flex">
                        <h4 class="card-title mr-1">{{ siswa_count }}</h4>
                        <p class="card-category">Siswa</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-head-bg-primary">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in rows.data" :key="row.id">
                                    <td>{{ row.nis }}</td>
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.tingkat.nama }} - {{ row.kelas.nama }}</td>
                                    <td>{{ row.password }}</td>
                                    <td>
                                        <button v-on:click="edit(row.id)" type="button" class="btn btn-round btn-xs btn-success">
                                            <i class="fas fa-fw fa-pen"></i>
                                        </button>
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
        <!-- Save Modal -->
        <div class="modal fade" id="saveModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="saveModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="saveModalTitle">
                                    <i class="fas fa-fw fa-user-graduate"></i> Form Siswa
                                </h6>
                                <button v-on:click="hideModal('save')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>NIS :</small>
                                        <input v-model="form.nis" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Nama :</small>
                                        <input v-model="form.nama" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Tingkat :</small>
                                        <v-select v-model="form.tingkat_id" label="nama" :options="tingkat" :reduce="tingkat => tingkat.id"></v-select>
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Kelas :</small>
                                        <v-select v-model="form.kelas_id" label="nama" :options="kelas" :reduce="kelas => kelas.id"></v-select>
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Password :</small>
                                        <input v-model="form.password" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-sm btn-secondary" v-on:click="hideModal('save')">
                                    <i class="fas fa-fw fa-times-circle"></i> Tutup
                                </button>
                                <button type="submit" class="btn btn-round btn-sm btn-primary">
                                    <i class="fas fa-fw fa-save"></i> Simpan
                                </button>
                                <button type="button" class="btn btn-round btn-sm btn-primary" v-on:click="generatePassword()">
                                    <i class="fas fa-fw fa-key"></i> Generate Password
                                </button>
                            </div>
                        </form>
                    </ValidationObserver>
                </div>
            </div>
        </div>
        <!-- Excel Modal -->
        <div class="modal fade" id="importModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="importModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                        <form method="post" v-on:submit.prevent="importExcel">
                            <div class="modal-header">
                                <h6 class="modal-title" id="importModalTitle">
                                    <i class="fas fa-fw fa-user-graduate"></i> Import Siswa
                                </h6>
                                <button v-on:click="hideModal('import')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <small>Format :</small>
                                    <span class="text-bold d-block">| Nomor | NIS | Nama | Password | Tingkat | Kelas |</span>
                                </div>
                                <div class="form-group">
                                    <small>File Excel :</small>
                                    <input v-on:change="readExcel" type="file" class="form-control" id="import">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-sm btn-secondary" v-on:click="hideModal('import')">
                                    <i class="fas fa-fw fa-times-circle"></i> Tutup
                                </button>
                                <button type="submit" class="btn btn-round btn-sm btn-primary">
                                    <i class="fas fa-fw fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from '../../Shared/Admin.vue';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
import readXlsxFile from 'read-excel-file';
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
            siswa_count: '',
            update_status: false,
            form: {
                nis: '',
                nama: '',
                tingkat_id: '',
                kelas_id: '',
                password: '',
            },
            siswa_id: '',
            filter: {
                keyword: '',
                tingkat_id: '',
                kelas_id: ','
            },
            import: [],
            failed_import: [],
            import_fields: {
                NIS: 'nis',
                Nama: 'nama',
                Password: 'password',
                Tingkat: 'tingkat',
                Kelas: 'kelas',
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
        save () {
            if (this.update_status == false) {
                this.$awn.asyncBlock(
                    axios.post(route('siswa.store'), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Siswa dengan NIS ' + this.form.nis + ' sudah tersedia');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal('save');
                            this.siswa_count += 1;
                            this.$awn.success('Siswa berhasil ditambahkan');
                        }
                    },
                    error => {
                        this.cleanForm();
                        this.hideModal('save');
                        this.$awn.alert(error.message);
                    }
                );
            } else {
                this.$awn.asyncBlock(
                    axios.post(route('siswa.update', { siswa: this.siswa_id }), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Siswa dengan NIS ' + this.form.nis + ' sudah tersedia');
                        } else if (response.data.status == 'tidak berubah') {
                            this.$awn.info('Data siswa tidak berubah');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal('save');
                            this.$awn.success('Siswa berhasil diubah');
                        }
                    },
                    error => {
                        this.cleanForm();
                        this.hideModal('save');
                        this.$awn.alert(error.message);
                    }
                );
            }
        },
        edit (id) {
            let siswa = this.rows.data.find(x => x.id == id);
            this.form.nis = siswa.nis;
            this.form.nama = siswa.nama;
            this.form.tingkat_id = siswa.tingkat_id;
            this.form.kelas_id = siswa.kelas_id;
            this.form.password = siswa.password;
            this.update_status = true;
            this.siswa_id = id;
            this.showModal('save');
        },
        destroy (id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.get(route('siswa.destroy', { siswa: id })),
                    response => {
                        if (response.data.nama_relasi == 'buku') {
                            this.$awn.info(response.data.banyak_relasi + ' peminjaman telah terkait siswa ini');
                        } else if (response.data.nama_relasi == 'kunjungan') {
                            this.$awn.info(response.data.banyak_relasi + ' kunjungan telah terkait siswa ini');
                        } else {
                            this.lists();
                            this.siswa_count -= 1;
                            this.$awn.success('Siswa berhasil dihapus');
                        }
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
                'Siswa akan dihapus secara permanen',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        importExcel () {
            if (this.import.length == 0) {
                this.$awn.alert('File tidak ditemukan');
            } else {
                this.$awn.asyncBlock(
                    axios.post(route('siswa.import'), {rows: this.import}),
                    response => {
                        this.hideModal('import');
                        this.rows = {};
                        this.import = [];
                        this.formData();
                        this.$awn.info(response.data.count_berhasil + ' Berhasil dan ' + response.data.count_gagal + ' Gagal');
                        if (response.data.count_gagal > 0) {
                            this.failed_import = [];
                            this.failed_import = response.data.failed_import;
                        }
                        document.getElementById('import').value = null;
                    },
                    error => {
                        this.hideModal('import');
                        this.rows = {};
                        this.import = [];
                        this.formData();
                        this.$awn.alert(error.message);
                    }
                );
            }
        },
        readExcel (event) {
            let file = event.target.files[0].name;
            let reg = /(.*?)\.(xlsx)$/;
            if (!file.match(reg)) {
               this.$awn.alert('Harus berupa file excel');
                event.target.value = '';
            } else {
                readXlsxFile(event.target.files[0]).then((rows) => {
                    rows.forEach(item => {
                        this.import.push({
                            nis: item[1],
                            nama: item[2],
                            password: item[3],
                            tingkat: item[4],
                            kelas: item[5],
                        });
                    });
                });
            }
        },
        generatePassword () {
            this.form.password = Math.random().toString(35).substring(5).toUpperCase();
        },
        cleanForm () {
            this.form.nis = '';
            this.form.nama = '';
            this.form.tingkat_id = '';
            this.form.kelas_id = '';
            this.form.password = '';
            this.$refs.form.reset();
        },
        showModal (type) {
            if (type == 'save') {
                $('#saveModal').modal('show');
            } else {
                $('#importModal').modal('show');
            }
        },
        hideModal (type) {
            if (type == 'save') {
                $('#saveModal').modal('hide');
            } else {
                $('#importModal').modal('hide');
            }
        },
    }
}
</script>