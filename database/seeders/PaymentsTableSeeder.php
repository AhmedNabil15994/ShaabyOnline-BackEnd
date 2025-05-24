<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payments')->delete();
        
        \DB::table('payments')->insert(array (
            0 => 
            array (
                'id' => 2,
                'title' => '{"ar": "الدفع اون لاين", "en": "Online"}',
                'image' => 'storage/photos/shares/payments/5ed007004f643.png',
                'code' => 'online',
                'created_at' => '2020-06-14 18:36:55',
                'updated_at' => '2021-09-06 20:17:22',
            ),
            1 => 
            array (
                'id' => 3,
                'title' => '{"ar": "الدفع عند الإستلام", "en": "Cash On Delivery"}',
                'image' => 'storage/photos/shares/payments/5ee689939cac1.jpg',
                'code' => 'cash',
                'created_at' => '2020-06-14 18:37:35',
                'updated_at' => '2021-09-06 20:17:22',
            ),
        ));
        
        
    }
}