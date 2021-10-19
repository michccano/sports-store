<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PUblishedCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'created_at' => '2021-10-03 12:26:45',
                'id' => 2,
                'name' => 'Services',
                'status' => '1',
                'updated_at' => '2021-10-03 12:26:45',
            ),
            1 => 
            array (
                'created_at' => '2021-10-03 12:27:16',
                'id' => 3,
                'name' => 'Online Publication',
                'status' => '1',
                'updated_at' => '2021-10-03 12:27:16',
            ),
            2 => 
            array (
                'created_at' => '2021-10-04 07:03:28',
                'id' => 4,
                'name' => 'Memberships',
                'status' => '1',
                'updated_at' => '2021-10-04 07:07:27',
            ),
            3 => 
            array (
                'created_at' => '2021-10-14 17:30:33',
                'id' => 5,
                'name' => 'Printed Publications',
                'status' => '1',
                'updated_at' => '2021-10-14 17:30:33',
            ),
            4 => 
            array (
                'created_at' => '2021-10-14 17:46:08',
                'id' => 6,
                'name' => 'Tokens',
                'status' => '1',
                'updated_at' => '2021-10-14 17:46:08',
            ),
        ));
        
        
    }
}