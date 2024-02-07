<?php

namespace App\Exports\Operator;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportRecordAir implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{

    public function __construct($record, $data) {
        $this->record = $record;
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        return $this->record->export_record_air($this->data);
        
    }

    public function headings(): array
    {
        return ["Gedung", "Semester", "Rata - rata Penggunaan","Rata - rata Biaya","Rata - rata Record", "Kriteria"];
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
