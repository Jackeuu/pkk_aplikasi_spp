<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\UangDaftarUlang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();
        Siswa::factory(20)->create();

        for ($i = 1; $i < 7; $i++) {
            Kelas::create([
                'nama_kelas' => $i,
            ]);
        }

        $nominalSpp = [400000, 350000, 375000];
        for ($i = 0; $i < 3; $i++) {
            Spp::create([
                'nominal' => $nominalSpp[$i],
            ]);
        }
        
        $nominalDu = [3000000, 2950000, 2975000];
        for ($i = 0; $i < 3; $i++) {
            UangDaftarUlang::create([
                'nominal_du' => $nominalDu[$i],
                'tahun_ajaran' => '2025/2026',
            ]);
        }
    }
}
