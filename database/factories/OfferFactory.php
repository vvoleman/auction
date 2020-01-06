<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$c = \Carbon\Carbon::now();

$factory->define(\App\Offer::class, function (Faker $faker) use($c){
    return [
        "name"=>Str::random(6),
        "type_id"=>2,
        "currency_id"=>1,
        "payment_type_id"=>2,
        "delivery_type_id"=>2,
        "category_id"=>1,
        "price"=>$faker->randomNumber(3),
        "end_date"=>$c->addDays(30),
        "owner_id"=>1,
        "uuid"=>\Illuminate\Support\Str::random(16),
        "description"=>$faker->randomHtml(),
        "created_at"=>$c,
        "updated_at"=>$c
    ];
});
