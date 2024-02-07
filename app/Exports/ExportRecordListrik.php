<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportRecordListrik implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{

    function __construct($record, $data) {
       
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
        return [ "OPD","Poriode", 'Semester' ,"Rata - rata Penggunaan Listrik AC", "Rata - rata Penggunaan Listrik Non AC","Rata - rata Penggunaan Listrik", "Rata - rata Biaya Listrik",  "Rata - rata record AC","Rata - rata record Non AC","Kriteria Listrik AC","Kriteria Listrik Non AC"];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
