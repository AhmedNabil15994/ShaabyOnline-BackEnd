<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        // try {

            DB::table('companies')->delete();
            DB::table('companies')->insert(array(
                0 =>
                array(
                    'id' => 1,
                    'slug' => '{"ar": "شركة-شحن-افتراضية", "en": "default-shipping-company"}',
                    'description' => '{"ar": "<p>شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية شركة شحن افتراضية&nbsp;</p>", "en": "<p>Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company Default Shipping Company&nbsp;</p>"}',
                    'name' => '{"ar": "شركة شحن افتراضية", "en": "Default Shipping Company"}',
                    'manager_name' => NULL,
                    'status' => 1,
                    'image' => 'storage/photos/shares/shipping_companies/default.jpg',
                    'email' => NULL,
                    'password' => NULL,
                    'calling_code' => NULL,
                    'mobile' => NULL,
                    'delivery_time_types' => '["direct"]',
                    'direct_delivery_message' => '{"en":"Delivery within a day","ar":"التوصيل خلال يوم"}',
                    'deleted_at' => NULL,
                    'created_at' => '2020-12-02 13:08:24',
                    'updated_at' => '2021-09-06 20:57:26',
                ),
            ));

            $query = "
                INSERT INTO `delivery_charges` (`id`, `delivery`, `delivery_time`, `status`, `min_order_amount`, `state_id`, `company_id`, `created_at`, `updated_at`) VALUES
                (1, '4.000', 10, 1, NULL, 75, 1, '2022-07-05 12:19:04', '2022-07-05 12:19:04'),
                (2, '3.500', 8, 1, NULL, 76, 1, '2022-07-05 12:19:04', '2022-07-05 12:19:04'),
                (3, '5.000', 15, 1, NULL, 78, 1, '2022-07-05 12:19:04', '2022-07-05 12:19:04'),
                (4, '4.500', 12, 1, NULL, 85, 1, '2022-07-05 12:19:04', '2022-07-05 12:19:04');
            ";

            $this->insert($query);

            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     throw $e;
        // }
    }

    public function insert($string)
    {
        DB::statement($string);
    }
}
