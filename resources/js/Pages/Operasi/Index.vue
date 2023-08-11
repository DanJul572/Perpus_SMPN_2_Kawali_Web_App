<template>
    <Admin title="Operasi">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Bersikan Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('semua')"  class="btn btn-primary btn-xs btn-block">Semua </button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('buku')" class="btn btn-primary btn-xs btn-block">Buku</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('mapel')" class="btn btn-primary btn-xs btn-block">Mapel</button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('kategori')" class="btn btn-primary btn-xs btn-block">Ketegori</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('siswa')" class="btn btn-primary btn-xs btn-block">Siswa</button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('tingkat')" class="btn btn-primary btn-xs btn-block">Tingkat</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('kelas')" class="btn btn-primary btn-xs btn-block">Kelas</button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('peminjaman')" class="btn btn-primary btn-xs btn-block">Peminjaman Umum</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('peminjaman terkonfirmasi')" class="btn btn-primary btn-xs btn-block">Peminjaman Umum (Terkonfirmasi)</button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('peminjaman_mapel')" class="btn btn-primary btn-xs btn-block">Peminjaman Mapel</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <button v-on:click="clean('peminjaman_mapel terkonfirmasi')" class="btn btn-primary btn-xs btn-block">Peminjaman Mapel (Terkonfirmasi)</button>
                            </div>
                            <div class="col-md-6">
                                <button v-on:click="clean('kunjungan')" class="btn btn-primary btn-xs btn-block">Kunjungan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Data Global</h6>
                    </div>
                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                            <form v-on:submit.prevent="handleSubmit(update)" method="post">
                                <div class="form-group">
                                    <ValidationProvider rules="required|integer" v-slot="{ errors }">
                                        <small>Denda Per Hari :</small>
                                        <input v-model="form.denda_per_hari" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <button type="sumbit" class="btn btn-primary btn-xs btn-block mt-">Simpan</button>
                                </div>
                            </form>
                        </ValidationObserver>
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
extend('integer', value => {
    if (/^\d+$/.test(value)) {
        return true;
    } else {
        return 'Field ini harus berupa angka';
    }
});
export default {
    components: { Admin },
    data () {
        return {
            form: {
                denda_per_hari: 0
            }
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        lists () {
            this.$awn.asyncBlock(
                axios.get(route('operasi.lists')),
                response => {
                    this.form.denda_per_hari = response.data.denda_per_hari;
                    this.$awn.success('Data operasi berhasil dimuat');
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        update () {
            this.$awn.asyncBlock(
                axios.post(route('operasi.update'), this.form),
                response => {
                    if (response.data.status == 'tidak berubah') {
                        this.$awn.info('Data tidak berubah');
                    } else {
                        this.$awn.success('Data berhasil diubah');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        clean (type) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.post(route('operasi.clean', { type: type })),
                    response => {
                        if (response.data.terhapus == 0) {
                            this.$awn.info('Tidak ada yang terhapus');
                        } else {
                            this.$awn.success(response.data.terhapus + ' data berhasil terhapus');
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
                'Aksi ini akan menghapus beberapa data sekaligus',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
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
