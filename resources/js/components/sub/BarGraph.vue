<script>
    import {Bar} from 'vue-chartjs'

    export default {
        extends: Bar,
        props: {
            labels: {
                type: Array,
                required: true
            },
            datasets: {
                type: Array,
                default: () => {
                    return [];
                }
            }
        },
        name: "BarGraph",
        mounted() {
            this.draw();
        },
        computed: {
            datas() {
                var arr = [];
                for (var i = 0; i < this.datasets.length; i++) {
                    console.log(this.labels[i]);
                    arr.push({
                        label: this.labels[i],
                        backgroundColor: this.randomColor(),
                        data: [this.datasets[i]]
                    });
                }
                return arr;

            }
        },
        methods: {
            randomColor() {
                var chars = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f"];
                var string = "#";
                for (var i = 0; i < 6; i++) {
                    string += chars[Math.floor(Math.random() * 16)];
                }
                return string;
            },
            draw(){
                this.renderChart(
                    {
                        labels: this.labels,
                        datasets: this.datasets
                    },
                    {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                );
            }
        },
        watch:{
            datasets(){
                this.draw();
            }
        }
    }
</script>

<style scoped>
*{
    user-select:none;
}
</style>
