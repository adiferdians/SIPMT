<?php

namespace Database\Factories;
use App\Models\Anggota;
use App\Models\RuangRapat;
use App\Models\UnitKerja;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Risalah>
 */
class RisalahFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_kerja' => UnitKerja::inRandomOrder()->value('nama'),
            'tgl' => $this->faker->dateTimeBetween('2024-01-01', 'now'),
            'jam' => $this->faker->time('H:i'),
            'tempat' => RuangRapat::inRandomOrder()->value('nama'),
            'perekam_1' => Anggota::inRandomOrder()->value('nama'),
            'perekam_2' => Anggota::inRandomOrder()->value('nama'),
            'transkrip' => Anggota::inRandomOrder()->value('nama'),
            'editor' => Anggota::inRandomOrder()->value('nama'),
            'rapat' => $this->faker->words(1, true),
            'agenda' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Perekaman', 'Transkripsi', 'Pengeditan', 'Risalah OK', 'Belum Terlaksana']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
