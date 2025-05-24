<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cities')->delete();
        
        \DB::table('cities')->insert(array (
            0 => 
            array (
                'id' => 4,
                'slug' => '{"ar": "الفروانية", "en": "alfarwanya"}',
                'title' => '{"ar": "الفروانية", "en": "Alfarwanya"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 18:53:24',
                'updated_at' => '2021-09-06 18:40:02',
            ),
            1 => 
            array (
                'id' => 6,
                'slug' => '{"ar": "العاصمة", "en": "al-asimah"}',
                'title' => '{"ar": "العاصمة", "en": "al -asimah"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 18:55:32',
                'updated_at' => '2021-09-06 18:40:02',
            ),
            2 => 
            array (
                'id' => 7,
                'slug' => '{"ar": "الأحمدي", "en": "al-ahmadi"}',
                'title' => '{"ar": "الأحمدي", "en": "Al-Ahmadi"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 18:57:43',
                'updated_at' => '2021-09-06 18:40:02',
            ),
            3 => 
            array (
                'id' => 8,
                'slug' => '{"ar": "الجهراء", "en": "aljahra"}',
                'title' => '{"ar": "الجهراء", "en": "Aljahra"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 18:58:13',
                'updated_at' => '2021-09-06 18:40:02',
            ),
            4 => 
            array (
                'id' => 9,
                'slug' => '{"ar": "حولي", "en": "7awaly"}',
                'title' => '{"ar": "حولي", "en": "7awaly"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:00:02',
                'updated_at' => '2021-09-06 18:40:02',
            ),
            5 => 
            array (
                'id' => 10,
                'slug' => '{"ar": "مبارك-الكبير", "en": "mubarak-akkabyr"}',
                'title' => '{"ar": "مبارك الكبير", "en": "Mubarak akkabyr"}',
                'status' => 1,
                'country_id' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:00:40',
                'updated_at' => '2021-09-06 18:52:03',
            ),
        ));
        
        
    }
}