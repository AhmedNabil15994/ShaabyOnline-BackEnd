<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('packages')->delete();
        
        \DB::table('packages')->insert(array (
            0 => 
            array (
                'id' => 3,
                'seo_keywords' => '{"ar": null}',
                'seo_description' => '{"ar": null}',
                'slug' => '{"ar": "الباقة-الاساسية", "en": "default-package"}',
                'title' => '{"ar": "الباقة الاساسية", "en": "Default Package"}',
                'description' => '{"ar": "<p>الباقة الاساسية</p>", "en": "<p>Default Package</p>"}',
                'months' => 240,
                'price' => '5.000',
                'special_price' => '2.000',
                'status' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-08-16 16:43:59',
                'updated_at' => '2021-09-06 20:25:05',
            ),
        ));
        
        
    }
}