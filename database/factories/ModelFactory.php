<?php

use App\Role;
use App\User;
use App\Category;
use App\Subcategory;
use App\Client;
use App\Product;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});


$factory->define(User::class, function (Faker $faker) {
    $password = "";

    return [
        'role_id' => Role::all()->random()->id,
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'image' => $faker->randomElement(['avatar.png']),
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        //'verified' => $faker->randomElement([User::VERIFIED, User::NOT_VERIFIED]),
        //'verification_token' => $verified == User::VERIFIED ? null : User::gnerateVerifiedToken(),
        'created_at' => now(),
		'updated_at' => now(),
    ];
});


$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        //'email' => $faker->unique()->safeEmail,
        'bussiness_name' => $faker->company,
        'description' => $faker->paragraph(1),
        'logo' => $faker->randomElement(['logo.png']),
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'created_by' => User::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});


$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'created_by' => User::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->define(Subcategory::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'img'=> null,
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'category_id' => Category::all()->random()->id,
        'created_by' => User::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'status' => $faker->randomElement([User::ACTIVE, User::INACTIVE]),
        'client_id' => Client::all()->random()->id,
        'category_id' => Category::all()->random()->id,
        'subcategory_id' => Subcategory::all()->random()->id,
        'created_by' => User::all()->random()->id,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
