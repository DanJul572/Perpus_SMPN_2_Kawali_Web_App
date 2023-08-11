<template>
    <Admin title="Profile">
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <small class="card-title">{{ this.$page.props.admin.name }}</small>
                    </div>
                    <div class="card-body mb-1">
                        <img :src="asset('/app/main/image/profile/' + this.$page.props.admin.avatar)" style="border-radius: 5px;">
                    </div>
                    <div class="card-footer">
                        <div class="legend">Administrator</div>
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        <small class="card-title">Ubah Akun</small>
                    </div>
                    <div class="card-body">
                        <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                            <form method="post" v-on:submit.prevent="handleSubmit(update)" ref="form">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <small>Name :</small>
                                                <input v-model="form.name" type="text" :class="classInput(errors[0])">
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <ValidationProvider rules="required" v-slot="{ errors }">
                                                <small>Username :</small>
                                                <input v-model="form.username" type="text" :class="classInput(errors[0])">
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <ValidationProvider rules="required|length_8|space" v-slot="{ errors }">
                                                <small>Password :</small>
                                                <input v-model="form.password" type="password" :class="classInput(errors[0])">
                                                <div v-if="errors[0]" class="invalid-feedback">
                                                    <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <small>Avatar :</small>
                                            <input v-on:change="setGambar($event)" id="avatar" type="file" class="form-control avatar">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary btn-sm btn-block">Simpan</button>
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
extend('length_8', value => {
    if ((value.length >= 8)) {
        return true;
    } else {
        return 'Field ini minimal berisi 8 karakter';
    }
});
extend('space', value => {
    if (/\s/.test(value)) {
        return 'Field ini tidak boleh memiliki spasi';
    } else {
        return true;
    }
});
export default {
    components: { Admin },
    data () {
        return {
            form: {
                name: '',
                username: '',
                password: '',
                avatar: '',
            },
        }
    },
    methods: {
        update () {
            let onOk = () => {
                this.$awn.asyncBlock(
                    axios.post(route('admin.update'), this.form),
                    () => {
                        this.cleanForm();
                        this.$awn.success('Profile berhasil diubah');
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
                'Profile admin akan diubah',
                onOk,
                onCancle,
                {
                    labels: {
                        confirm: 'APAKAH ANDA YAKIN ?'
                    }
                }
            );
        },
        setGambar (event) {
            let file = event.target.files[0].name;
            let reg = /(.*?)\.(jpg|bmp|jpeg|png)$/;
            if (!file.match(reg)) {
               this.$awn.alert('Field ini harus berisi gambar');
                event.target.value = '';
            } else {
                let file = event.target.files[0];
                let reader = new FileReader;
                reader.onloadend = () => {
                    this.form.avatar = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },
        cleanForm () {
            this.form.name = '';
            this.form.username = '';
            this.form.password = '';
            this.form.avatar = '';
            document.getElementById('avatar').value = null;
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
