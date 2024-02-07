<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RecordAirExport implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{
    public function __construct($recordAir,$data) {
        $this->recordAir = $recordAir;
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return $this->recordAir->export_excel($this->data);
    }
     
    public function headings(): array
    {
        return ["OPD", "Semester", "Penggunaan Air (M2)", "Biaya (Rp)", 'Record Air'];
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
