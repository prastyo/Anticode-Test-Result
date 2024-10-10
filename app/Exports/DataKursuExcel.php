<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Exports;

use App\Models\DataKursu;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DataKursuExcel implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithProperties
{
    use Exportable;

    // public function __construct($search_query)
    // {
    //     $this->search_query = $search_query;
    // }

    public function query()
    {
        return DataKursu::query();

/*
        // TODO : Has -> WhereHas -> orWhereHas
        return DataKursu::query()query()->where([
            ['nama', 'LIKE', '%' . $this->search_query . '%']
        ])
        ->orWhere(function($query) use (search_query) {
            $query->has('item_parent', fn($q) => $q->where('column_name', 'LIKE', '%' . $search_query . '%'))
            ->whereHas('item_parent', fn($q) => $q->where('column_name', 'LIKE', '%' . $search_query . '%'))
            ->orWhereHas('products', fn($q) => $q->where('column_name', 'LIKE', '%' . $search_query . '%'))
            ->orWhereHas('shipping_parent', fn($q) => $q->where('column_name', 'LIKE', '%' . $search_query . '%'));
        });
*/
    }

    /**
     * Specify the headings for the exported file.
     */
    public function headings(): array
    {
        return [
            ['DATA KURSUS'],
            ['SID - Sistem Informasi Desa'],
            [
                __('nama')
            ]
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        return [
            'nama'    => $row->nama
        ];
    }

    public function columnFormats(): array
    {
        return [

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $lastColumn = $event->sheet->getHighestColumn();
                $lastRow = $event->sheet->getHighestRow();

                $rangeTitle    = 'A1:'. $lastColumn . '1';
                $rangeSubtitle = 'A2:'. $lastColumn . '2';
                $rangeHeader   = 'A3:'. $lastColumn . '3';

                $event->sheet->mergeCells($rangeTitle);
                $event->sheet->mergeCells($rangeSubtitle);

                //Set indent if type of a variable is string
                $event->sheet->getStyle('A4:A'.$lastRow)->getAlignment()->setIndent(1);

                $event->sheet->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getRowDimension(2)->setRowHeight(25);
                $event->sheet->getRowDimension(3)->setRowHeight(25);

                $event->sheet->setAutoFilter('A3:' . $lastColumn . $lastRow);
                $event->sheet->freezePane('A4');
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $event->sheet->getPageSetup()->setFitToPage(true);

                $zebra = ['fill' => [
                            'fillType'  => Fill::FILL_SOLID,
                            'color'     => array('rgb' => 'f3f3f3')
                        ]];
                $alignment = ['alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ]];

                $newArr = array();
                for($i=4;$i <= $lastRow; $i++){
                    if($i % 2 == 0){
                        $newArr = $alignment;                        
                    }else{
                        $newArr = array_merge($zebra, $alignment);
                    }
                    $event->sheet->getStyle('A'.$i.':'.$lastColumn.$i)->applyFromArray($newArr);
                    $event->sheet->getRowDimension($i)->setRowHeight(22);
                }

                // title
                $event->sheet->getStyle($rangeTitle)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color'     => array('rgb' => '6777ef')
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                // subtitle
                $event->sheet->getStyle($rangeSubtitle)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                        'color'     => array('rgb' => '6777ef')
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_TOP,
                    ],
                ]);

                // headers
                $event->sheet->getStyle($rangeHeader)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color'     => array('rgb' => 'FFFFFF')
                    ],
                    'fill' => [
                        'fillType'  => Fill::FILL_SOLID,
                        'color'     => array('rgb' => '6777ef')
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                // table
                $event->sheet->getStyle('A4:'.$lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        // allBorders, horizontal, inside, outline, vertical
                        'horizontal' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'     => array('rgb' => 'dddddd')
                        ],
                    ],
                ]);

                $event->sheet->getStyle('A'.$lastRow.':'.$lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        // allBorders, horizontal, inside, outline, vertical
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color'     => array('rgb' => '6777ef')
                        ],
                    ],
                ]);

                $event->sheet->getStyle($lastColumn . $lastRow)->applyFromArray([
                    //Set nothing to unselect table
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }

    public function properties(): array
    {
        return [
            'creator'   => 'Budi Prastyo <budi@prastyo.com>',
            'title'     => 'Data Kursus'
        ];
    }
}
