<?php

namespace App\Exports;

use App\Models\Risalah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class RisalahExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    /**
     * Query utama
     */
    public function query()
    {
        return Risalah::query()
            ->whereBetween('tgl', [$this->startDate, $this->endDate])
            ->orderBy('tgl', 'asc');
    }

    /**
     * Heading tabel (bukan header besar laporan)
     */
    public function headings(): array
    {
        return [
            'No',
            'Unit Kerja',
            'Tanggal',
            'Jam',
            'Ruangan',
            'Perekam 1',
            'Perekam 2',
            'Transkrip',
            'Editor',
            'Rapat',
            'Agenda',
            'Status',
        ];
    }

    /**
     * Konversi HTML ke teks rapi untuk kolom Agenda
     */
    private function cleanAgenda($html): string
    {
        if (empty($html)) return '';

        // Ganti elemen HTML umum menjadi teks yang bisa dipahami Excel
        $replacements = [
            '<br>' => "\n",
            '<br/>' => "\n",
            '<br />' => "\n",
            '</p>' => "\n",
            '</li>' => "\n",
            '<ul>' => "",
            '</ul>' => "",
            '<ol>' => "",
            '</ol>' => "",
            '<li>' => "• ",
            '<p>' => "",
        ];

        $text = str_ireplace(array_keys($replacements), array_values($replacements), $html);

        // Hapus tag HTML lain yang tersisa
        $text = strip_tags($text);

        // Bersihkan spasi ganda dan newline berlebih
        $text = preg_replace("/\n\s*\n/", "\n", trim($text));

        return $text;
    }

    /**
     * Mapping data ke baris Excel
     */
    public function map($row): array
    {
        static $no = 1;

        $tgl = $row->tgl ? Carbon::parse($row->tgl)
            ->locale('id')
            ->translatedFormat('l, d-m-Y') : '';

        return [
            $no++,
            $row->unit_kerja,
            $tgl,
            $row->jam,
            $row->tempat,
            $row->perekam_1,
            $row->perekam_2,
            $row->transkrip,
            $row->editor,
            $row->rapat,
            $this->cleanAgenda($row->agenda),
            $row->status,
        ];
    }

    /**
     * Styling Excel
     */
    public function styles(Worksheet $sheet)
    {
        // === 1. Header laporan di atas tabel ===
        $title = 'LAPORAN RISALAH RAPAT';
        $period = 'Periode: ' . Carbon::parse($this->startDate)->translatedFormat('d F Y')
            . ' s.d. ' . Carbon::parse($this->endDate)->translatedFormat('d F Y');

        // Sisipkan dua baris di atas header tabel
        $sheet->insertNewRowBefore(1, 2);

        // Merge cell untuk judul dan periode
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');

        $sheet->setCellValue('A1', $title);
        $sheet->setCellValue('A2', $period);

        // Atur tinggi baris header laporan
        $sheet->getRowDimension(3)->setRowHeight(30);

        // Style judul besar
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // Style periode
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'size' => 12],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        // === 2. Header tabel (baris ke-3 setelah insert) ===
        $headerRow = 3;
        $sheet->getStyle("A{$headerRow}:L{$headerRow}")->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 11,
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '305496'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
                'wrapText' => true,
            ],
        ]);

        // === 3. Warna selang-seling dan border ===
        $highestRow = $sheet->getHighestRow();

        for ($i = $headerRow + 1; $i <= $highestRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle("A{$i}:L{$i}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('E9EDF7');
            } else {
                $sheet->getStyle("A{$i}:L{$i}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('bdd6ee');
            }
        }

        // Tambahkan border pada semua sel
        $sheet->getStyle("A{$headerRow}:L{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '808080'],
                ],
            ],
        ]);

        // === 4. Kolom K (Agenda) ===
        $sheet->getColumnDimension('K')->setWidth(70); // ~500px
        $sheet->getStyle('K')->getAlignment()->setWrapText(true);
        $sheet->getStyle('K')->getAlignment()->setVertical('top');

        // Autofilter
        $sheet->setAutoFilter("A{$headerRow}:L{$headerRow}");

        // Posisi teks tengah (horizontal & vertikal) untuk semua kolom kecuali Agenda (K)
        foreach (range('A', 'L') as $col) {
            if ($col !== 'K') {
                $sheet->getStyle($col)->getAlignment()->setHorizontal('center');
                $sheet->getStyle($col)->getAlignment()->setVertical('center');
            }
        }

        $sheet->getParent()->getProperties()
            ->setCreator('Setjen DPD RI')
            ->setTitle('Laporan Risalah Rapat')
            ->setCategory('Laporan Resmi')
            ->setCompany('Setjen DPD RI');


        // Autosize kolom lain
        foreach (range('A', 'L') as $col) {
            if ($col !== 'K') {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        }

        return [];
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Unit Kerja
            'C' => 20,  // Tanggal
            'D' => 10,  // Jam
            'E' => 20,  // Ruangan
            'F' => 15,  // Perekam 1
            'G' => 15,  // Perekam 2
            'H' => 20,  // Transkrip
            'I' => 15,  // Editor
            'J' => 20,  // Rapat
            'K' => 70,  // Agenda (wrap text)
            'L' => 15,  // Status
        ];
    }
}
