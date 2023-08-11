<template>
    <Admin title="Mapel">
        <div class="row mb-3">
            <div class="col-md">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('buku.*') ? 'active' : ''" :href="route('buku.index')">Umum</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('mapel.*') ? 'active' : ''" :href="route('mapel.index')">Mapel</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row d-flex align-items-center mb-3">
            <div class="col-3">
                <div class="nav-search">
                    <div class="input-group bg-white">
                        <input v-model="keyword" type="text" placeholder="Cari..." class="form-control">
                        <div v-on:click="lists" class="pointer input-group-append">
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
                <download-excel class="btn btn-sm btn-rounded btn-success" :fetch="exportData" :fields="export_fields" :before-generate="startDownload" :before-finish="finishDownload">
                    <div class="d-flex">
                        <div class="d-block mr-1">
                            <i class="fas fa-fw fa-file-export"></i> Export Kondisi
                        </div>
                        <div class="d-block">
                            <vue-loading v-if="loading == true" type="spiningDubbles" color="#FFFFFF" :size="{ width: '13px', height: '13px' }"></vue-loading>
                        </div>
                    </div>
                </download-excel>
                <button v-on:click="generateKlasifikasi('klasifikasi')" class="btn btn-round btn-success btn-sm">
                    <i class="fas fa-fw fa-file-export"></i> Export Label
                </button>
                <button v-on:click="showModal('import')" class="btn btn-round btn-primary btn-sm">
                    <i class="fas fa-fw fa-file-import"></i> Import Data
                </button>
                <button v-on:click="[showModal('save'), cleanForm(), update_status = false]" class="btn btn-round btn-primary btn-sm">
                    <i class="fas fa-fw fa-plus"></i> Tambah Mapel
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
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
                <div v-else class="card">
                    <div class="card-header d-flex">
                        <h4 class="card-title mr-1">{{ mapel_count }}</h4>
                        <p class="card-category">Mapel</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-head-bg-primary">
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
                                <tr v-for="row in rows.data" :key="row.id">
                                    <td>{{ row.klasifikasi }}</td>
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.rak }}</td>
                                    <td>{{ row.kategori.nama }}</td>
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
                                    <i class="fas fa-fw fa-book"></i> Form Mapel
                                </h6>
                                <button v-on:click="hideModal('save')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
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
                                        <small>Klasifikasi :</small>
                                        <input v-model="form.klasifikasi" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Rak :</small>
                                        <input v-model="form.rak" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Kategori :</small>
                                        <v-select v-model="form.kategori_id" label="nama" :options="kategori" :reduce="kategori => kategori.id"></v-select>
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
                                <i class="fas fa-fw fa-book"></i> Import Mapel
                            </h6>
                            <button v-on:click="hideModal('import')" type="button" class="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <small>Format :</small>
                                <span class="text-bold d-block">| Nomor | Klasifikasi | Nama | Rak | Kategori |</span>
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
        <!-- Print -->
        <vue-html2pdf
            :html-to-pdf-options="{
                pagebreak: { mode: ['avoid-all'] },
                filename: 'Klasifikasi.pdf',
            }"
            :show-layout="false"
            :float-layout="true"
            :enable-download="false"
            :preview-modal="true"
            :paginate-elements-by-height="1400"
            :pdf-quality="2"
            :manual-pagination="false"
            pdf-format="a4"
            pdf-content-width="100%"
            ref="html2Pdf">
            <section slot="pdf-content">
                <cetak-klasifikasi :rows="rows.data"></cetak-klasifikasi>
            </section>
        </vue-html2pdf>
    </Admin>
</template>

