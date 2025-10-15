<?php

namespace App\Exports;

use App\Models\Risalah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Soundasleep\Html2Text;
use Carbon\Carbon;

class RisalahExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Risalah::query()->whereBetween('tgl', [$this->startDate, $this->endDate]);
    }

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

    public function map($row): array
    {
        static $no = 1;

        $tgl = '';
        if (!empty($row->tgl)) {
            try {
                $tgl = Carbon::parse($row->tgl)
                    ->locale('id')
                    ->translatedFormat('l, d-m-Y'); 
            } catch (\Exception $e) {
                $tgl = $row->tgl;
            }
        }

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
            Html2Text::convert($row->agenda),
            $row->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $highestRow = $sheet->getHighestRow();
        for ($i = 2; $i <= $highestRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle("A{$i}:L{$i}")->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D9E2F3');
            }
        }

        $sheet->getStyle('J')->getAlignment()->setWrapText(true);
        $sheet->setAutoFilter('A1:L1');

        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Unit Kerja
            'B' => 15, // Tanggal
            'C' => 10, // Jam
            'D' => 20, // Tempat
            'E' => 15, // Perekam 1
            'F' => 15, // Perekam 2
            'G' => 20, // Transkrip
            'H' => 15, // Editor
            'I' => 20, // Rapat
            'J' => 20, // Agenda (kolom wrap text)
            'K' => 15, // Status
        ];
    }
}
