<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\OrderStatus;

class OrderStatusSeeder extends Seeder
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
                    'flag' => 'pending',
                    'color_label' => json_encode(["text" => "danger", "value" => "#f8d7da"]),
                    'color' => '#FFC219',
                    'is_success' => 0,
                    'title' => [
                        'ar' => 'جارى الإنتظار',
                        'en' => 'Pending order',
                    ],
                ],
                [
                    'flag' => 'refund',
                    'color_label' => json_encode(["text" => "danger", "value" => "#F8D7DA"]),
                    'color' => '#D30000',
                    'is_success' => 0,
                    'title' => [
                        'ar' => 'تم إسترجاع الطلب',
                        'en' => 'Refunded order',
                    ],
                ],
                [
                    'flag' => 'processing',
                    'color_label' => json_encode(["text" => "danger", "value" => "#D4EDDA"]),
                    'color' => '#FFC219',
                    'is_success' => 0,
                    'title' => [
                        'ar' => 'جارى تجهيز الطلب',
                        'en' => 'Order processing',
                    ],
                ],
                [
                    'flag' => 'failed',
                    'color_label' => json_encode(["text" => "danger", "value" => "#F8D7DA"]),
                    'color' => '#D30000',
                    'is_success' => 0,
                    'title' => [
                        'ar' => 'فشلت محاولة الطلب',
                        'en' => 'Failed order',
                    ],
                ],
                [
                    'flag' => 'delivered',
                    'color_label' => json_encode(["text" => "success", "value" => "#D4EDDA"]),
                    'color' => '#4u7FD400',
                    'is_success' => 1,
                    'title' => [
                        'ar' => 'تم توصيل الطلب',
                        'en' => 'Order delivered',
                    ],
                    'sort' => '1',
                ],
                [
                    'flag' => 'received',
                    'color_label' => json_encode(["text" => "success", "value" => "#F8D7DA"]),
                    'color' => '#FFC219',
                    'is_success' => 1,
                    'title' => [
                        'ar' => 'تم إستلام الطلب',
                        'en' => 'Order received',
                    ],
                ],
                [
                    'flag' => 'new_order',
                    'color_label' => json_encode(["text" => "success", "value" => "#D4EDDA"]),
                    'color' => '#FFC219',
                    'is_success' => 1,
                    'title' => [
                        'ar' => 'طلب جديد',
                        'en' => 'New Order',
                    ],
                    'sort' => '2',
                ],
                [
                    'flag' => 'is_ready',
                    'color_label' => json_encode(["text" => "danger", "value" => "#D4EDDA"]),
                    'color' => '#FFC219',
                    'is_success' => 1,
                    'title' => [
                        'ar' => 'الطلب جاهز',
                        'en' => 'Order is ready',
                    ],
                ],
                [
                    'flag' => 'on_the_way',
                    'color_label' => json_encode(["text" => "danger", "value" => "#D4EDDA"]),
                    'color' => '#FFC219',
                    'is_success' => 1,
                    'title' => [
                        'ar' => 'جارى توصيل الطلب',
                        'en' => 'Order on the way',
                    ],
                ],
            ];

            foreach ($all as $k => $status) {
                $s = OrderStatus::create($status);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
