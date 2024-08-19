<?php

namespace Database\Factories;

use App\Models\Kendaraan;
use App\Models\Perbaikan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perbaikan>
 */
class PerbaikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Perbaikan::class;
    public function definition()
    {
        // $tanggalSelesai = Carbon::now()->subMonths(rand(1, 4))->subDays(rand(0, 30));
        // $tanggalMasuk = $tanggalSelesai->copy()->subDays(rand(1, 7));

        $tgl_masuk = $this->faker->dateTimeBetween('-5 months', '-1 months');
        $tgl_selesai = Carbon::parse($tgl_masuk)->addDays(rand(0, 30));
        
        return [
            'kode_unik' => $this->faker->bothify('?????-#####'),
            'kendaraan_id' => Kendaraan::factory(),
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->sentence(10),
            'biaya' => $this->faker->numberBetween(100000, 10000000),
            'status' => 'Selesai',
            'tgl_masuk' => $tgl_masuk,
            'tgl_selesai' => $tgl_selesai,
            'created_at' => $tgl_masuk,
            'updated_at' => $tgl_selesai,
        ];
    }
}
