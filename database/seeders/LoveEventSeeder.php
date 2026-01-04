<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LoveEventSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'title' => 'Mencintai Dalam Diam: Seni Menjaga Hati',
                'description' => 'Gimana sih caranya suka sama seseorang tapi tetap menjaga izzah dan iffah? Belajar bareng yuk dari kisah cinta paling romantis sepanjang masa, Ali bin Abi Thalib dan Fatimah Az-Zahra. Cocok buat kamu yang lagi struggle nahan rasa!',
                'banner_image' => null, // Biarkan default placeholder
                'start_time' => Carbon::now()->addDays(2)->setHour(19)->setMinute(30),
                'end_time' => Carbon::now()->addDays(2)->setHour(21)->setMinute(0),
                'location' => 'Masjid Al-Latif, Bandung (Hybrid)',
                'quota' => 150,
                'price' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jodoh Pasti Bertamu: Memantaskan Diri di Era Swipe Right',
                'description' => 'Di zaman dating apps, masih relevan gak sih jalur langit? Kupas tuntas cara menjemput jodoh terbaik dengan memperbaiki kualitas diri. Fokus upgrade diri, biar Allah yang pilihin yang best quality!',
                'banner_image' => null,
                'start_time' => Carbon::now()->addDays(5)->setHour(8)->setMinute(0),
                'end_time' => Carbon::now()->addDays(5)->setHour(11)->setMinute(30),
                'location' => 'Ballroom Hotel Aston, Jakarta Selatan',
                'quota' => 300,
                'price' => 85000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Halal Journey: From Talking Stage to Akad',
                'description' => 'Bingung bedain taaruf sama modus? Workshop interaktif persiapan pranikah khusus Gen Z. Bahas visi misi pernikahan, finansial, sampai mental health. Jangan cuma siap resepsi, tapi gak siap berumah tangga!',
                'banner_image' => null,
                'start_time' => Carbon::now()->addDays(10)->setHour(13)->setMinute(0),
                'end_time' => Carbon::now()->addDays(10)->setHour(16)->setMinute(0),
                'location' => 'Co-working Space, Tebet',
                'quota' => 50,
                'price' => 120000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Healing Hati yang Patah: Move On Jalur Langit',
                'description' => 'Buat kamu yang lagi galau brutal karena harapan tak sesuai kenyataan. Yuk healing bareng lewat ayat-ayat cinta-Nya. Obat patah hati terbaik adalah kembali pada Pemilik Hati.',
                'banner_image' => null,
                'start_time' => Carbon::now()->addDays(1)->setHour(18)->setMinute(30),
                'end_time' => Carbon::now()->addDays(1)->setHour(20)->setMinute(30),
                'location' => 'Masjid Istiqlal, Jakarta',
                'quota' => 500,
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bukan Sekedar Baper: Membangun Cinta Karena Allah',
                'description' => 'Cinta itu fitrah, tapi cara mengekspresikannya butuh aturan. Kajian santai membahas psikologi cinta remaja dan batasan pergaulan dalam Islam. Biar gak cuma baper, tapi bawa berkah!',
                'banner_image' => null,
                'start_time' => Carbon::now()->addDays(7)->setHour(9)->setMinute(0),
                'end_time' => Carbon::now()->addDays(7)->setHour(12)->setMinute(0),
                'location' => 'Zoom Meeting (Online)',
                'quota' => 1000,
                'price' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('events')->insert($events);
    }
}
