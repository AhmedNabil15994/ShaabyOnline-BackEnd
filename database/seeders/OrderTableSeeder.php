<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderTableSeeder extends Seeder
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
            $orderQuery = "
                INSERT INTO `orders` (`id`, `unread`, `increment_qty`, `original_subtotal`, `subtotal`, `off`, `shipping`, `total`, `total_profit`, `user_id`, `user_token`, `order_status_id`, `payment_status_id`, `notes`, `order_notes`, `deleted_at`, `created_at`, `updated_at`) VALUES
                (1, 0, NULL, '8.000', '8.000', '0.000', '4.500', '12.500', '0.000', 4, NULL, 7, 4, NULL, NULL, NULL, '2022-07-05 13:13:39', '2022-07-05 13:13:39');
                ";
            $this->insert($orderQuery);

            $addressQuery = "
                INSERT INTO `order_addresses` (`id`, `email`, `civil_id`, `username`, `mobile`, `block`, `street`, `building`, `address`, `state_id`, `order_id`, `avenue`, `floor`, `flat`, `automated_number`, `created_at`, `updated_at`) VALUES
                (1, 'user1@example.com', NULL, 'Omar Mahmoud', '96512345678', '546', 'Omar bin al-khattab', '789', 'Building 12 - Fourth Floor - Apartment 4', 85, 1, 'test aventue', 'test floor', 'test flat', 'test automated number', '2022-07-05 13:13:39', '2022-07-05 13:13:39');
            ";
            $this->insert($addressQuery);

            $orderProducts = "
                INSERT INTO `order_products` (`id`, `sale_price`, `price`, `off`, `qty`, `total`, `original_total`, `total_profit`, `notes`, `add_ons_option_ids`, `product_id`, `order_id`, `created_at`, `updated_at`) VALUES
                (1, '4.000', '4.000', '0.000', 1, '4.000', '4.000', '0.000', NULL, NULL, 16, 1, '2022-07-05 13:13:39', '2022-07-05 13:13:39'),
                (2, '4.000', '4.000', '0.000', 1, '4.000', '4.000', '0.000', NULL, NULL, 10, 1, '2022-07-05 13:13:39', '2022-07-05 13:13:39');
            ";
            $this->insert($orderProducts);

            $orderHistory = "
                INSERT INTO `order_statuses_history` (`id`, `order_id`, `order_status_id`, `user_id`, `created_at`, `updated_at`) VALUES
                (1, 1, 7, 4, '2022-07-05 13:13:39', '2022-07-05 13:13:39');
            ";
            $this->insert($orderHistory);

            $orderVendors = "
                INSERT INTO `order_vendors` (`id`, `order_id`, `vendor_id`, `total_comission`, `total_profit_comission`, `original_subtotal`, `subtotal`, `qty`, `created_at`, `updated_at`) VALUES
                (1, 1, 4, NULL, NULL, '8.000', '8.000', 2, NULL, NULL);
            ";
            $this->insert($orderVendors);

            $orderCompanies = "
                INSERT INTO `order_companies` (`id`, `order_id`, `vendor_id`, `company_id`, `availabilities`, `delivery`) VALUES
                (1, 1, NULL, 1, NULL, '4.5');
            ";
            $this->insert($orderCompanies);

            $orderTransaction = "
                INSERT INTO `transactions` (`id`, `method`, `payment_id`, `tran_id`, `result`, `post_date`, `ref`, `track_id`, `auth`, `transaction_type`, `transaction_id`, `created_at`, `updated_at`) VALUES
                (1, 'cash', NULL, NULL, 'CASH', NULL, NULL, NULL, NULL, 'Modules\\\Order\\\Entities\\\Order', 1, '2022-07-05 13:13:39', '2022-07-05 13:13:39');
            ";
            $this->insert($orderTransaction);

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
}
