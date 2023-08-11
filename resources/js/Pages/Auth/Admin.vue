<template>
    <Blank title="Admin">
        <div class="row justify-content-center">
            <div class="col-md-3 text-center">
                <img :src="asset('app/main/image/logo/logo.png')">
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-5">
                <div v-if="$page.props.flash.message" :class="$page.props.flash.message.class">
                   {{ $page.props.flash.message.message }}
                </div>
                <div class="card">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                        <form method="post" v-on:submit.prevent="handleSubmit(login)">
                            <div class="card-body">
                                <div class="form-group">
                                    <ValidationProvider rules="required" v-slot="{ errors }">
                                        <small>Username :</small>
                                        <input v-model="form.username" type="text" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <ValidationProvider rules="required|length_8|space" v-slot="{ errors }">
                                        <small>Password :</small>
                                        <input v-model="form.password" type="password" :class="classInput(errors[0])">
                                        <div v-if="errors[0]" class="invalid-feedback">
                                            <i class="fas fa-fw fa-exclamation-triangle"></i> {{ errors[0] }}
                                        </div>
                                    </ValidationProvider>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block btn-sm">Masuk</button>
                                    <a :href="route('welcome')" class="btn btn-link btn-block btn-sm">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </ValidationObserver>
                </div>
            </div>
        </div>
    </Blank>
</template>

<script>
import Blank from '../../Shared/Blank.vue';
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
    components: { Blank },
    data () {
        return {
            form: {
                username: '',
                password: '',
            },
            message: ''
        }
    },
    methods: {
        login () {
            this.$awn.asyncBlock(this.$inertia.post(route('admin.login'), this.form), null);
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
