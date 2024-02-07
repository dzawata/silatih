<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class ExportOpd implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    public function __construct($opd, $data)
    {
        $this->opd = $opd;
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->opd->export($this->data);
    }

    public function headings(): array
    {
        return ["KD UNOR", "Nama OPD", "KECAMATAN", "ALAMAT", "NO. TELPON", "ALAMAT EMAIL"];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
