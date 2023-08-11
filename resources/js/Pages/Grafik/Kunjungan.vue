<script>
import { Bar } from 'vue-chartjs'
export default {
    extends: Bar,
    props: ['data'],
    mounted () {
        this.renderChart({
            labels: this.data.waktu,
            datasets: [
                {
                    label: 'Kunjungan',
                    backgroundColor: '#3490dc',
                    data: this.data.count
                }
            ]
        },
        {
            responsive: true,
            maintainAspectRatio: false
        })
    }
}
</script>
