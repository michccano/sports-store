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
            "password" => bcrypt("123456"),
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
        ]);
    }
}
