<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    return [
        'type' => 'register',
        'contact' => '89170863638',
        'data' => 'this one is registration message',
    ];
});

$factory->define(App\Models\Channel::class, function (Faker $faker) {
    return [
        'name' => 'telegram',
        'type' => 'telegram',
    ];
});

