<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Models\Status::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create();
        },
        'body' => $faker->paragraph()
    ];
});
