<template>
    <div v-if="results != null">
    <div class="white_box m-top" v-for="(o,i) in results">
            <a :href="o.url" class="no-a">
            <div class="col-md-11 mx-auto d-flex justify-content-between align-items-center">
                <div>
                    <img src="https://atasouthport.com/wp-content/uploads/2017/04/default-image-800x600.jpg" height="100px;">
                </div>
                <div>
                    <h3>{{o.name}}</h3>
                </div>
                <div class="col-md-5 d-flex justify-content-between">
                    <div>
                        <div class="money">
                            <i class="fas fa-coins" title="Cena"></i>
                            <span>{{o.price}}</span>
                        </div>
                        <div class="time">
                            <i class="fas fa-clock" title="Otevřeno do"></i>
                            <span>{{o.end_date}}</span>
                        </div>
                    </div>
                    <div>
                        <div>
                            <a :href="o.owner.url">{{o.owner.name}}</span></a>
                        </div>
                        <div>
                            <span>{{o.owner.score}}</span>
                            <i class="fas fa-star text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "SearchList",
        prop:["res"]
    }
</script>

<style scoped>

</style>
