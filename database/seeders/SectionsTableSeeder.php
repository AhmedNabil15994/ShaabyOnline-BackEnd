<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();

        DB::table('sections')->insert(array(
            0 =>
            array(
                'id' => 1,
                'seo_keywords' => '{"ar": null, "en": null}',
                'seo_description' => '{"ar": null, "en": null}',
                'slug' => '{"ar": "matger", "en": "vendor"}',
                'title' => '{"ar": "متجر", "en": "Vendor"}',
                'description' => '{"ar": "<p>متجر</p>", "en": "<p>Vendor</p>"}',
                'status' => 1,
                'image' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-08-16 05:57:27',
                'updated_at' => '2021-09-06 21:15:18',
            ),
            1 =>
            array(
                'id' => 2,
                'seo_keywords' => '{"ar": null, "en": null}',
                'seo_description' => '{"ar": null, "en": null}',
                'slug' => '{"ar": "mateam", "en": "resturant"}',
                'title' => '{"ar": "مطعم", "en": "Resturant"}',
                'description' => '{"ar": "<p>مطعم</p>", "en": "<p>Resturant</p>"}',
                'status' => 1,
                'image' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-08-12 12:58:20',
                'updated_at' => '2021-09-06 21:09:55',
            ),

        ));
    }
}
