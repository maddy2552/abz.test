<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'phone' => $faker->regexify('\+380[9][95678][0-9]{7}'),
        'email' => $faker->safeEmail,
        'salary' => $faker->numberBetween(1, 500000),
        'photo' => $faker->imageUrl(300, 300),
    ];
});
