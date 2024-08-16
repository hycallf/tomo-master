<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $deskripsi = 'Selamat datang di TOMO PONDOK MAHKOTA MOTOR ';
        $map = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255.12797367423457!2d106.90695796235696!3d-6.2848112844244675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f2b22309075d%3A0xc553df1cb7c16b9a!2s(TOMO%20BRIDGESTONE)%20PONDOK%20MAHKOTA%20MOTOR!5e0!3m2!1sid!2sid!4v1718703214917!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

        Settings::create([
            'master_nama' => 'TOMO PONDOK MAHKOTA MOTOR',
            'deskripsi' => $deskripsi,
            'alamat' => 'Jalan Raya Pondok Gede No.3C-D RT 002 RW012 , Kelurahan Lubang Buaya, Kecamatan Cipayung,  Kota Jakarta Timur',
            'map_google' => $map,
            'jam_operasional' => '07:30 to 16:00',
            'telepon' => '(021) 5793 0507',
            'email' => 'info@tomonet.co.id',
            'facebook' => 'https://facebook.com/tomo',
            'instagram' => 'https://instagram.com/tomo',
            'whatsapp' => 'https://wa.me/6285787840262',
        ]);
    }
}
