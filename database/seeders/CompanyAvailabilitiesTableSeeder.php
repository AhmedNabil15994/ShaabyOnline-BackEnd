<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyAvailabilitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('company_availabilities')->delete();
        
        \DB::table('company_availabilities')->insert(array (
            0 => 
            array (
                'id' => 1,
                'company_id' => 1,
                'day_code' => 'sun',
                'status' => 1,
                'is_full_day' => 1,
                'custom_times' => NULL,
                'created_at' => '2020-12-02 13:08:24',
                'updated_at' => '2021-09-06 20:57:26',
            ),
            1 => 
            array (
                'id' => 2,
                'company_id' => 1,
                'day_code' => 'mon',
                'status' => 1,
                'is_full_day' => 1,
                'custom_times' => NULL,
                'created_at' => '2020-12-02 13:08:24',
                'updated_at' => '2021-09-06 20:57:26',
            ),
            2 => 
            array (
                'id' => 3,
                'company_id' => 1,
                'day_code' => 'tue',
                'status' => 1,
                'is_full_day' => 1,
                'custom_times' => NULL,
                'created_at' => '2020-12-02 13:08:24',
                'updated_at' => '2021-09-06 20:57:26',
            ),
            3 => 
            array (
                'id' => 4,
                'company_id' => 1,
                'day_code' => 'wed',
                'status' => 1,
                'is_full_day' => 1,
                'custom_times' => NULL,
                'created_at' => '2020-12-02 13:08:24',
                'updated_at' => '2021-09-06 20:57:26',
            ),
            4 => 
            array (
                'id' => 5,
                'company_id' => 1,
                'day_code' => 'thu',
                'status' => 1,
                'is_full_day' => 1,
                'custom_times' => NULL,
                'created_at' => '2020-12-02 13:08:24',
                'updated_at' => '2021-09-06 20:57:26',
            ),
        ));
        
        
    }
}