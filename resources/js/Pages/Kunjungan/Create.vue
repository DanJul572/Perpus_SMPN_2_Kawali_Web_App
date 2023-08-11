<template>
    <User title="Create">
        <div class="row mt-3 justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <small class="card-title">
                            Form Kunjungan
                        </small>
                    </div>
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(save)">
                            <div class="card-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>NIS :</small>
                                        <input v-model="form.nis" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block btn-sm">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </ValidationObserver>
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
    props: ['nis'],
    data () {
        return {
            form: {
                nis: '',
            },
        }
    },
    mounted () {
        if (this.nis) {
            this.form.nis = this.nis;
        }
    },
    methods: {
        save () {
            this.$awn.asyncBlock(
                axios.post(route('kunjungan.store'), this.form),
                response => {
                    if (response.data.status == 'tidak terdaftar') {
                        this.$awn.info('Siswa dengan NIS ' + this.form.nis + ' tidak terdaftar');
                    } else {
                        this.cleanForm();
                        this.$awn.success('Kunjungan berhasil ditambahkan');
                    }
                },
                error => {
                    this.$awn.alert(error.message);
                }
            );
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
    }
}
</script>
