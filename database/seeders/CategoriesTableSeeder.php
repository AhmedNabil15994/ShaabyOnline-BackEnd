<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Entities\Category;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $count = Category::count();
        if ($count == 0) {
            DB::table('categories')->delete();

            $query = "
                INSERT INTO `categories` (`id`, `slug`, `title`, `seo_keywords`, `seo_description`, `image`, `cover`, `status`, `show_in_home`, `category_id`, `color`, `sort`, `deleted_at`, `created_at`, `updated_at`) VALUES
                (1, '{\"ar\":\"اكسسوارات-السيارات\",\"en\":\"car-accessories\"}', '{\"ar\":\"اكسسوارات السيارات\",\"en\":\"Car accessories\"}', '{\"ar\":null, \"en\":null}', '{\"ar\":null, \"en\":null}', 'uploads/categories/5f372d63353eb.jpg', NULL, 1, 0, NULL, '#000000', 6, NULL, '2020-10-07 21:12:16', '2022-03-14 21:19:28'),
                (2, '{\"en\":\"bouquets\",\"ar\":\"باقات\"}', '{\"en\":\"Bouquets\",\"ar\":\"باقات\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/622ded5163233.png', 'uploads/categories/default.png', 1, 0, NULL, '#000000', -7, NULL, '2022-03-09 08:41:59', '2022-03-13 16:08:36'),
                (3, '{\"en\":\"gifts\",\"ar\":\"هدايا\"}', '{\"en\":\"Gifts\",\"ar\":\"هدايا\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/622dfd47e038b.png', 'uploads/categories/default.png', 1, 0, NULL, '#000000', -9, NULL, '2022-03-10 21:42:56', '2022-03-13 16:19:17'),
                (4, '{\"en\":\"dolls-soft-plush\",\"ar\":\"الدمى-والقطيفة-الناعمة\"}', '{\"en\":\"Dolls & Soft Plush\",\"ar\":\"الدمى والقطيفة الناعمة\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/624dccc4019ca.png', 'uploads/categories/default.png', 1, 1, NULL, '#000000', 11, NULL, '2022-03-20 00:05:17', '2022-04-06 18:42:41'),
                (5, '{\"en\":\"girls-toys\",\"ar\":\"العاب-بنات\"}', '{\"en\":\"Girls Toys\",\"ar\":\"العاب بنات\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/624dfcdc508d4.png', 'uploads/categories/default.png', 1, 1, NULL, '#000000', 17, NULL, '2022-03-20 00:10:15', '2022-04-06 21:50:50'),
                (6, '{\"en\":\"graduating\",\"ar\":\"تخرج\"}', '{\"en\":\"graduating\",\"ar\":\"مبروك التخرج\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/629506982d129.png', 'uploads/categories/default.png', 1, 0, NULL, '#000000', -11, NULL, '2022-05-30 18:55:40', '2022-05-30 19:02:19'),
                (7, '{\"en\":\"business-books\",\"ar\":\"كتب-الاعمال\"}', '{\"en\":\"business books\",\"ar\":\"كتب الاعمال\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/b4b060c8a41.jpg', 'uploads/categories/default.png', 1, 0, NULL, '#000000', 0, NULL, '2022-06-23 21:26:49', '2022-06-23 21:26:49'),
                (8, '{\"en\":\"autobiographical-books\",\"ar\":\"كتب-سيرة\"}', '{\"en\":\"autobiographical books\",\"ar\":\"كتب سيرة\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/b4b0e7695d3.jpg', 'uploads/categories/default.png', 1, 0, NULL, '#000000', 0, NULL, '2022-06-23 21:29:01', '2022-06-23 21:29:01'),
                (9, '{\"en\":\"novels\",\"ar\":\"روايات\"}', '{\"en\":\"Novels\",\"ar\":\"روايات\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/62b4b24989183.jpeg', 'uploads/categories/default.png', 1, 0, NULL, '#000000', 0, NULL, '2022-06-23 21:34:55', '2022-06-23 21:34:55'),
                (10, '{\"en\":\"poetry-and-literature\",\"ar\":\"شعر-وادب\"}', '{\"en\":\"poetry and literature\",\"ar\":\"شعر وادب\"}', '{\"ar\":null}', '{\"ar\":null}', 'uploads/categories/b4b2ca2b7fa.jpg', 'uploads/categories/default.png', 1, 0, NULL, '#000000', 0, NULL, '2022-06-23 21:37:06', '2022-06-23 21:37:06');
            ";

            $this->insert($query);
        }
    }

    public function insert($string)
    {
        DB::statement($string);
    }
}
