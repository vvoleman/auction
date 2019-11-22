<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Offer::class, function (Faker $faker) {
    return [
        "name"=>Str::random(6),
        "type_id"=>2,
        "currency_id"=>1,
        "payment_type_id"=>2,
        "delivery_type_id"=>2,
        "price"=>$faker->randomNumber(3),
        "end_date"=>$faker->dateTimeThisMonth('2019-11-30 20:00'),
        "owner_id"=>1,
        "uuid"=>\Illuminate\Support\Str::random(16),
        "description"=>$faker->randomHtml()
    ];
});
