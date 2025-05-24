<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            DB::table('advertising_groups')->delete();
            DB::table('advertising')->delete();

            $advertising_groups = array(
                array('id' => '1', 'title' => '{"en":"Home Page Slider","ar":"سلايدر الصفحة الرئيسية"}', 'slug' => '{"en":"home-page-slider","ar":"سلايدر-الصفحة-الرئيسية"}', 'status' => '1', 'sort' => '1', 'position' => 'home', 'deleted_at' => NULL, 'created_at' => '2022-07-27 11:35:50', 'updated_at' => '2022-08-10 14:30:38')
            );
            DB::table('advertising_groups')->insert($advertising_groups);

            $advertising = array(
                array('id' => '1', 'ad_group_id' => '1', 'image' => 'uploads/adverts/7BAImlhBZJidXNTJKVvkI6YIvFolBG3HDPbVx9UO.jpg', 'link' => '#', 'status' => '1', 'sort' => '0', 'start_at' => '2022-08-10', 'end_at' => '2030-12-31', 'advertable_id' => NULL, 'advertable_type' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 11:07:17', 'updated_at' => '2022-08-10 11:07:17'),
                array('id' => '2', 'ad_group_id' => '1', 'image' => 'uploads/adverts/22RGs1TQKcvRiuWBYZduM6G2S4AEzTMZK305Pfev.jpg', 'link' => '#', 'status' => '1', 'sort' => '1', 'start_at' => '2022-08-10', 'end_at' => '2030-12-31', 'advertable_id' => NULL, 'advertable_type' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 11:08:15', 'updated_at' => '2022-08-10 11:08:15'),
            );
            DB::table('advertising')->insert($advertising);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
