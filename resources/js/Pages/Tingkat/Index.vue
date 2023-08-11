<template>
    <Admin title="Tingkat">
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
                <button v-on:click="[showModal(), cleanForm(), update_status = false]" class="btn btn-round btn-primary btn-sm">
                    <i class="fas fa-fw fa-plus"></i> Tambah Tingkat
                </button>
            </div>
        </div>
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
        <div v-else class="row">
            <div v-for="row in rows.data" :key="row.id" class="col-md-4">
                <div class="alert alert-light shadow p-2 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-dark">{{ row.nama }}</span>
                    </div>
                    <div class="d-flex">
                        <i v-on:click="edit(row.id)" class="pointer fas fa-fw fa-edit text-success"></i>
                        <i v-on:click="destroy(row.id)" class="pointer fas fa-fw fa-trash text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
        <pagination align="right" :data="rows" v-on:pagination-change-page="lists"></pagination>
        <!-- Modal -->
        <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="myModalTitle">
                                    <i class="fas fa-fw fa-layer-group"></i> Form Tingkat
                                </h6>
                                <button v-on:click="hideModal()" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Nama :</small>
                                        <input v-model="form.nama" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
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
            update_status: false,
            form: {
                nama: '',
            },
            tingkat_id: '',
            keyword: ''
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        lists (page = 1) {
            this.$awn.asyncBlock(
                axios.get(route('tingkat.lists') + '?page=' + page + '&keyword=' + this.keyword),
                response => {
                    if (response.data.data.length == 0) {
                        this.rows = {};
                        this.$awn.warning('Tidak ada datang yang dimuat');
                    } else {
                        this.rows = response.data;
                        this.$awn.success(response.data.data.length + ' tingkat berhasil dimuat');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        save () {
            if (this.update_status == false) {
                this.$awn.asyncBlock(
                    axios.post(route('tingkat.store'), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Tingkat dengan nama ' + this.form.nama + ' sudah tersedia');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal();
                            this.$awn.success('Tingkat berhasil ditambahkan');
                        }
                    },
                    error => {
                        this.cleanForm();
                        this.hideModal();
                        this.$awn.alert(error.message);
                    }
                );
            } else {
                this.$awn.asyncBlock(
                    axios.post(route('tingkat.update', { tingkat: this.tingkat_id }), this.form),
                    response => {
                        if (response.data.status == 'tersedia') {
                            this.$awn.info('Tingkat dengan nama ' + this.form.nama + ' sudah tersedia');
                        } else if (response.data.status == 'tidak berubah') {
                            this.$awn.info('Data tingkat tidak berubah');
                        } else {
                            this.lists();
                            this.cleanForm();
                            this.hideModal();
                            this.$awn.success('Tingkat berhasil diubah');
                        }
                    },
                    error => {
                        this.cleanForm();
                        this.hideModal();
                        this.$awn.alert(error.message);
                    }
                );
            }
        },
        edit (id) {
            let tingkat = this.rows.data.find(x => x.id == id);
            this.form.nama = tingkat.nama;
            this.update_status = true;
            this.tingkat_id = id;
            this.showModal();
        },
        destroy (id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.get(route('tingkat.destroy', { tingkat: id })),
                    response => {
                        if (response.data.relasi) {
                            this.$awn.info(response.data.relasi + ' siswa telah terkait tingkat ini');
                        } else {
                            this.lists();
                            this.$awn.success('Tingkat berhasil dihapus');
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
                'Tingkat akan dihapus secara permanen',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        cleanForm () {
            this.form.nama = '';
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
