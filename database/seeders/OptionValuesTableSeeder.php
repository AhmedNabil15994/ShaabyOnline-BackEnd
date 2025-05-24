<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OptionValuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('option_values')->delete();
        
        \DB::table('option_values')->insert(array (
            0 => 
            array (
                'id' => 130,
                'title' => '{"ar": "احمر", "en": "Red"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:18',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            1 => 
            array (
                'id' => 131,
                'title' => '{"ar": "ازرق", "en": "Blue"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:18',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            2 => 
            array (
                'id' => 132,
                'title' => '{"ar": "اسود", "en": "Black"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:18',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            3 => 
            array (
                'id' => 133,
                'title' => '{"ar": "صغير", "en": "Small"}',
                'status' => 1,
                'option_id' => 16,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:49',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            4 => 
            array (
                'id' => 134,
                'title' => '{"ar": "وسط", "en": "Medium"}',
                'status' => 1,
                'option_id' => 16,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:49',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            5 => 
            array (
                'id' => 135,
                'title' => '{"ar": "كبير", "en": "Large"}',
                'status' => 1,
                'option_id' => 16,
                'deleted_at' => NULL,
                'created_at' => '2020-03-08 12:06:49',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            6 => 
            array (
                'id' => 136,
                'title' => '{"ar": "12*10", "en": "12*10"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-02 21:00:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            7 => 
            array (
                'id' => 137,
                'title' => '{"ar": "16*12", "en": "16*12"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-02 21:00:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            8 => 
            array (
                'id' => 138,
                'title' => '{"ar": "10*7", "en": "10*7"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-02 21:00:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            9 => 
            array (
                'id' => 139,
                'title' => '{"ar": "ازرق", "en": "Blue"}',
                'status' => 1,
                'option_id' => 18,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 04:50:29',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            10 => 
            array (
                'id' => 140,
                'title' => '{"ar": "اخضر", "en": "Green"}',
                'status' => 1,
                'option_id' => 18,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 04:50:29',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            11 => 
            array (
                'id' => 141,
                'title' => '{"ar": "احمر", "en": "Red"}',
                'status' => 1,
                'option_id' => 18,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 04:50:29',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            12 => 
            array (
                'id' => 142,
                'title' => '{"ar": "اسود", "en": "Black"}',
                'status' => 1,
                'option_id' => 18,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 04:50:29',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            13 => 
            array (
                'id' => 143,
                'title' => '{"ar": "٢٠ سم", "en": "20 cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 05:18:26',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            14 => 
            array (
                'id' => 144,
                'title' => '{"ar": "٣٠ سم", "en": "30 cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 05:18:26',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            15 => 
            array (
                'id' => 145,
                'title' => '{"ar": "صغير", "en": "Small"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 22:05:45',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            16 => 
            array (
                'id' => 146,
                'title' => '{"ar": "وسط", "en": "Medium"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 22:05:45',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            17 => 
            array (
                'id' => 147,
                'title' => '{"ar": "كبير", "en": "Large"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-05 22:05:45',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            18 => 
            array (
                'id' => 148,
                'title' => '{"ar": "76mmx50mm", "en": "76mmx50mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 00:53:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            19 => 
            array (
                'id' => 149,
                'title' => '{"ar": "76mmx76mm", "en": "76mmx76mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 00:53:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            20 => 
            array (
                'id' => 150,
                'title' => '{"ar": "وردي", "en": "Pink"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:06:07',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            21 => 
            array (
                'id' => 151,
                'title' => '{"ar": "تصميم ١", "en": "Design 1"}',
                'status' => 0,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 19:21:29',
            ),
            22 => 
            array (
                'id' => 152,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            23 => 
            array (
                'id' => 153,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            24 => 
            array (
                'id' => 154,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            25 => 
            array (
                'id' => 155,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            26 => 
            array (
                'id' => 156,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            27 => 
            array (
                'id' => 157,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            28 => 
            array (
                'id' => 158,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            29 => 
            array (
                'id' => 159,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:31:55',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            30 => 
            array (
                'id' => 160,
                'title' => '{"ar": "١٥ سم", "en": "15 cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-21 01:41:15',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            31 => 
            array (
                'id' => 165,
                'title' => '{"ar": "25.4cm x 17.7cm", "en": "25.4cm x 17.7cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-26 20:55:44',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            32 => 
            array (
                'id' => 166,
                'title' => '{"ar": "40.6cm x 30.4cm", "en": "40.6cm x 30.4cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-26 20:55:44',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            33 => 
            array (
                'id' => 167,
                'title' => '{"ar": "30.4 cm x 25.4 cm", "en": "30.4 cm x 25.4 cm"}',
                'status' => 1,
                'option_id' => 19,
                'deleted_at' => NULL,
                'created_at' => '2020-05-26 20:55:44',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            34 => 
            array (
                'id' => 168,
                'title' => '{"ar": "ازرق", "en": "Blue"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => '2020-05-29 20:18:48',
                'created_at' => '2020-05-29 19:54:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            35 => 
            array (
                'id' => 169,
                'title' => '{"ar": "اصفر", "en": "Yellow"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 19:54:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            36 => 
            array (
                'id' => 170,
                'title' => '{"ar": "بنفسجي", "en": "Purple"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 19:54:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            37 => 
            array (
                'id' => 171,
                'title' => '{"ar": "اخضر", "en": "Green"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 19:54:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            38 => 
            array (
                'id' => 172,
                'title' => '{"ar": "وردي فاتح", "en": "Baby Pink"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 20:18:48',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            39 => 
            array (
                'id' => 173,
                'title' => '{"ar": "كحلي", "en": "Dark Blue"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 20:18:48',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            40 => 
            array (
                'id' => 174,
                'title' => '{"ar": "برتقالي", "en": "Orange"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => '2020-05-29 21:21:11',
                'created_at' => '2020-05-29 21:21:06',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            41 => 
            array (
                'id' => 175,
                'title' => '{"ar": "بيج", "en": "Beige"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => '2020-05-29 21:21:11',
                'created_at' => '2020-05-29 21:21:06',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            42 => 
            array (
                'id' => 176,
                'title' => '{"ar": "برتقالي", "en": "Orange"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 21:21:11',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            43 => 
            array (
                'id' => 177,
                'title' => '{"ar": "بيج", "en": "Beige"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-05-29 21:21:11',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            44 => 
            array (
                'id' => 178,
                'title' => '{"ar": "ملون", "en": "colors"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => '2020-06-10 10:08:04',
                'created_at' => '2020-06-10 10:07:40',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            45 => 
            array (
                'id' => 179,
                'title' => '{"ar": "ملون", "en": "colors"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-06-10 10:08:04',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            46 => 
            array (
                'id' => 180,
                'title' => '{"ar": "ابيض", "en": "white"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-06-10 10:16:13',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            47 => 
            array (
                'id' => 181,
                'title' => '{"ar": "A4", "en": "A4"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-17 11:41:11',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            48 => 
            array (
                'id' => 182,
                'title' => '{"ar": "FS", "en": "FS"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-17 11:41:11',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            49 => 
            array (
                'id' => 183,
                'title' => '{"ar": "رمادي غامج", "en": "Dark Grey"}',
                'status' => 1,
                'option_id' => 15,
                'deleted_at' => NULL,
                'created_at' => '2020-06-20 11:46:28',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            50 => 
            array (
                'id' => 184,
                'title' => '{"ar": "45x90", "en": "45x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:14:47',
                'created_at' => '2020-06-21 21:14:43',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            51 => 
            array (
                'id' => 185,
                'title' => '{"ar": "50x100", "en": "50x100"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:14:47',
                'created_at' => '2020-06-21 21:14:43',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            52 => 
            array (
                'id' => 186,
                'title' => '{"ar": "45x90", "en": "45x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:15:25',
                'created_at' => '2020-06-21 21:14:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            53 => 
            array (
                'id' => 187,
                'title' => '{"ar": "50x100", "en": "50x100"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:15:25',
                'created_at' => '2020-06-21 21:14:47',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            54 => 
            array (
                'id' => 188,
                'title' => '{"ar": "45x90", "en": "45x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:39:37',
                'created_at' => '2020-06-21 21:15:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            55 => 
            array (
                'id' => 189,
                'title' => '{"ar": "50x100", "en": "50x100"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:39:37',
                'created_at' => '2020-06-21 21:15:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            56 => 
            array (
                'id' => 190,
                'title' => '{"ar": "37x75", "en": "37x75"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:39:37',
                'created_at' => '2020-06-21 21:15:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            57 => 
            array (
                'id' => 191,
                'title' => '{"ar": "50x90", "en": "50x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:39:37',
                'created_at' => '2020-06-21 21:15:25',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            58 => 
            array (
                'id' => 192,
                'title' => '{"ar": "45x90", "en": "45x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:40:57',
                'created_at' => '2020-06-21 21:39:37',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            59 => 
            array (
                'id' => 193,
                'title' => '{"ar": "50x100", "en": "50x100"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:40:57',
                'created_at' => '2020-06-21 21:39:37',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            60 => 
            array (
                'id' => 194,
                'title' => '{"ar": "37x75", "en": "37x75"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:40:57',
                'created_at' => '2020-06-21 21:39:37',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            61 => 
            array (
                'id' => 195,
                'title' => '{"ar": "50x90", "en": "50x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:40:57',
                'created_at' => '2020-06-21 21:39:37',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            62 => 
            array (
                'id' => 196,
                'title' => '{"ar": "Size A4 10mm", "en": "Size A4 10mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => '2020-06-21 21:40:57',
                'created_at' => '2020-06-21 21:39:37',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            63 => 
            array (
                'id' => 197,
                'title' => '{"ar": "45x90", "en": "45x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            64 => 
            array (
                'id' => 198,
                'title' => '{"ar": "50x100", "en": "50x100"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            65 => 
            array (
                'id' => 199,
                'title' => '{"ar": "37x75", "en": "37x75"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            66 => 
            array (
                'id' => 200,
                'title' => '{"ar": "50x90", "en": "50x90"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            67 => 
            array (
                'id' => 201,
                'title' => '{"ar": "10mm", "en": "10 mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            68 => 
            array (
                'id' => 202,
                'title' => '{"ar": "38 mm", "en": "38 mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            69 => 
            array (
                'id' => 203,
                'title' => '{"ar": "32 mm", "en": "32 mm"}',
                'status' => 1,
                'option_id' => 17,
                'deleted_at' => NULL,
                'created_at' => '2020-06-21 21:40:57',
                'updated_at' => '2021-09-07 18:22:16',
            ),
            70 => 
            array (
                'id' => 213,
                'title' => '{"ar": "تصميم ١", "en": "Design 1"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            71 => 
            array (
                'id' => 214,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            72 => 
            array (
                'id' => 215,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            73 => 
            array (
                'id' => 216,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            74 => 
            array (
                'id' => 217,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            75 => 
            array (
                'id' => 218,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            76 => 
            array (
                'id' => 219,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            77 => 
            array (
                'id' => 220,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            78 => 
            array (
                'id' => 221,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:13:00',
                'created_at' => '2021-09-07 19:12:37',
                'updated_at' => '2021-09-07 19:13:00',
            ),
            79 => 
            array (
                'id' => 222,
                'title' => '{"ar": "تصميم ١", "en": "Design 1 u"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            80 => 
            array (
                'id' => 223,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            81 => 
            array (
                'id' => 224,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            82 => 
            array (
                'id' => 225,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            83 => 
            array (
                'id' => 226,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            84 => 
            array (
                'id' => 227,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            85 => 
            array (
                'id' => 228,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            86 => 
            array (
                'id' => 229,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            87 => 
            array (
                'id' => 230,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:00',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            88 => 
            array (
                'id' => 231,
                'title' => '{"ar": "تصميم ١", "en": "Design 1  uodate"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            89 => 
            array (
                'id' => 232,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            90 => 
            array (
                'id' => 233,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            91 => 
            array (
                'id' => 234,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            92 => 
            array (
                'id' => 235,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            93 => 
            array (
                'id' => 236,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            94 => 
            array (
                'id' => 237,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            95 => 
            array (
                'id' => 238,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            96 => 
            array (
                'id' => 239,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            97 => 
            array (
                'id' => 240,
                'title' => '{"ar": "تصميم ١", "en": "Design 1 u"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            98 => 
            array (
                'id' => 241,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            99 => 
            array (
                'id' => 242,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            100 => 
            array (
                'id' => 243,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            101 => 
            array (
                'id' => 244,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            102 => 
            array (
                'id' => 245,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            103 => 
            array (
                'id' => 246,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            104 => 
            array (
                'id' => 247,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            105 => 
            array (
                'id' => 248,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:22',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            106 => 
            array (
                'id' => 249,
                'title' => '{"ar": "تصميم ١ dfas", "en": "Design 1"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            107 => 
            array (
                'id' => 250,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            108 => 
            array (
                'id' => 251,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            109 => 
            array (
                'id' => 252,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            110 => 
            array (
                'id' => 253,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            111 => 
            array (
                'id' => 254,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            112 => 
            array (
                'id' => 255,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            113 => 
            array (
                'id' => 256,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            114 => 
            array (
                'id' => 257,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            115 => 
            array (
                'id' => 258,
                'title' => '{"ar": "تصميم ١", "en": "Design 1 u"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            116 => 
            array (
                'id' => 259,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            117 => 
            array (
                'id' => 260,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            118 => 
            array (
                'id' => 261,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            119 => 
            array (
                'id' => 262,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            120 => 
            array (
                'id' => 263,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            121 => 
            array (
                'id' => 264,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            122 => 
            array (
                'id' => 265,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            123 => 
            array (
                'id' => 266,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            124 => 
            array (
                'id' => 267,
                'title' => '{"ar": "تصميم ١", "en": "Design 1  uodate"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            125 => 
            array (
                'id' => 268,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            126 => 
            array (
                'id' => 269,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            127 => 
            array (
                'id' => 270,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            128 => 
            array (
                'id' => 271,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            129 => 
            array (
                'id' => 272,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            130 => 
            array (
                'id' => 273,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            131 => 
            array (
                'id' => 274,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            132 => 
            array (
                'id' => 275,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            133 => 
            array (
                'id' => 276,
                'title' => '{"ar": "تصميم ١", "en": "Design 1 u"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            134 => 
            array (
                'id' => 277,
                'title' => '{"ar": "تصميم ٢", "en": "Design 2"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            135 => 
            array (
                'id' => 278,
                'title' => '{"ar": "تصميم ٣", "en": "Design 3"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            136 => 
            array (
                'id' => 279,
                'title' => '{"ar": "تصميم ٤", "en": "Design 4"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            137 => 
            array (
                'id' => 280,
                'title' => '{"ar": "تصميم ٥", "en": "Design 5"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            138 => 
            array (
                'id' => 281,
                'title' => '{"ar": "تصميم ٦", "en": "Design 6"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            139 => 
            array (
                'id' => 282,
                'title' => '{"ar": "تصميم ٧", "en": "Design 7"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            140 => 
            array (
                'id' => 283,
                'title' => '{"ar": "تصميم ٨", "en": "Design 8"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            141 => 
            array (
                'id' => 284,
                'title' => '{"ar": "تصميم ٩", "en": "Design 9"}',
                'status' => 1,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:20:56',
                'created_at' => '2021-09-07 19:13:44',
                'updated_at' => '2021-09-07 19:20:56',
            ),
            142 => 
            array (
                'id' => 285,
                'title' => '{"ar": "تصميم ١ dssa", "en": "Design 1ddsa"}',
                'status' => 0,
                'option_id' => 20,
                'deleted_at' => '2021-09-07 19:17:07',
                'created_at' => '2021-09-07 19:15:30',
                'updated_at' => '2021-09-07 19:17:07',
            ),
        ));
        
        
    }
}