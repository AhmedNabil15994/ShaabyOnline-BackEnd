<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tags\Entities\Tag;

class TagsSeeder extends Seeder
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
            $count = Tag::count();
            if ($count == 0) {
                $path = public_path('sql/related-products/tags.sql');
                $sql = file_get_contents($path);
                DB::unprepared($sql);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
