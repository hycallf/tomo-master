<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tipe;
use App\Models\Merek;
use App\Models\Kendaraan;
use App\Models\Perbaikan;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kendaraan>
 */
class KendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Kendaraan::class;
    
    public function definition()
    {
        $merek_id = rand(1, 9);
        $tipe_id = rand(1, 9);
        $tahun = $this->faker->numberBetween(2000, 2023);
 
        $merek = Merek::find($merek_id);
        $tipe = Tipe::find($tipe_id);

        $keterangan = ($tipe ? $tipe->nama_merek : 'Unknown') . ' ' . ($merek ? $merek->nama_tipe : 'Unknown') . ' ' . $this->faker->numberBetween(2000, 2023);

        return [
            'no_plat' => $this->faker->bothify('?? #### ??'),
            'merek_id' => $merek_id,
            'tipe_id' => $tipe_id,
            'keterangan' => $keterangan,
            'maintenance_schedule_months' => $this->faker->numberBetween(1, 4),
            
        ];
    }
}
