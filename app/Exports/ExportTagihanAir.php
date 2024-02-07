<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportTagihanAir implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{

    public function __construct($penggunaanAir, $data) {
        $this->penggunaanAir = $penggunaanAir;
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  $this->penggunaanAir->export($this->data);
    }
    
    public function headings(): array
    {
        return ["PORIODE", "OPD","GEDUNG" ,"PENGGUNAAN AIR (M2)", 'RASIO (L/orang/8 jam)',"BIAYA (Rp)", "KRITERIA"];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
