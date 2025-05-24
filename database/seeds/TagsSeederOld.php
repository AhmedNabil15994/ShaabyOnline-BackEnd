<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tags\Entities\Tag;

class TagsSeederOld extends Seeder
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
            $all = [
                [
                    'status' => 1,
                    'title' => [
                        'ar' => 'زواج',
                        'en' => 'Wedding',
                    ],
                ],
                [
                    'status' => 1,
                    'title' => [
                        'ar' => 'عيد ميلاد',
                        'en' => 'Birth Day',
                    ],
                ],
                [
                    'status' => 1,
                    'title' => [
                        'ar' => 'تخرج',
                        'en' => 'Graduation',
                    ],
                ],
                [
                    'status' => 1,
                    'title' => [
                        'ar' => 'خطوبة',
                        'en' => 'Engagement',
                    ],
                ],
                [
                    'status' => 1,
                    'title' => [
                        'ar' => 'حفلة',
                        'en' => 'Party',
                    ],
                ],
            ];

            $count = Tag::count();

            if ($count == 0) {
                foreach ($all as $k => $tag) {
                    $t = Tag::create($tag);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
