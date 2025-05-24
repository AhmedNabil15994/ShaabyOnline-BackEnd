<?php

use Illuminate\Database\Seeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductRelatedEntitiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DashboardSeeder::class,
            CategoriesTableSeeder::class,
            TagsSeeder::class,
            ProductSeeder::class,
            ProductRelatedEntitiesSeeder::class,
            SliderSeeder::class,
        ]);
    }
}
