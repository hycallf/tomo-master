<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use App\Models\Perbaikan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelanggan::chunk(20, function ($pelanggans) {
            foreach ($pelanggans as $pelanggan) {
                Kendaraan::factory(rand(1, 3))->create(['pelanggan_id' => $pelanggan->id])->each(function ($kendaraan) {
                    $perbaikanCount = rand(1, 5);
                    Perbaikan::factory()->count($perbaikanCount)->create([
                        'kendaraan_id' => $kendaraan->id,
                    ]);
                });
            }
        });
    }
}
