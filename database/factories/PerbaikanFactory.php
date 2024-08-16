<?php

namespace Database\Factories;

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
    public function definition()
    {
        $tanggalSelesai = Carbon::now()->subMonths(rand(1, 4))->subDays(rand(0, 30));
        $tanggalMasuk = $tanggalSelesai->copy()->subDays(rand(1, 7));

        return [
            'kode_unik' => $this->faker->bothify('?????-#####'),
            'nama' => $this->faker->words(3, true),
            'keterangan' => $this->faker->sentence(10),
            'status' => 'Selesai',
            'tgl_selesai' => $tanggalSelesai,
            'created_at' => $tanggalMasuk,
            'updated_at' => $tanggalSelesai,
        ];
    }
}
