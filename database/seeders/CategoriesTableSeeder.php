<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
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
                'id' => 2,
                'name' => 'Services',
                'status' => '1',
                'created_at' => '2021-10-03 12:26:45',
                'updated_at' => '2021-10-03 12:26:45',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Online Publication',
                'status' => '1',
                'created_at' => '2021-10-03 12:27:16',
                'updated_at' => '2021-10-03 12:27:16',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Memberships',
                'status' => '1',
                'created_at' => '2021-10-04 07:03:28',
                'updated_at' => '2021-10-04 07:07:27',
            ),
        ));
        
        
    }
}