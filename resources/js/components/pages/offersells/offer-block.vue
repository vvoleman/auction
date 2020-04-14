<template>
    <div class="white_box">
        <div class="m-top search-item">
            <div class="d-md-flex align-items-center flex-wrap">
                <div class=" imgbg" :style="{'background-image':'url('+offer.img+')'}">


                </div>
                <div class="col-rl-10 m-top" style="margin-left:5px;">
                    <h5>{{offer.name}}</h5>
                    <table>
                        <tr>
                            <td><i class="fas fa-clock" title="Datum vytvoření"></i></td>
                            <td> <span>{{offer.created_at}}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-coins" title="Cena"></i></td>
                            <td> <span>{{offer.currency}} {{offer.price}}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-money-bill-alt" title="Typ platby"></i></td>
                            <td> <span>{{offer.payment}}</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-truck" title="Typ dopravy"></i></td>
                            <td> <span>{{offer.delivery.label}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "offer-block",
        props: [
            'offer'
        ]
    }
</script>

<style scoped>
    .imgbg {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 200px;
        width: 100%;
        background-color:#eee;
    }
    td span{
        margin-left:10px;
    }
</style>
