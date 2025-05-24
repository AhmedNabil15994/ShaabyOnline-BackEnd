<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('options')->delete();
        
        \DB::table('options')->insert(array (
            0 => 
            array (
                'id' => 15,
                'title' => '{"ar": "الالوان", "en": "Color"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:18',
                'updated_at' => '2021-09-07 18:24:05',
            ),
            1 => 
            array (
                'id' => 16,
                'title' => '{"ar": "الحجم", "en": "Size"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => '2020-05-05 22:04:58',
                'created_at' => '2020-03-08 12:06:49',
                'updated_at' => '2021-09-07 18:24:05',
            ),
            2 => 
            array (
                'id' => 17,
                'title' => '{"ar": "المقاس", "en": "Sizes"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => NULL,
                'created_at' => '2020-05-02 21:00:25',
                'updated_at' => '2021-09-07 18:24:05',
            ),
            3 => 
            array (
                'id' => 18,
                'title' => '{"ar": "اختر اللون", "en": "Choose Color"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => '2020-05-29 19:54:58',
                'created_at' => '2020-05-05 04:50:29',
                'updated_at' => '2021-09-07 18:24:05',
            ),
            4 => 
            array (
                'id' => 19,
                'title' => '{"ar": "حجم", "en": "Measurement"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 05:18:26',
                'updated_at' => '2021-09-07 18:24:05',
            ),
            5 => 
            array (
                'id' => 20,
                'title' => '{"ar": "تصاميم", "en": "Designs"}',
                'status' => 1,
                'option_as_filter' => 0,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:24:05',
            ),
        ));
        
        
    }
}