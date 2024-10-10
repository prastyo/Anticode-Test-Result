<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Kelahiran;
use App\Enums\JenisKelaminEnum;
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

class KelahiranExcel implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithProperties
{
    use Exportable;

    // public function __construct($search_query)
    // {
    //     $this->search_query = $search_query;
    // }

    public function query()
    {
        return Kelahiran::with(['ayah','ibu','jenis_persalinan','tempat_dilahirkan','penolong_kelahiran']);

/*
        // TODO : Has -> WhereHas -> orWhereHas
        return Kelahiran::with(['ayah','ibu','jenis_persalinan','tempat_dilahirkan','penolong_kelahiran'])query()->where([
            ['nama_anak', 'LIKE', '%' . $this->search_query . '%'],
            ['jenis_kelamin', 'LIKE', '%' . $this->search_query . '%'],
            ['hari_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['tempat_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['tanggal_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['jam_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['anak_ke', 'LIKE', '%' . $this->search_query . '%'],
            ['berat_bayi', 'LIKE', '%' . $this->search_query . '%'],
            ['panjang_bayi', 'LIKE', '%' . $this->search_query . '%']
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
            ['KELAHIRAN'],
            ['SID - Sistem Informasi Desa'],
            [
                __('nama_anak'),
                __('jenis_kelamin'),
                __('ayah_nama'),
                __('ayah_nik'),
                __('ibu_nama'),
                __('ibu_nik'),
                __('hari_lahir'),
                __('tempat_lahir'),
                __('tanggal_lahir'),
                __('jam_lahir'),
                __('jenis_persalinan'),
                __('anak_ke'),
                __('berat_bayi'),
                __('panjang_bayi'),
                __('tempat_dilahirkan'),
                __('penolong_kelahiran')
            ]
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        return [
            'nama_anak'             => $row->nama_anak,
            'jenis_kelamin'         => $row->jenis_kelamin->label(),
            'ayah_nama'             => $row->ayah?->nama,
            'ayah_nik'              => $row->ayah?->nik,
            'ibu_nama'              => $row->ibu?->nama,
            'ibu_nik'               => $row->ibu?->nik,
            'hari_lahir'            => $row->hari_lahir,
            'tempat_lahir'          => $row->tempat_lahir,
            'tanggal_lahir'         => Date::dateTimeToExcel(Carbon::parse($row->getAttributes()['tanggal_lahir'])), // Converts the parsed Carbon date to Excel's date format,
            'jam_lahir'             => $row->jam_lahir,
            'jenis_persalinan'      => $row->jenis_persalinan?->nama,
            'anak_ke'               => $row->anak_ke,
            'berat_bayi'            => $row->berat_bayi,
            'panjang_bayi'          => $row->panjang_bayi,
            'tempat_dilahirkan'     => $row->tempat_dilahirkan?->nama,
            'penolong_kelahiran'    => $row->penolong_kelahiran?->nama
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 0, // Number,
            'F' => 0, // Number,
            'I' => 'dd mmmm yyyy',
            'L' => 0, // Number,
            'M' => 0, // Number,
            'N' => 0, // Number
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
                $event->sheet->getStyle('M4:M'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('N4:N'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('O4:O'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('P4:P'.$lastRow)->getAlignment()->setIndent(1);

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
                        foreach (JenisKelaminEnum::cases() as $jenisKelamin) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $jenisKelamin->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($jenisKelamin->color());
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
            'title'     => 'Kelahiran'
        ];
    }
}
