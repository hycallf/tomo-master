<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pelanggan2 = User::create([
            'role' => 'pelanggan',
            'device_id' => null,
            'email' => 'ricardohaikal2001@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'created_at' => now()
        ]);

        Pelanggan::create([
            'user_id' => $pelanggan2->id,
            'nama' => 'Haikal',
            'no_telp' => '081319476815',
            'alamat' => 'Pacitan, Jatim',
            'jenis_k' => 'L',
            'foto' => null,
            'created_at' => now()
        ]);

        $pelanggan3 = User::create([
            'role' => 'pelanggan',
            'device_id' => null,
            'email' => 'triyonohansamuhiro@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'created_at' => now()
        ]);

        Pelanggan::create([
            'user_id' => $pelanggan3->id,
            'nama' => 'Triyono',
            'no_telp' => '089603824366',
            'alamat' => 'Pacitan, Jatim',
            'jenis_k' => 'L',
            'foto' => null,
            'created_at' => now()
        ]);

        $pelanggan4 = User::create([
            'role' => 'pelanggan',
            'device_id' => null,
            'email' => 'zahwa@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'created_at' => now()
        ]);

        Pelanggan::create([
            'user_id' => $pelanggan4->id,
            'nama' => 'Zahwa',
            'no_telp' => '085787840262',
            'alamat' => 'Pacitan, Jatim',
            'jenis_k' => 'L',
            'foto' => null,
            'created_at' => now()
        ]);
        // User::factory(10)->create([
        //     'role' => 'pelanggan',
        // ])->each(function ($user) {
        //     Pelanggan::factory()->create(['user_id' => $user->id]);
        // });
    }
}
