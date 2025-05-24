<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Category;
use Modules\Tags\Entities\Tag;
use Faker\Factory;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('max_execution_time', 180); //3 minutes
        DB::beginTransaction();
        try {

            $count = Product::count();

            if ($count == 0) {
                $path = public_path('sql/products-1.sql');
                $sql = file_get_contents($path);
                DB::unprepared($sql);

                /* $path2 = public_path('sql/products-2.sql');
                $sql2 = file_get_contents($path2);
                DB::unprepared($sql2); */

                /* $path3 = public_path('sql/products-3.sql');
                $sql3 = file_get_contents($path3);
                DB::unprepared($sql3); */

                $path4 = public_path('sql/product-categories.sql');
                $sql4 = file_get_contents($path4);
                DB::unprepared($sql4);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
