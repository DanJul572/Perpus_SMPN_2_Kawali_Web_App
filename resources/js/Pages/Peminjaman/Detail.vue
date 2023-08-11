<template>
    <Admin title="Detail">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">
                        <h4 class="card-title">{{ siswa.nama }}</h4>
                    </div>
                    <div class="card-body">
                        <img :src="asset('/app/main/image/siswa/default.jpg')" style="border-radius: 5px;">
                    </div>
                    <div class="card-footer">
                        <div class="legend">{{ siswa.nis }}</div>
                    </div>
                </div>
            </div>
            <div class="col align-items-center">
                <div class="row">
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-primary">
                                            <i class="fas fa-fw fa-door-open text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Kelas</p>
                                            <h4 class="card-title">{{ tingkat.nama }} - {{ kelas.nama }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-secondary">
                                            <i class="fas fa-fw fa-key text-secondary"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Password</p>
                                            <h4 class="card-title">{{ siswa.password }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="fas fa-fw fa-calendar-check text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Hari Ini</p>
                                            <h4 class="card-title">{{ keterangan.hari_ini }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-danger">
                                            <i class="fas fa-fw fa-calendar-times text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Terlamat</p>
                                            <h4 class="card-title">{{ keterangan.terlambat }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-success">
                                            <i class="fas fa-fw fa-check text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Selesai</p>
                                            <h4 class="card-title">{{ keterangan.selesai }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center icon-info">
                                            <i class="fas fa-fw fa-sort-amount-down text-info"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Total</p>
                                            <h4 class="card-title">{{ keterangan.total }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <div v-if="buku.length > 0" class="badge badge-danger">Total Denda : {{ formatRupiah(total_denda, 'Rp. ') }}</div>
                            </div>
                            <div class="col text-right">
                                <button v-on:click="[showModal('form'), cleanForm()]" class="btn btn-round btn-primary btn-sm">
                                   <i class="fas fa-fw fa-plus"></i> Tambah Peminjaman
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="buku.length === 0" class="flex-center position-ref m-5">
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
                                    <th scope="col">Nama</th>
                                    <th scope="col">Tenggat</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Denda</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="row in buku" :key="row.pivot.id">
                                    <td>{{ row.nama }}</td>
                                    <td>{{ row.pivot.tenggat | moment("D MMMM YYYY") }}</td>
                                    <td>
                                        <div v-if="(row.status.negative < 0) && (row.pivot.dikembalikan == false)" class="badge badge-danger">
                                            Terlambat {{ row.status.positive }} Hari
                                        </div>
                                        <div v-else-if="(row.status.negative == 0) && (row.pivot.dikembalikan == false)" class="badge badge-warning">
                                            Hari Ini
                                        </div>
                                        <div v-else-if="(row.status.negative > 0) && (row.pivot.dikembalikan == false)" class="badge badge-info">
                                            Tersisa {{ row.status.positive }} Hari
                                        </div>
                                        <div v-else class="badge badge-success">
                                            Selesai
                                        </div>
                                    </td>
                                    <td>
                                        <span v-if="(row.status.negative < 0) && (row.pivot.dikembalikan == false)">
                                            {{ formatRupiah(row.status.positive * denda, 'Rp. ') }}
                                        </span>
                                        <span v-else>
                                            -
                                        </span>
                                    </td>
                                    <td>
                                        <button v-if="row.pivot.dikembalikan == false" v-on:click="returned(row.pivot.id)" class="btn btn-success btn-round btn-xs">
                                            <i class="fas fa-fw fa-check-circle"></i>
                                        </button>
                                        <button v-on:click="destroy(row.pivot.id)" class="btn btn-danger btn-round btn-xs">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </button>
                                        <button v-on:click="[showModal('info'), showInfo(row.pivot.id)]" class="btn btn-info btn-round btn-xs">
                                            <i class="fas fa-fw fa-info"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form Modal -->
        <div class="modal fade" id="formModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="modal-header">
                                <h6 class="modal-title" id="formModalTitle">
                                    <i class="fas fa-fw fa-book-reader"></i> Form Peminjaman
                                </h6>
                                <button v-on:click="hideModal('form')" type="button" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Tenggat :</small>
                                        <input v-model="form.tenggat" type="date" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Klasifikasi Buku :</small>
                                        <input v-model="form.klasifikasi" type="text" class="form-control">
                                        <small v-if="errors[0]" class="form-text text-danger text-muted">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </small>
                                    </ValidationProvider>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-round btn-sm btn-secondary" v-on:click="hideModal('form')">
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
        <!-- Info Modal -->
        <div class="modal fade" id="infoModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="infoModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="infoModalTitle">
                            <i class="fas fa-fw fa-book-reader"></i> Info Peminjaman
                        </h6>
                        <button v-on:click="hideModal('info')" type="button" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col-4 mb-3">Klasifikasi</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.klasifikasi }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Nama</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.nama }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Kategori</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.kategori }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Rak</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.rak }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Tersimpan</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.tersimpan }}</div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-4 mb-3">Tenggat</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ info.tenggat }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Status</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div v-if="(info.status.negative < 0) && (info.dikembalikan == false)" class="col text-right">
                                        Terlambat {{ info.status.positive }} Hari
                                    </div>
                                    <div v-else-if="(info.status.negative == 0) && (info.dikembalikan == false)" class="col text-right">
                                        Hari Ini
                                    </div>
                                    <div v-else-if="(info.status.negative > 0) && (info.dikembalikan == false)" class="col text-right">
                                        Tersisa {{ info.status.positive }} Hari
                                    </div>
                                    <div v-else class="col text-right">
                                        Selesai
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Denda Per Hari</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div class="col text-right">{{ formatRupiah(denda, 'Rp. ') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-4 mb-3">Total Denda</div>
                                    <div class="col-1 mb-3">:</div>
                                    <div v-if="(info.status.negative < 0) && (info.dikembalikan == false)" class="col text-right">
                                        {{ formatRupiah(info.status.positive * denda, 'Rp. ') }}
                                    </div>
                                    <div v-else class="col text-right">
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-round btn-sm btn-secondary" v-on:click="hideModal('info')">
                            <i class="fas fa-fw fa-times-circle"></i> Tutup
                        </button>
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
import moment from 'moment';
extend('required', {
    ...required,
    message: 'Field ini harus diisi'
});
export default {
    components: { Admin },
    props: [ 'id' ],
    data () {
        return {
            siswa: '',
            tingkat: '',
            kelas: '',
            keterangan: '',
            buku: [],
            denda: '',
            total_denda: 0,
            form: {
                klasifikasi: '',
                tenggat: '',
            },
            info: {
                klasifikasi: '',
                nama: '',
                kategori: '',
                rak: '',
                tenggat: '',
                status: {
                    negative: 0,
                    positive: 0,
                },
                denda: '',
                tersimpan: '',
            }
        }
    },
    mounted () {
        this.detail();
    },
    methods: {
        detail () {
            this.$awn.asyncBlock(
                axios.get(route('peminjaman.detail', { siswa: this.id })),
                response => {
                    this.buku = [];
                    this.total_denda = 0;
                    this.mappingData(response.data);
                    this.$awn.success('Detail peminajaman berhasil dimuat');
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
        save () {
            this.$awn.asyncBlock(
                axios.post(route('peminjaman.store', { siswa: this.id }), this.form),
                response => {
                    if (response.data.status == 'buku tidak ada') {
                        this.$awn.info('Buku dengan klasifikasi ' + this.form.klasifikasi + ' tidak tersedia');
                    } else if (response.data.status == 'terpinjam') {
                        this.$awn.info('Buku dengan klasifikasi ' + this.form.klasifikasi + ' sudah terpinjam');
                    } else {
                        this.detail();
                        this.cleanForm();
                        this.hideModal('form');
                        this.$awn.success('Peminjaman berhasil ditambahkan');
                    }
                },
                error => {
                    this.cleanForm();
                    this.hideModal('form');
                    this.$awn.alert(error.message);
                }
            );
        },
        destroy (peminjaman_id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.post(route('peminjaman.destroy', { siswa: this.id }), { peminjaman_id: peminjaman_id }),
                    () => {
                        this.detail();
                        this.$awn.success('Peminajaman berhasil dihapus');
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
                'Peminjaman akan dihapus secara permanen',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        returned (peminjaman_id) {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.post(route('peminjaman.returned', { siswa: this.id }), { peminjaman_id: peminjaman_id }),
                    () => {
                        this.detail();
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
        showInfo (id) {
            let buku = this.buku.find(x => x.pivot.id == id);
            this.info.klasifikasi = buku.klasifikasi;
            this.info.nama = buku.nama;
            this.info.kategori = buku.kategori.nama;
            this.info.rak = buku.rak;
            this.info.dikembalikan = buku.pivot.dikembalikan;
            this.info.tenggat = moment(buku.pivot.tenggat).format('D MMMM YYYY');
            let status = this.status(buku.pivot.tenggat);
            this.info.status.negative = status.negative;
            this.info.status.positive = status.positive;
            this.info.denda = buku.denda;
            this.info.tersimpan = moment(buku.pivot.created_at).format('D MMMM YYYY');
        },
        mappingData (data) {
            this.keterangan = data.keterangan;
            this.denda = data.denda.denda_per_hari;
            this.siswa = data.siswa;
            this.tingkat = data.tingkat;
            this.kelas = data.kelas;
            data.buku.forEach(item => {
                item.status = this.status(item.pivot.tenggat);
                if (item.status.negative < 0) {
                    item.denda = this.denda * item.status.negative;
                    this.total_denda += item.status.positive * this.denda;
                }
                this.buku.push(item);
            });
        },
        status (tenggat) {
            var mulai = moment(tenggat, "YYYY-MM-DD");
            let berakhir = moment().startOf('day');
            let rentang = Math.floor(( mulai - berakhir ) / 86400000);
            return {
                negative: parseInt(rentang),
                positive: parseInt(Math.abs(rentang))
            };
        },
        formatRupiah(angka, prefix) {
            let number_string = angka.toString();
            let split = number_string.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah + ',00' : '');
        },
        cleanForm () {
            this.form.klasifikasi = '';
            this.form.tenggat = '';
            this.$refs.form.reset();
        },
        showModal (type) {
            if (type == 'form') {
                $('#formModal').modal('show');
            } else {
                $('#infoModal').modal('show');
            }
        },
        hideModal (type) {
           if (type == 'form') {
                $('#formModal').modal('hide');
            } else {
                $('#infoModal').modal('hide');
            }
        },
    }
}
</script>