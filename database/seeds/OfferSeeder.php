<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = [];
        $count = 50;
        $offerTags = [];
        $tags = [];
        $images = [];
        $off_pic = [];

        $faker = Faker\Factory::create('cs_CZ');

        $listOfTags = array(
            "new", "care", "green", "box", "random", "example", "tags", "programming", "stack", "overflow",
            "apple", "banana", "orange", "grape", "strawberry", "melon", "pineapple", "peach", "pear", "plum",
            "cat", "dog", "rabbit", "hamster", "fish", "bird", "turtle", "snake", "lizard", "horse",
            "red", "blue", "green", "yellow", "purple", "orange", "pink", "black", "white", "gray",
            "sun", "moon", "star", "sky", "cloud", "rain", "snow", "wind", "storm", "thunder",
            "music", "dance", "art", "painting", "sculpture", "poetry", "novel", "theater", "cinema", "photography",
            "science", "technology", "engineering", "mathematics", "physics", "chemistry", "biology", "astronomy", "geology", "psychology",
            "coffee", "tea", "juice", "water", "soda", "smoothie", "milkshake", "cocktail", "beer", "wine",
            "mountain", "ocean", "river", "lake", "desert", "forest", "jungle", "island", "canyon", "volcano"
        );

        // list all images in folder and choose one randomly
        $allImages = Storage::allFiles("public/images/offer_pictures");


        foreach ($listOfTags as $tag) {
            $tags[] = [
                "id_t" => $faker->unique()->randomNumber(5),
                "name" => $tag
            ];
        }

        for ($i = 0; $i < $count; $i++) {
            $id = $faker->unique()->randomNumber(5);
            $isSold = rand(0, 100);
            $ownerId = $faker->numberBetween(1, 3);

            $picturePath = $faker->randomElement($allImages);
            // remove "public/images" from path
            $path = substr($picturePath, 13);

            $image = [
                'id_p' => $faker->unique()->randomNumber(5),
                'picture_path'=>$path,
                'creator_id' => $ownerId,
                'type_id' => 2
            ];
            $images[] = $image;
            $off_pic[] = [
                'offer_id' => $id,
                'picture_id' => $image['id_p']
            ];
            $offers[] = [
                "id_o" => $id,
                "category_id" => $faker->numberBetween(1, 4),
                "created_at" => $faker->dateTimeThisYear(),
                "currency_id" => $faker->numberBetween(1, 2),
                "delete_reason" => null,
                "delivery_type_id" => 1,
                "description" => $faker->randomHtml(2, 10),
                "end_date" => $faker->dateTimeBetween('+1 week', '+1 month'),
                "name" => $faker->realText(rand(10, 80)),
                "owner_id" => $ownerId,
                "payment_type_id" => 1,
                "price" => $faker->randomFloat(2, 1, 1000),
                "sold_to" => null,
                "type_id" => 1,
                "updated_at" => $faker->dateTimeThisYear(),
                "uuid" => Str::random(16),
            ];

            $numberOfTags = rand(1, 5);
            for ($j = 0; $j < $numberOfTags; $j++) {
                $tagIndex = rand(0, count($tags) - 1);
                $tag = $tags[$tagIndex];
                $offerTags[] = [
                    "offer_id" => $id,
                    "tag_id" => $tag['id_t'],
                ];
            }
        }

        DB::table("offers")->insert($offers);
        DB::table("tags")->insert($tags);
        DB::table("off_tag")->insert($offerTags);

        DB::table("pictures")->insert($images);
        DB::table("off_pic")->insert($off_pic);
    }
}
