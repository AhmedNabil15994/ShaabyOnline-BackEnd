<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\Category;
use Modules\Tags\Entities\Tag;
use Faker\Factory;
use Illuminate\Support\Str;

class ProductSeederOld extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {

            $faker = Factory::create();
            $faker_ar = Factory::create('ar_SA');
            $count = Product::count();

            if ($count == 0) {
                for ($i = 1; $i <= 20; $i++) {

                    $title = [
                        'ar' => $faker_ar->sentence(4),
                        'en' => $faker->sentence(4),
                    ];
                    $short_description = [
                        'ar' => $faker_ar->paragraph(20),
                        'en' => $faker->paragraph(20),
                    ];
                    $description = [
                        'ar' => $faker_ar->paragraph(40),
                        'en' => $faker->paragraph(40),
                    ];

                    $p = Product::create([
                        'price' => rand(20, 150),
                        'sku' => Str::upper(Str::random(6)),
                        'qty' => rand(1000, 1500),
                        'image' => path_without_domain(url('storage/photos/shares/test_products/' . $i . '.jpg')),
                        'vendor_id' => \Modules\Vendor\Entities\Vendor::inRandomOrder()->first()->id,
                        'status' => 1,
                        'featured' => rand(0, 1),
                        'pending_for_approval' => true,
                        "title" => $title,
                        "short_description" => $short_description,
                        "description" => $description
                    ]);


                    $p->save();

                    $p->categories()->attach(Category::inRandomOrder()->mainCategories()->first()->id);
                    $p->tags()->attach(Tag::inRandomOrder()->take(2)->pluck('id')->toArray());

                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}
