<template>
    <User title="Create">
        <div class="row mb-3">
            <div class="col-md">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman.*') ? 'active' : ''" :href="route('peminjaman.create')">Umum</inertia-link>
                    </li>
                    <li class="nav-item">
                        <inertia-link class="nav-link" :class="route().current('peminjaman_mapel.*') ? 'active' : ''" :href="route('peminjaman_mapel.create')">Mapel</inertia-link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card mb-3">
                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                            <form method="post" v-on:submit.prevent="handleSubmit(confirmSave)">
                                <div class="row">
                                    <div class="col-md">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <small>NIS :</small>
                                            <input v-model="form.nis" type="text" :class="classInput(errors[0])">
                                            <div v-if="errors[0]" class="invalid-feedback">
                                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                            </div>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-md">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <small>Tenggat :</small>
                                            <input v-model="form.tenggat" type="date" :class="classInput(errors[0])">
                                            <div v-if="errors[0]" class="invalid-feedback">
                                                <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                            </div>
                                        </ValidationProvider>
                                    </div>
                                    <div class="col-md-2">
                                        <small>Aksi :</small>
                                        <button class="btn btn-block btn-sm btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ValidationObserver v-slot="{ handleSubmit }" ref="search_form">
                                    <form method="post" v-on:submit.prevent="handleSubmit(mapel)">
                                        <ValidationProvider rules="required" v-slot="{ errors }">
                                            <div class="input-group">
                                                <input v-model="klasifikasi" type="text" placeholder="Klasifikasi Mapel" :class="classInput(errors[0])">
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
                                <div v-if="form.mapel.length === 0" class="my-5">
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
                                        <tr v-for="row in form.mapel" :key="row.id">
                                            <td>{{ row.klasifikasi }}</td>
                                            <td>{{ row.nama }}</td>
                                            <td>{{ row.rak }}</td>
                                            <td>{{ row.kategori.nama }}</td>
                                            <td>
                                                <button v-on:click="remove(row.id)" type="button" class="btn btn-round btn-xs btn-danger">
                                                    <i class="fas fa-fw fa-trash"></i>
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
                tenggat: '',
                mapel: [],
            },
            klasifikasi: '',
        }
    },
    mounted () {
        if (this.nis) {
            this.form.nis = this.nis;
        }
    },
    methods: {
        save () {
            if (this.form.mapel.length == 0) {
                this.$awn.warning('Mapel tidak boleh kosong');
            } else {
                this.$awn.asyncBlock(
                    axios.post(route('peminjaman_mapel.store'), this.form),
                    response => {
                        if (response.data.status == 'siswa tidak ada') {
                            this.$awn.warning('Siswa dengan NIS ' + this.form.nis + ' tidak ditemukan');
                        } else {
                            this.cleanForm();
                            this.klasifikasi = '';
                            this.$refs.search_form.reset();
                            if (this.nis) {
                                this.form.nis = this.nis;
                            }
                            this.$awn.success('Peminjaman berhasil ditambahkan');
                        }
                    },
                    error => {
                        this.$awn.alert(error.message);
                    }
                );
            }
        },
        confirmSave () {
            let onOk = () => {
                this.save();
            }
            let onCancle = () => {
                return;
            }
            this.$awn.confirm(
                'Peminjaman akan disimpan',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        mapel () {
            this.$awn.asyncBlock(
                axios.get(route('mapel.select', {klasifikasi: this.klasifikasi})),
                response => {
                    if (response.data.status == 'tidak ada') {
                        this.$awn.warning('Mapel dengan klasifikasi "' + this.klasifikasi + '" tidak ditemukan.');
                    } else if (response.data.status == 'dipinjam') {
                        this.$awn.info('Mapel dengan klasifikasi "' + this.klasifikasi + '" telah terpinjam.');
                    } else {
                        this.form.mapel.push(response.data);
                    }
                    this.klasifikasi = '';
                    this.$refs.search_form.reset();
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        remove (id) {
            let index = this.form.mapel.findIndex(x => x.id == id);
            this.form.mapel.splice(index, 1);
        },
        cleanForm () {
            this.form.mapel = [];
            this.form.tenggat = '';
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
    }
}
</script>
