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
            'nip' => $this->faker->unique()->numerify('##################'), // Menghasilkan 18 digit angka unik untuk NIP
            'telepon' => $this->faker->phoneNumber(), // Menghasilkan format nomor telepon yang lebih realistis
            'status' => $this->faker->text(5), // Tidak perlu diubah jika sudah sesuai
            'role' => $this->faker->randomElement(['admin', 'user', 'moderator']), // Memilih dari daftar peran (role) yang sudah ditentukan
            'jk' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'pangkat_golongan' => $this->faker->text(5),
            'jabatan' => $this->faker->text(5),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->text(5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
