<?php

namespace Database\Seeders;

use App\Models\Risalah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RisalahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Risalah::factory()->count(20)->create();
    }
}
