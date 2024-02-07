<?php

namespace App\Exports\Operator;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RecordExport implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
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
        return $this->record->export_record($this->data);

    }

    public function headings(): array
    {
        return ["Gedung","Semester" ,"Rata - Rata Penggunaan Listrik AC", "Rata - Rata Penggunaan Listrik Non  AC", "Rata - rata total Penggunaan Listrik", "Rata - rata Biaya Listrik","Rata - rata Record AC", "Rata - rata Record Non AC",  "Kriteria Listrik AC","Kriteria Listrik Non AC"];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:H1'; 
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }



}
