<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorsTableSeeder extends Seeder
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

            DB::table('vendors')->delete();

            $query = "
            INSERT INTO `vendors` (`id`, `slug`, `title`, `image`, `sorting`, `status`, `vendor_email`, `vendor_status_id`, `section_id`, `delivery_time_types`, `direct_delivery_message`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1, '{\"ar\":\"متجر-شعبى-اون-لاين\",\"en\":\"shaaby-online-vendor\"}', '{\"ar\":\"\متجر شعبى اون لاين\",\"en\":\"Shaaby Online Vendor\"}', 'uploads/vendors/default.png', 1, 1, 'shaaby_vendor@example.com', 1, 1, '[\"direct\"]', '{\"en\":\"Delivery within a day\",\"ar\":\"التوصيل خلال يوم\"}', Null, '2020-08-14 09:13:48', '2022-04-27 00:12:26'),
            (2, '{\"en\":\"blankets\",\"ar\":\"البطانيات\"}', '{\"en\":\"Blankets\",\"ar\":\"البطانيات\"}', 'uploads/vendors/WQTstcj6XO1Lb8JfXRJ8ByFK4HanrNhyktlfJ7m2.jpg', 2, 1, 'zblankets.z@example.com', 1, 1, '[\"direct\"]', '{\"en\":\"Delivery within a day\",\"ar\":\"التوصيل خلال يوم\"}', Null, '2022-03-13 13:17:58', '2022-06-24 21:26:10'),
            (3, '{\"en\":\"peonita\",\"ar\":\"بيونيتا\"}', '{\"en\":\"Peonita\",\"ar\":\"بيونيتا\"}', 'uploads/vendors/mrtZfGDxNAHnVDdT9phd2YE75SnEukvTidJ4EJuf.jpg', 3, 1, 'abrar.alshwaIKI@example.com', 1, 1, '[\"direct\"]', '{\"en\":\"Delivery within a day\",\"ar\":\"التوصيل خلال يوم\"}', Null, '2022-03-13 22:02:05', '2022-06-24 21:24:30'),
            (4, '{\"en\":\"DAR-KALEMAT\",\"ar\":\"دار-كلمات\"}', '{\"en\":\"DAR KALEMAT\",\"ar\":\"دار كلمات\"}', 'uploads/vendors/GjDh44pJqqyyLFwQebLfLpHxBUAa30xPgIs95p78.jpg', 4, 1, 'dar_kalemat@example.com', 1, 1, '[\"direct\"]', '{\"en\":\"Delivery within a day\",\"ar\":\"التوصيل خلال يوم\"}', Null, '2022-03-13 22:02:05', '2022-06-24 21:24:30')
        ";

            $this->insert($query);

            $tagFilePath = 'sql/vendor-categories.sql';
            $this->executeSqlFile($tagFilePath);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function insert($string)
    {
        DB::statement($string);
    }

    public function executeSqlFile($filePath)
    {
        $path = public_path($filePath);
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
