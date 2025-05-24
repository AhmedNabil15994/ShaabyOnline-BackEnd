<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductRelatedEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('max_execution_time', 300); //5 minutes
        DB::beginTransaction();
        try {

            /* $imagesFilePath = 'sql/related-products/product_images.sql';
            $this->executeSqlFile($imagesFilePath); */

            $tagFilePath = 'sql/related-products/product_tags.sql';
            $this->executeSqlFile($tagFilePath);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function executeSqlFile($filePath)
    {
        $path = public_path($filePath);
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
