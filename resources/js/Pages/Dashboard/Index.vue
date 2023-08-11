<template>
    <Admin title="Dashboard">
        <div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-primary">
                                        <i class="fas fa-fw fa-tags text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Kategori</p>
                                        <h4 class="card-title">{{ data.kategori }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-danger">
                                        <i class="fas fa-fw fa-book text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Buku Umum</p>
                                        <h4 class="card-title">{{ data.buku }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-info">
                                        <i class="fas fa-fw fa-book text-info"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Buku Mapel</p>
                                        <h4 class="card-title">{{ data.mapel }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-success">
                                        <i class="fas fa-fw fa-layer-group text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Tingkat</p>
                                        <h4 class="card-title">{{ data.tingkat }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-secondary">
                                        <i class="fas fa-fw fa-door-open text-secondary"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Kelas</p>
                                        <h4 class="card-title">{{ data.kelas }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="fas fa-fw fa-user-graduate text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div class="numbers">
                                        <p class="card-category">Siswa</p>
                                        <h4 class="card-title">{{ data.siswa }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script>
import Admin from '../../Shared/Admin.vue';
export default {
    components: { Admin },
    data () {
        return {
            data: '',
        }
    },
    mounted () {
        this.lists();
    },
    methods: {
        lists () {
            this.$awn.asyncBlock(
                axios.get(route('dashboard.lists')),
                response => {
                    this.data = response.data;
                    this.$awn.success('Data berhasil dimuat');
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
        },
    }
}
</script>