<script>
import Admin from '../../Shared/Admin.vue';
import CetakKlasifikasi from './CetakKlasifikasi.vue';
import { extend } from 'vee-validate';
import { required } from "vee-validate/dist/rules";
import readXlsxFile from 'read-excel-file';
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
export default {
    components: { Admin, CetakKlasifikasi },
    data () {
        return {
            rows: {},
            kategori: [],
            penerbit: [],
            rak: [],
            mapel_count: '',
            update_status: false,
            form: {
                nama: '',
                klasifikasi: '',
                kategori_id: '',
                rak: '',
            },
            mapel_id: '',
            keyword: '',
            import: [],
            failed_import: [],
            import_fields: {
                Klasifikasi: 'klasifikasi',
                Nama: 'nama',
                Rak: 'rak',
                Kategori: 'kategori',
            },
            export_fields: {
                'Nomor': 'nomor',
                'Menu': 'menu',
                'Kuantitas': 'kuantitas',
            },
            loading: false,
        }
    },
    mounted () {
        this.lists();
        this.formData();
    },
    methods: {
        lists (page = 1) {
            this.$awn.asyncBlock(
                axios.get(route('mapel.lists') + '?page=' + page + '&keyword=' + this.keyword),
                response => {
                    if (response.data.data.length == 0) {
                        this.rows = {};
                        this.$awn.warning('Tidak ada datang yang dimuat');
                    } else {
                        this.rows = response.data;
                        this.$awn.success(response.data.data.length + ' mapel berhasil dimuat');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        formData () {
            this.$awn.asyncBlock(
                axios.get(route('mapel.form')),
                response => {
                    this.kategori = response.data.kategori;
                    this.rak = response.data.rak;
                    this.mapel_count = response.data.mapel_count;
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
                    axios.post(route('mapel.store'), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Mapel dengan klasifikasi ' + this.form.klasifikasi + ' sudah tersedia');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal('save');
                            this.mapel_count += 1;
                            this.$awn.success('Mapel berhasil ditambahkan');
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
                    axios.post(route('mapel.update', { mapel: this.mapel_id }), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Mapel dengan klasifikasi ' + this.form.klasifikasi + ' sudah tersedia');
                        } else if (response.data.status == 'tidak berubah') {
                            this.$awn.info('Data mapel tidak berubah');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal('save');
                            this.$awn.success('Mapel berhasil diubah');
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
            let mapel = this.rows.data.find(x => x.id == id);
            this.form.nama = mapel.nama;
            this.form.klasifikasi = mapel.klasifikasi;
            this.form.kategori_id = mapel.kategori_id;
            this.form.rak = mapel.rak;
            this.update_status = true;
            this.mapel_id = id;
            this.showModal('save');
        },
        destroy (id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.get(route('mapel.destroy', { mapel: id })),
                    response => {
                        if (response.data.relasi) {
                            this.$awn.info(response.data.relasi + ' peminjaman telah terkait mapel ini');
                        } else {
                            this.lists();
                            this.mapel_count -= 1;
                            this.$awn.success('Mapel berhasil dihapus');
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
                'Mapel akan dihapus secara permanen',
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
                    axios.post(route('mapel.import'), { rows: this.import }),
                    response => {
                        this.hideModal('import');
                        this.import = [];
                        this.formData();
                        this.lists();
                        this.mapel_count += response.data.count_berhasil;
                        this.$awn.info(response.data.count_berhasil + ' Berhasil dan ' + response.data.count_gagal + ' Gagal');
                        if (response.data.count_gagal > 0) {
                            this.failed_import = [];
                            this.failed_import = response.data.failed_import;
                        }
                        document.getElementById('import').value = null;
                    },
                    error => {
                        this.hideModal('import');
                        this.import = [];
                        this.formData();
                        this.lists();
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
                            klasifikasi: item[1],
                            nama: item[2],
                            rak: item[3],
                            kategori: item[4],
                        });
                    });
                });
            }
        },
        generateKlasifikasi () {
            if (Object.keys(this.rows).length === 0) {
                this.$awn.warning('Tidak ada datang yang dimuat');
            } else {
                this.$refs.html2Pdf.generatePdf();
            }
        },
        async exportData () {
            const response = await axios.get(route('mapel.export'));
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
            this.form.nama = '';
            this.form.klasifikasi = '';
            this.form.kategori_id = '';
            this.form.rak = '';
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