<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportTagihan implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{
    public function __construct($tagihan, $data) {
        $this->tagihan = $tagihan;
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->tagihan->export_tagihan($this->data);
    }

    
    public function headings(): array
    {
        return ["Poriode","OPD" ,'Gedung', 'Penggunaan AC ','Penggunaan Non AC','Penggunaan Total', "Biaya (Rp)", 'Rasio AC', 'Rasio Non AC'];
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
