<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nip' => $this->faker->text(8),
            'telpon' => $this->faker->randomNumber(7, true),
            'status' => $this->faker->text(5),
            'role' => $this->faker->text(5),
            'jk' => $this->faker->text(5),
            'pangkat_golongan' => $this->faker->text(5),
            'jabatan' => $this->faker->text(5),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->text(5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
