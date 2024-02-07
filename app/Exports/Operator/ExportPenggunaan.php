<?php

namespace App\Exports\Operator;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportPenggunaan implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{

    public function __construct($penggunaan, $data) {
        $this->penggunaan = $penggunaan;
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return $this->penggunaan->export_penggunaan(auth()->user()->opd,$this->data);
        
    }

    public function headings(): array
    {
        return ["Poriode", "Gedung", "Penggunaan AC","Penggunaan Non AC","Penggunaan Total","Biaya", "Kriteria AC" ,"Kriteria Non AC", "Rasio AC","Rasio Non AC",];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

}
