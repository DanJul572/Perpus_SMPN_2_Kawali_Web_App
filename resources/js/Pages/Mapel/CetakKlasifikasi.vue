<template>
    <div class="row">
        <div v-for="row in rows" :key="row.id" class="col-md-4">
            <div class="card border-dark">
                <div class="card-header text-center">
                    {{ row.nama }}
                </div>
                <div class="card-body text-center p-0">
                    <vue-qrcode :value="row.klasifikasi"></vue-qrcode>
                    <p><small>{{ row.klasifikasi }}</small></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [ 'rows' ],
    data () {
        return {

        }
    }
}
</script>
