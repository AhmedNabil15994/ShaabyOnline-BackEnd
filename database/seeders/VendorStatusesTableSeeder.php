<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorStatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendor_statuses')->delete();

        \DB::table('vendor_statuses')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => '{"ar": "مفتوح", "en": "Open"}',
                'accepted_orders' => 1,
                'label_color' => 'success',
                'created_at' => '2020-06-16 12:58:02',
                'updated_at' => '2020-06-16 12:58:02',
            ),
            1 =>
            array (
                'id' => 3,
                'title' => '{"ar": "مغلق", "en": "Closed"}',
                'accepted_orders' => 0,
                'label_color' => 'danger',
                'created_at' => '2020-06-16 13:02:25',
                'updated_at' => '2020-06-16 13:02:25',
            ),
            2 =>
            array (
                'id' => 4,
                'title' => '{"ar": "مشغول", "en": "Busy"}',
                'accepted_orders' => 0,
                'label_color' => 'warning',
                'created_at' => '2020-06-16 13:02:45',
                'updated_at' => '2020-06-16 13:02:45',
            ),
        ));


    }
}
