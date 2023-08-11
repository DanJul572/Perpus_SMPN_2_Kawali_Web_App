<template>
    <div class="row">
        <div v-for="row in rows" :key="row.id" class="col-md-6">
            <div class="card border-dark">
                <div class="card-header text-center">
                    {{ row.nama }}
                </div>
                <div class="card-body text-center p-0">
                    <small>Klasifikasi</small>
                    <barcode :value="row.kode" width="2" height="70"></barcode>
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
