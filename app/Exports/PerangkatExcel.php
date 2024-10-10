<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Perangkat;
use App\Enums\StatusPejabatEnum;
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

class PerangkatExcel implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithProperties
{
    use Exportable;

    // public function __construct($search_query)
    // {
    //     $this->search_query = $search_query;
    // }

    public function query()
    {
        return Perangkat::with(['penduduk','jabatan']);

/*
        // TODO : Has -> WhereHas -> orWhereHas
        return Perangkat::with(['penduduk','jabatan'])query()->where([
            ['nipd', 'LIKE', '%' . $this->search_query . '%'],
            ['nip', 'LIKE', '%' . $this->search_query . '%'],
            ['pangkat_golongan', 'LIKE', '%' . $this->search_query . '%'],
            ['no_keputusan_pengangkatan', 'LIKE', '%' . $this->search_query . '%'],
            ['tanggal_keputusan_pengangkatan', 'LIKE', '%' . $this->search_query . '%'],
            ['no_keputusan_pemberhentian', 'LIKE', '%' . $this->search_query . '%'],
            ['tanggal_keputusan_pemberhentian', 'LIKE', '%' . $this->search_query . '%'],
            ['status_pejabat', 'LIKE', '%' . $this->search_query . '%'],
            ['masa_jabatan', 'LIKE', '%' . $this->search_query . '%']
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
            ['PERANGKAT'],
            ['SID - Sistem Informasi Desa'],
            [
                __('penduduk_nama'),
                __('penduduk_nik'),
                __('jabatan'),
                __('nipd'),
                __('nip'),
                __('pangkat_golongan'),
                __('no_keputusan_pengangkatan'),
                __('tanggal_keputusan_pengangkatan'),
                __('no_keputusan_pemberhentian'),
                __('tanggal_keputusan_pemberhentian'),
                __('status_pejabat'),
                __('masa_jabatan')
            ]
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        return [
            'penduduk_nama'                      => $row->penduduk?->nama,
            'penduduk_nik'                       => $row->penduduk?->nik,
            'jabatan'                            => $row->jabatan?->nama,
            'nipd'                               => $row->nipd,
            'nip'                                => $row->nip,
            'pangkat_golongan'                   => $row->pangkat_golongan,
            'no_keputusan_pengangkatan'          => $row->no_keputusan_pengangkatan,
            'tanggal_keputusan_pengangkatan'     => Date::dateTimeToExcel(Carbon::parse($row->getAttributes()['tanggal_keputusan_pengangkatan'])), // Converts the parsed Carbon date to Excel's date format,
            'no_keputusan_pemberhentian'         => $row->no_keputusan_pemberhentian,
            'tanggal_keputusan_pemberhentian'    => Date::dateTimeToExcel(Carbon::parse($row->getAttributes()['tanggal_keputusan_pemberhentian'])), // Converts the parsed Carbon date to Excel's date format,
            'status_pejabat'                     => $row->status_pejabat->label(),
            'masa_jabatan'                       => $row->masa_jabatan
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => 0, // Number,
            'D' => 0, // Number,
            'E' => 0, // Number,
            'G' => 0, // Number,
            'H' => 'dd mmmm yyyy',
            'I' => 0, // Number,
            'J' => 'dd mmmm yyyy'
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
                $event->sheet->getStyle('G4:G'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('H4:H'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('I4:I'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('J4:J'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('K4:K'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('L4:L'.$lastRow)->getAlignment()->setIndent(1);

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
                foreach ($event->sheet->getColumnIterator('J') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (StatusPejabatEnum::cases() as $statusPejabat) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $statusPejabat->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($statusPejabat->color());
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
            'title'     => 'Perangkat'
        ];
    }
}
