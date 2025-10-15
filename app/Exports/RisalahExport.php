<?php

namespace App\Exports;

use App\Models\Risalah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable; 

class RisalahExport implements FromQuery, WithHeadings
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
            'ID',
            'Unit Kerja',
            'Tanggal',
            'Jam',
            'Tempat',
            'Perekam 1',
            'Perekam 2',
            'Transkrip',
            'Editor',
            'Rapat',
            'Agenda',
            'Status',
            'Masa Sidang',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
