<?php

namespace Database\Factories;

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

            'unit_kerja' => $this->faker->company,
            'tgl' => $this->faker->date,
            'jam' => $this->faker->time('H:i'),
            'tempat' => $this->faker->city,
            'perekam_1' => $this->faker->name('male'),
            'perekam_2' => $this->faker->name('male'),
            'transkrip' => $this->faker->randomElement(['Ada', 'Tidak Ada']),
            'editor' => $this->faker->name('male'),
            'rapat' => $this->faker->words(1, true),
            'agenda' => $this->faker->paragraph,
            'keterangan' => $this->faker->sentence(1),
            'status' => $this->faker->randomElement(['Perekaman', 'Transkripsi', 'Pengeditan', 'Risalah OK', 'Belum Terlaksana']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
