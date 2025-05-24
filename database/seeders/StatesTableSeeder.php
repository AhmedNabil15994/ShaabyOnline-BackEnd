<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('states')->delete();
        
        \DB::table('states')->insert(array (
            0 => 
            array (
                'id' => 4,
                'slug' => '{"ar": "الخالدية", "en": "khaldiya"}',
                'title' => '{"ar": "الخالدية", "en": "khaldiya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:05:38',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            1 => 
            array (
                'id' => 5,
                'slug' => '{"ar": "الدسمة", "en": "al-dasma"}',
                'title' => '{"ar": "الدسمة", "en": "al dasma"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:06:15',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            2 => 
            array (
                'id' => 6,
                'slug' => '{"ar": "الدعية", "en": "al-daiya"}',
                'title' => '{"ar": "الدعية", "en": "al daiya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:06:53',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            3 => 
            array (
                'id' => 7,
                'slug' => '{"ar": "الدوحة", "en": "doha"}',
                'title' => '{"ar": "الدوحة", "en": "Doha"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:07:24',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            4 => 
            array (
                'id' => 8,
                'slug' => '{"ar": "الروضة", "en": "rawdah"}',
                'title' => '{"ar": "الروضة", "en": "Rawdah"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:07:51',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            5 => 
            array (
                'id' => 9,
                'slug' => '{"ar": "الري", "en": "rai"}',
                'title' => '{"ar": "الري", "en": "Rai"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:09:13',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            6 => 
            array (
                'id' => 10,
                'slug' => '{"ar": "السرة", "en": "surra"}',
                'title' => '{"ar": "السرة", "en": "surra"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:10:20',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            7 => 
            array (
                'id' => 11,
                'slug' => '{"ar": "الشامية", "en": "al-shamiya"}',
                'title' => '{"ar": "الشامية", "en": "al shamiya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:10:44',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            8 => 
            array (
                'id' => 12,
                'slug' => '{"ar": "الشويخ", "en": "al-shuwaikh"}',
                'title' => '{"ar": "الشويخ", "en": "al shuwaikh"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:11:04',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            9 => 
            array (
                'id' => 13,
                'slug' => '{"ar": "الصليبيخات", "en": "sulaibikhat"}',
                'title' => '{"ar": "الصليبيخات", "en": "Sulaibikhat"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:12:12',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            10 => 
            array (
                'id' => 14,
                'slug' => '{"ar": "الصوابر", "en": "sawabir"}',
                'title' => '{"ar": "الصوابر", "en": "Sawābir"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:12:37',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            11 => 
            array (
                'id' => 15,
                'slug' => '{"ar": "العديلية", "en": "al-adiliya"}',
                'title' => '{"ar": "العديلية", "en": "al adiliya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:12:58',
                'updated_at' => '2021-09-06 19:31:28',
            ),
            12 => 
            array (
                'id' => 16,
                'slug' => '{"ar": "الفيحاء", "en": "al-faiha"}',
                'title' => '{"ar": "الفيحاء", "en": "al faiha"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:13:31',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            13 => 
            array (
                'id' => 17,
                'slug' => '{"ar": "القادسية", "en": "qadsiya"}',
                'title' => '{"ar": "القادسية", "en": "Qadsiya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:13:50',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            14 => 
            array (
                'id' => 18,
                'slug' => '{"ar": "القيروان", "en": "qairawan"}',
                'title' => '{"ar": "القيروان", "en": "Qairawān"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:14:15',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            15 => 
            array (
                'id' => 19,
                'slug' => '{"ar": "المرقاب", "en": "al-murgab"}',
                'title' => '{"ar": "المرقاب", "en": "al murgab"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:14:41',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            16 => 
            array (
                'id' => 20,
                'slug' => '{"ar": "المنصورية", "en": "al-mansouriah"}',
                'title' => '{"ar": "المنصورية", "en": "al mansouriah"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:15:07',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            17 => 
            array (
                'id' => 21,
                'slug' => '{"ar": "النزهة", "en": "al-nuzha"}',
                'title' => '{"ar": "النزهة", "en": "al Nuzha"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:15:29',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            18 => 
            array (
                'id' => 22,
                'slug' => '{"ar": "النهضة", "en": "nahdha"}',
                'title' => '{"ar": "النهضة", "en": "Nahdha"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:16:14',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            19 => 
            array (
                'id' => 23,
                'slug' => '{"ar": "اليرموك", "en": "yarmuk"}',
                'title' => '{"ar": "اليرموك", "en": "Yarmūk"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:16:45',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            20 => 
            array (
                'id' => 24,
                'slug' => '{"ar": "بنيدالقار", "en": "bneid-al-gar"}',
                'title' => '{"ar": "بنيدالقار", "en": "Bneid al Gar"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:17:03',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            21 => 
            array (
                'id' => 25,
                'slug' => '{"ar": "دسمان", "en": "dasman"}',
                'title' => '{"ar": "دسمان", "en": "dasman"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:17:23',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            22 => 
            array (
                'id' => 26,
                'slug' => '{"ar": "شرق", "en": "sharq"}',
                'title' => '{"ar": "شرق", "en": "sharq"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:17:52',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            23 => 
            array (
                'id' => 27,
                'slug' => '{"ar": "صالحية", "en": "salhiya"}',
                'title' => '{"ar": "صالحية", "en": "Salhiya"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:18:22',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            24 => 
            array (
                'id' => 28,
                'slug' => '{"ar": "ضاحيه-عبدالله-السالم", "en": "abdullah-al-salem"}',
                'title' => '{"ar": "ضاحيه عبدالله السالم", "en": "abdullah al salem"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:18:41',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            25 => 
            array (
                'id' => 29,
                'slug' => '{"ar": "غرناطه", "en": "ghirnata"}',
                'title' => '{"ar": "غرناطه", "en": "Ghirnata"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:18:57',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            26 => 
            array (
                'id' => 30,
                'slug' => '{"ar": "قبلة", "en": "jibla"}',
                'title' => '{"ar": "قبلة", "en": "Jibla"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:19:26',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            27 => 
            array (
                'id' => 31,
                'slug' => '{"ar": "قرطبة", "en": "qurtoba"}',
                'title' => '{"ar": "قرطبة", "en": "Qurtoba"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:21:41',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            28 => 
            array (
                'id' => 32,
                'slug' => '{"ar": "كيفان", "en": "kaifan"}',
                'title' => '{"ar": "كيفان", "en": "kaifan"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:22:12',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            29 => 
            array (
                'id' => 33,
                'slug' => '{"ar": "مدينه-جابر-الأحمد", "en": "jabir-al-ahmad-city"}',
                'title' => '{"ar": "مدينه جابر الأحمد", "en": "Jabir al-Ahmad City"}',
                'status' => 1,
                'city_id' => 6,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 19:22:42',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            30 => 
            array (
                'id' => 34,
                'slug' => '{"ar": "أنجفه", "en": "anjafa"}',
                'title' => '{"ar": "أنجفه", "en": "Anjafa"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:34:53',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            31 => 
            array (
                'id' => 35,
                'slug' => '{"ar": "البدع", "en": "al-bidea"}',
                'title' => '{"ar": "البدع", "en": "Al bidea"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:35:23',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            32 => 
            array (
                'id' => 36,
                'slug' => '{"ar": "الجابرية", "en": "jabriya"}',
                'title' => '{"ar": "الجابرية", "en": "Jabriya"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:36:05',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            33 => 
            array (
                'id' => 37,
                'slug' => '{"ar": "الرميثية", "en": "rumaithiya"}',
                'title' => '{"ar": "الرميثية", "en": "Rumaithiya"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:36:27',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            34 => 
            array (
                'id' => 38,
                'slug' => '{"ar": "الزهراء", "en": "zahra"}',
                'title' => '{"ar": "الزهراء", "en": "Zahra"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:36:46',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            35 => 
            array (
                'id' => 39,
                'slug' => '{"ar": "السالمية", "en": "salmiya"}',
                'title' => '{"ar": "السالمية", "en": "Salmiya"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:37:24',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            36 => 
            array (
                'id' => 40,
                'slug' => '{"ar": "السلام", "en": "salam"}',
                'title' => '{"ar": "السلام", "en": "Salam"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:37:44',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            37 => 
            array (
                'id' => 41,
                'slug' => '{"ar": "الشعب", "en": "shaab"}',
                'title' => '{"ar": "الشعب", "en": "Shaab"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:38:08',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            38 => 
            array (
                'id' => 42,
                'slug' => '{"ar": "الشهداء", "en": "shuhada"}',
                'title' => '{"ar": "الشهداء", "en": "Shuhada"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:38:36',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            39 => 
            array (
                'id' => 43,
                'slug' => '{"ar": "بيان", "en": "bayan"}',
                'title' => '{"ar": "بيان", "en": "Bayan"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:39:42',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            40 => 
            array (
                'id' => 44,
                'slug' => '{"ar": "حطين", "en": "hateen"}',
                'title' => '{"ar": "حطين", "en": "Hateen"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:40:00',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            41 => 
            array (
                'id' => 45,
                'slug' => '{"ar": "سلوى", "en": "salwa"}',
                'title' => '{"ar": "سلوى", "en": "Salwa"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:40:26',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            42 => 
            array (
                'id' => 46,
                'slug' => '{"ar": "مبارك-العبدالله", "en": "mubarak-al-abdullah"}',
                'title' => '{"ar": "مبارك العبدالله", "en": "Mubarak al abdullah"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:41:03',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            43 => 
            array (
                'id' => 47,
                'slug' => '{"ar": "مشرف", "en": "mishrif"}',
                'title' => '{"ar": "مشرف", "en": "Mishrif"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:41:21',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            44 => 
            array (
                'id' => 48,
                'slug' => '{"ar": "ميدان-حولي", "en": "maidan-hawally"}',
                'title' => '{"ar": "ميدان حولي", "en": "maidan hawally"}',
                'status' => 1,
                'city_id' => 9,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:41:51',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            45 => 
            array (
                'id' => 49,
                'slug' => '{"ar": "أبرق-خيطان", "en": "abraq-khaitan"}',
                'title' => '{"ar": "أبرق خيطان", "en": "Abraq  khaitan"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:43:10',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            46 => 
            array (
                'id' => 50,
                'slug' => '{"ar": "أشبيلية", "en": "ishbiliya"}',
                'title' => '{"ar": "أشبيلية", "en": "Ishbiliya"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:44:16',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            47 => 
            array (
                'id' => 51,
                'slug' => '{"ar": "الأندلس", "en": "al-andalous"}',
                'title' => '{"ar": "الأندلس", "en": "Al Andalous"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:45:28',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            48 => 
            array (
                'id' => 52,
                'slug' => '{"ar": "الرابية", "en": "rabia"}',
                'title' => '{"ar": "الرابية", "en": "Rabia"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:47:13',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            49 => 
            array (
                'id' => 53,
                'slug' => '{"ar": "الرحاب", "en": "rehab"}',
                'title' => '{"ar": "الرحاب", "en": "Rehab"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:48:12',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            50 => 
            array (
                'id' => 54,
                'slug' => '{"ar": "الرقعي", "en": "rigai"}',
                'title' => '{"ar": "الرقعي", "en": "Rigai"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:48:36',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            51 => 
            array (
                'id' => 55,
                'slug' => '{"ar": "الأشدادية", "en": "al-ashadadiya"}',
                'title' => '{"ar": "الأشدادية", "en": "Al ashadadiya"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:50:26',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            52 => 
            array (
                'id' => 56,
                'slug' => '{"ar": "الضجيج", "en": "al-dajeej"}',
                'title' => '{"ar": "الضجيج", "en": "Al dajeej"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:51:39',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            53 => 
            array (
                'id' => 57,
                'slug' => '{"ar": "العارضية", "en": "ardiya"}',
                'title' => '{"ar": "العارضية", "en": "Ardiya"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:52:02',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            54 => 
            array (
                'id' => 58,
                'slug' => '{"ar": "العارضيه-الصناعيه", "en": "ardiya-small-industrial"}',
                'title' => '{"ar": "العارضيه الصناعيه", "en": "Ardiya small industrial"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:52:33',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            55 => 
            array (
                'id' => 59,
                'slug' => '{"ar": "العميري", "en": "omariya"}',
                'title' => '{"ar": "العميري", "en": "Omariya"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:52:54',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            56 => 
            array (
                'id' => 60,
                'slug' => '{"ar": "الفردوس", "en": "firdous"}',
                'title' => '{"ar": "الفردوس", "en": "Firdous"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:53:15',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            57 => 
            array (
                'id' => 61,
                'slug' => '{"ar": "الفروانية", "en": "farwaniyah"}',
                'title' => '{"ar": "الفروانية", "en": "Farwaniyah"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:56:30',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            58 => 
            array (
                'id' => 62,
                'slug' => '{"ar": "جليب-الشيوخ", "en": "jaleel-al-shuyoukh"}',
                'title' => '{"ar": "جليب الشيوخ", "en": "Jaleel al shuyoukh"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:56:43',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            59 => 
            array (
                'id' => 63,
                'slug' => '{"ar": "خيطان", "en": "khaitan"}',
                'title' => '{"ar": "خيطان", "en": "Khaitan"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:57:03',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            60 => 
            array (
                'id' => 64,
                'slug' => '{"ar": "صباح-الناصر", "en": "sabah-al-nasser"}',
                'title' => '{"ar": "صباح الناصر", "en": "Sabah al nasser"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:57:33',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            61 => 
            array (
                'id' => 65,
                'slug' => '{"ar": "عباسية", "en": "abbasiya"}',
                'title' => '{"ar": "عباسية", "en": "Abbasiya"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:58:04',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            62 => 
            array (
                'id' => 66,
                'slug' => '{"ar": "الجهراء", "en": "jahra"}',
                'title' => '{"ar": "الجهراء", "en": "jahra"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 22:59:39',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            63 => 
            array (
                'id' => 67,
                'slug' => '{"ar": "الصليبية", "en": "sulabiya"}',
                'title' => '{"ar": "الصليبية", "en": "sulabiya"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:00:09',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            64 => 
            array (
                'id' => 68,
                'slug' => '{"ar": "العيون", "en": "oyoun"}',
                'title' => '{"ar": "العيون", "en": "oyoun"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:00:31',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            65 => 
            array (
                'id' => 69,
                'slug' => '{"ar": "القصر", "en": "qasr"}',
                'title' => '{"ar": "القصر", "en": "qasr"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:00:45',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            66 => 
            array (
                'id' => 70,
                'slug' => '{"ar": "النسيم", "en": "naseem"}',
                'title' => '{"ar": "النسيم", "en": "naseem"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:01:00',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            67 => 
            array (
                'id' => 71,
                'slug' => '{"ar": "النعيم", "en": "alnayam"}',
                'title' => '{"ar": "النعيم", "en": "Alnayam"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:01:21',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            68 => 
            array (
                'id' => 72,
                'slug' => '{"ar": "الواحة", "en": "al-waha"}',
                'title' => '{"ar": "الواحة", "en": "Al waha"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:02:04',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            69 => 
            array (
                'id' => 73,
                'slug' => '{"ar": "تيماء", "en": "taima"}',
                'title' => '{"ar": "تيماء", "en": "taima"}',
                'status' => 1,
                'city_id' => 8,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:02:20',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            70 => 
            array (
                'id' => 74,
                'slug' => '{"ar": "سعد-العبدالله", "en": "saad-al-abdullah"}',
                'title' => '{"ar": "سعد العبدالله", "en": "saad al abdullah"}',
                'status' => 1,
                'city_id' => 4,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:02:41',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            71 => 
            array (
                'id' => 75,
                'slug' => '{"ar": "أبو-الحصانية", "en": "abu-al-hasaniya"}',
                'title' => '{"ar": "أبو الحصانية", "en": "abu al hasaniya"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:03:45',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            72 => 
            array (
                'id' => 76,
                'slug' => '{"ar": "أبو-فطيرة", "en": "abufteira"}',
                'title' => '{"ar": "أبو فطيرة", "en": "AbuFteira"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:04:22',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            73 => 
            array (
                'id' => 77,
                'slug' => '{"ar": "عدان", "en": "adan"}',
                'title' => '{"ar": "عدان", "en": "Adan"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:04:40',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            74 => 
            array (
                'id' => 78,
                'slug' => '{"ar": "القرين", "en": "qurain"}',
                'title' => '{"ar": "القرين", "en": "Qurain"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:05:11',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            75 => 
            array (
                'id' => 79,
                'slug' => '{"ar": "القصور", "en": "qusur"}',
                'title' => '{"ar": "القصور", "en": "Qusūr"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:05:27',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            76 => 
            array (
                'id' => 80,
                'slug' => '{"ar": "المسايل", "en": "al-masayel"}',
                'title' => '{"ar": "المسايل", "en": "al masayel"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:05:47',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            77 => 
            array (
                'id' => 81,
                'slug' => '{"ar": "المسيلة", "en": "misaila"}',
                'title' => '{"ar": "المسيلة", "en": "Misaila"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:09:25',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            78 => 
            array (
                'id' => 82,
                'slug' => '{"ar": "صباح-السالم", "en": "sabah-as-salim"}',
                'title' => '{"ar": "صباح السالم", "en": "Sabah as-Salim"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:10:08',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            79 => 
            array (
                'id' => 83,
                'slug' => '{"ar": "صبحان", "en": "sabhan"}',
                'title' => '{"ar": "صبحان", "en": "Sabhan"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:10:42',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            80 => 
            array (
                'id' => 84,
                'slug' => '{"ar": "فنيطيس", "en": "funaitis"}',
                'title' => '{"ar": "فنيطيس", "en": "Funaitīs"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:11:12',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            81 => 
            array (
                'id' => 85,
                'slug' => '{"ar": "مبارك-الكبير", "en": "mubarak-al-kabeer"}',
                'title' => '{"ar": "مبارك الكبير", "en": "Mubarak al-Kabeer"}',
                'status' => 1,
                'city_id' => 10,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:11:39',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            82 => 
            array (
                'id' => 86,
                'slug' => '{"ar": "أبو-حليفة", "en": "abu-hulaifa"}',
                'title' => '{"ar": "أبو حليفة", "en": "Abu Hulaifa"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:12:54',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            83 => 
            array (
                'id' => 87,
                'slug' => '{"ar": "الأحمدي", "en": "ahmadi"}',
                'title' => '{"ar": "الأحمدي", "en": "Ahmadi"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:13:17',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            84 => 
            array (
                'id' => 88,
                'slug' => '{"ar": "الرقه", "en": "rigga"}',
                'title' => '{"ar": "الرقه", "en": "Rigga"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-15 23:59:45',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            85 => 
            array (
                'id' => 89,
                'slug' => '{"ar": "الصباحية", "en": "alsbahya"}',
                'title' => '{"ar": "الصباحية", "en": "Alsbahya"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:00:33',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            86 => 
            array (
                'id' => 90,
                'slug' => '{"ar": "الظهر", "en": "dahar"}',
                'title' => '{"ar": "الظهر", "en": "dahar"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:00:50',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            87 => 
            array (
                'id' => 91,
                'slug' => '{"ar": "العقيلة", "en": "aqila"}',
                'title' => '{"ar": "العقيلة", "en": "Aqila"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:01:12',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            88 => 
            array (
                'id' => 92,
                'slug' => '{"ar": "الفحيحيل", "en": "fahaheel"}',
                'title' => '{"ar": "الفحيحيل", "en": "Fahaheel"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:01:44',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            89 => 
            array (
                'id' => 93,
                'slug' => '{"ar": "الفنطاس", "en": "alfintas"}',
                'title' => '{"ar": "الفنطاس", "en": "alfintas"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:03:28',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            90 => 
            array (
                'id' => 94,
                'slug' => '{"ar": "المنقف", "en": "mangaf"}',
                'title' => '{"ar": "المنقف", "en": "Mangaf"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:04:23',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            91 => 
            array (
                'id' => 95,
                'slug' => '{"ar": "المهبولة", "en": "mahbula"}',
                'title' => '{"ar": "المهبولة", "en": "Mahbula"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:04:46',
                'updated_at' => '2021-09-06 19:31:29',
            ),
            92 => 
            array (
                'id' => 96,
                'slug' => '{"ar": "جابر-العلي", "en": "jabir-al-ali"}',
                'title' => '{"ar": "جابر العلي", "en": "Jabir al-Ali"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:05:05',
                'updated_at' => '2021-09-06 19:31:30',
            ),
            93 => 
            array (
                'id' => 97,
                'slug' => '{"ar": "علي-صباح-السالم", "en": "ali-sabah-al-salem"}',
                'title' => '{"ar": "علي صباح  السالم", "en": "Ali sabah al salem"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:05:37',
                'updated_at' => '2021-09-06 19:31:30',
            ),
            94 => 
            array (
                'id' => 98,
                'slug' => '{"ar": "فهد-الأحمد", "en": "fahd-al-ahmad"}',
                'title' => '{"ar": "فهد الأحمد", "en": "Fahd al-Ahmad"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:06:00',
                'updated_at' => '2021-09-06 19:31:30',
            ),
            95 => 
            array (
                'id' => 99,
                'slug' => '{"ar": "مدينه-صباح-الأحمد", "en": "sabah-al-ahmad-city"}',
                'title' => '{"ar": "مدينه صباح الأحمد", "en": "Sabah al-Ahmad City"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:06:17',
                'updated_at' => '2021-09-06 19:31:30',
            ),
            96 => 
            array (
                'id' => 100,
                'slug' => '{"ar": "هدية", "en": "hadiya"}',
                'title' => '{"ar": "هدية", "en": "Hadiya"}',
                'status' => 1,
                'city_id' => 7,
                'deleted_at' => NULL,
                'created_at' => '2020-05-16 00:06:40',
                'updated_at' => '2021-09-06 19:46:32',
            ),
        ));
        
        
    }
}