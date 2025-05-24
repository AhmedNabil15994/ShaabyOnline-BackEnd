<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('countries')->delete();
        
        \DB::table('countries')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => '{"ar": "الكويت", "en": "kuwait"}',
                'title' => '{"ar": "الكويت", "en": "Kuwait"}',
                'status' => 1,
                'code' => 'KW',
                'deleted_at' => NULL,
                'created_at' => '2020-01-21 07:37:03',
                'updated_at' => '2021-09-06 19:28:29',
            ),
        ));
        
        
    }
}