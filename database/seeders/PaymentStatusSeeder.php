<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Order\Entities\PaymentStatus;

class PaymentStatusSeeder extends Seeder
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
            $items = [
                ['flag' => 'pending'],
                ['flag' => 'success'],
                ['flag' => 'failed'],
                ['flag' => 'cash'],
            ];
            foreach ($items as $k => $status) {
                PaymentStatus::create($status);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
