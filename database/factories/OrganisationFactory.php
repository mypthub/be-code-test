<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Organisation;
use Faker\Generator as Faker;


$factory->define(Organisation::class, function (Faker $faker) {
    $subbed = random_int(0, 1);

    return [
        'name' => $faker->company,
        'subscribed' => $subbed,
        'trial_end' => !$subbed ? \Carbon\Carbon::now()->addDays(30) : null,
    ];
});
