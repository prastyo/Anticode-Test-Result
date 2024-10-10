<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Keuangan;
use App\Enums\JenisKeuanganEnum;
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

class KeuanganExcel implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithProperties
{
    use Exportable;

    // public function __construct($search_query)
    // {
    //     $this->search_query = $search_query;
    // }

    public function query()
    {
        return Keuangan::query();

/*
        // TODO : Has -> WhereHas -> orWhereHas
        return Keuangan::query()query()->where([
            ['tahun_anggaran', 'LIKE', '%' . $this->search_query . '%'],
            ['jenis_keuangan', 'LIKE', '%' . $this->search_query . '%'],
            ['keterangan', 'LIKE', '%' . $this->search_query . '%'],
            ['tanggal_kuitansi', 'LIKE', '%' . $this->search_query . '%']
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
            ['KEUANGAN'],
            ['SID - Sistem Informasi Desa'],
            [
                __('tahun_anggaran'),
                __('jenis_keuangan'),
                __('nilai_anggaran'),
                __('nilai_realisasi'),
                __('keterangan'),
                __('tanggal_kuitansi')
            ]
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        return [
            'tahun_anggaran'      => $row->tahun_anggaran,
            'jenis_keuangan'      => $row->jenis_keuangan->label(),
            'nilai_anggaran'      => $row->getAttributes()['nilai_anggaran'], // Retrieve raw attribute values directly from the model without applying accessors,
            'nilai_realisasi'     => $row->getAttributes()['nilai_realisasi'], // Retrieve raw attribute values directly from the model without applying accessors,
            'keterangan'          => $row->keterangan,
            'tanggal_kuitansi'    => Date::dateTimeToExcel(Carbon::parse($row->getAttributes()['tanggal_kuitansi'])), // Converts the parsed Carbon date to Excel's date format
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '#,##0.00', // The separator (dot or comma) according to the regional locale on the computer,
            'D' => '#,##0.00', // The separator (dot or comma) according to the regional locale on the computer,
            'F' => 'dd mmmm yyyy'
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
                $event->sheet->getStyle('B4:B'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('C4:C'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('D4:D'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('E4:E'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('F4:F'.$lastRow)->getAlignment()->setIndent(1);

                $event->sheet->getRowDimension(1)->setRowHeight(35);
                $event->sheet->getRowDimension(2)->setRowHeight(25);
                $event->sheet->getRowDimension(3)->setRowHeight(25);

                $event->sheet->setAutoFilter('A3:' . $lastColumn . $lastRow);
                $event->sheet->freezePane('A4');
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
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

                // Iterasi setiap row dan terapkan warna
                foreach ($event->sheet->getColumnIterator('B') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (JenisKeuanganEnum::cases() as $jenisKeuangan) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $jenisKeuangan->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($jenisKeuangan->color());
                                break; // Keluar dari loop setelah cocok
                            }
                        }
                    }
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
            'title'     => 'Keuangan'
        ];
    }
}
