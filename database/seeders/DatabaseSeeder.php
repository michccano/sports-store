<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            "firstname" => "Admin",
            "lastname" => "",
            "email" => "admin@gmail.com",
            "password" => bcrypt("admin"),
            "address1" => "",
            "address2" => "",
            "city" => "",
            "state" => "",
            "postal" => "",
            "country" => "",
            "dayphone" => "",
            "evephone" => "" ,
            "status" => 1,
            "role" => 1,
            "pick" => 1,
        ]);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        /*$this->call(OrdersTableSeeder::class);
        $this->call(PublishedUsersTableSeeder::class);
        $this->call(PUblishedCategoriesTableSeeder::class);
        $this->call(PublishedProductsTableSeeder::class);*/
    }
}
