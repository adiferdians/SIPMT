<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RuangRapat;
use Illuminate\Database\Seeder;

class RuangRapatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RuangRapat::factory()->count(10)->create();
    }
}
