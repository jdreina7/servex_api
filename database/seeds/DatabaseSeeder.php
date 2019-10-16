<?php

use App\Role;
use App\User;
use App\Category;
use App\Subcategory;
use App\Client;
use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Role::truncate();
        User::truncate();
        Client::truncate();
        Category::truncate();
        Subcategory::truncate();
        Product::truncate();
        DB::table('category_client')->truncate();

        $cantRoles = 2;
        $cantUsuar = 4;
        $cantClien = 10;
        $cantCateg = 13;
        $cantSubca = 8;
        $cantProdu = 40;

        factory(Role::class, $cantRoles)->create();

        factory(User::class, $cantUsuar)->create();

        factory(Client::class, $cantClien)->create();

        factory(Category::class, $cantCateg)->create()->each(
        	function($client) {
        		$client_id = Client::all()->random('id');
        		$client->clients()->attach($client_id->first());
        	}
        );

        factory(Subcategory::class, $cantSubca)->create();
        
        factory(Product::class, $cantProdu)->create();

    }
}
