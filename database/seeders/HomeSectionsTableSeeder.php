<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSectionsTableSeeder extends Seeder
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
            DB::table('app_homes')->delete();
            DB::table('homables')->delete();

            $app_homes = array(
                array('id' => '1', 'title' => '{"en":"Slider","ar":"سلايدر"}', 'short_title' => NULL, 'description' => '{"ar":null}', 'status' => '1', 'order' => '1', 'type' => 'sliders', 'display_type' => 'carousel', 'grid_columns_count' => NULL, 'start_at' => NULL, 'end_at' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 10:56:47', 'updated_at' => '2022-08-10 10:56:47'),
                array('id' => '2', 'title' => '{"en":"Best Vendors","ar":"أفضل المتاجر"}', 'short_title' => NULL, 'description' => '{"ar":null}', 'status' => '1', 'order' => '2', 'type' => 'vendors', 'display_type' => 'grid', 'grid_columns_count' => '4', 'start_at' => NULL, 'end_at' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 15:13:54', 'updated_at' => '2022-08-10 15:13:54'),
                array('id' => '3', 'title' => '{"en":"Categories","ar":"الاقسام"}', 'short_title' => NULL, 'description' => '{"ar":null}', 'status' => '1', 'order' => '3', 'type' => 'categories', 'display_type' => 'grid', 'grid_columns_count' => '4', 'start_at' => NULL, 'end_at' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 15:20:31', 'updated_at' => '2022-08-10 15:51:12'),
                array('id' => '4', 'title' => '{"en":"Best Selling","ar":"الأكثر مبيعا"}', 'short_title' => NULL, 'description' => '{"ar":null}', 'status' => '1', 'order' => '4', 'type' => 'products', 'display_type' => 'carousel', 'grid_columns_count' => NULL, 'start_at' => NULL, 'end_at' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 15:22:23', 'updated_at' => '2022-08-10 15:25:57'),
                array('id' => '5', 'title' => '{"en":"Selected Products","ar":"منتجات مختارة"}', 'short_title' => NULL, 'description' => '{"ar":null}', 'status' => '1', 'order' => '5', 'type' => 'products', 'display_type' => 'carousel', 'grid_columns_count' => NULL, 'start_at' => NULL, 'end_at' => NULL, 'deleted_at' => NULL, 'created_at' => '2022-08-10 15:23:38', 'updated_at' => '2022-08-10 15:23:38')
            );

            $homables = array(
                array('id' => '1', 'app_home_id' => '1', 'homable_type' => 'Modules\\Advertising\\Entities\\AdvertisingGroup', 'homable_id' => '1', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '2', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '1', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '3', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '2', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '8', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '7', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '9', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '8', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '10', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '9', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '11', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '10', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '12', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '12', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '13', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '14', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '14', 'app_home_id' => '5', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '18', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '15', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '13', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '16', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '16', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '17', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '20', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL),
                array('id' => '18', 'app_home_id' => '4', 'homable_type' => 'Modules\\Catalog\\Entities\\Product', 'homable_id' => '24', 'status' => '1', 'created_at' => NULL, 'updated_at' => NULL)
            );

            DB::table('app_homes')->insert($app_homes);

            DB::table('homables')->insert($homables);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
