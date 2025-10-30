<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Laporan>
 */
class LaporanFactory extends Factory
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
            'jabatan' => $this->faker->text(5),
            'tugas' => $this->faker->randomElement(
                [
                    'Melakukan penyiapan dan penyuluhan terkait sistem dan teknologi informasi',
                    'Melakukan pemantauan dan pengendalian terkait sistem dan teknologi informasi',
                    'Menyiapkan rapat dan menyusun notulensi rapat sesuai jadwal dan disposisi atasan sebagai dukungan administrasi dalam kegiatan unit kerja agar pelaksanaan tugas berjalan optimal',
                    'Menyiapkan bahan penyusunan Rencana Operasional Kegiatan Unit Kerja berdasarkan Rencana Kegiatan Unit Kerja dan peraturan serta ketentuan yang berlaku sebagai pedoman dalam pelaksanaan tugas',
                    'Membuat laporan pelaksanaan tugas kegiatan sesuai dengan prosedur kerja dan peraturan sebagai laporan pertanggungjawaban dan bahan evaluasi untuk penyusunan rencana kegiatan yang akan datang',
                    'Melaksanakan tugas kedinasan lain/kreativitas/unsur penunjang yang berkaitan dengan kinerja tambahan'
                ]
            ),
            'jam' => $this->faker->time(),
            'tgl' => $this->faker->date(),
            'deskripsi' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
