<script>
    import {Pie} from 'vue-chartjs'

    export default {
        extends: Pie,
        props: {
            labels: {
                type: Array,
                required: true
            },
            datasets: {
                type: Object,
                default: () => {
                    return {};
                }
            }
        },
        name: "PieGraph",
        mounted() {
            this.paint();
        },
        methods: {
            paint() {
                this.renderChart({
                    labels:["Auta"],
                    datasets:{
                        backgroundColor:"#333",
                        data:[100]
                    }
                }, {});
            }
        },
        watch: {
            datasets() {
                this.paint();
                console.log("tady");
            }
        }
    }
</script>

<style scoped>

</style>
