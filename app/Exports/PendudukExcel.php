<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Penduduk;
use App\Enums\JenisKelaminEnum;
use App\Enums\AkteKelahiranEnum;
use App\Enums\StatusPendudukEnum;
use App\Enums\IdentitasElektronikEnum;
use App\Enums\KelainanFisikMentalEnum;
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

class PendudukExcel implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithColumnFormatting, WithProperties
{
    use Exportable;

    // public function __construct($search_query)
    // {
    //     $this->search_query = $search_query;
    // }

    public function query()
    {
        return Penduduk::with(['agama','hubungan_keluarga','pendidikan','kawin','akseptor_kb','pekerjaan','sakit_menahun','cacat','golongan_darah','warganegara','asuransi','status_dasar','suku','kursus','bahasa']);

/*
        // TODO : Has -> WhereHas -> orWhereHas
        return Penduduk::with(['agama','hubungan_keluarga','pendidikan','kawin','akseptor_kb','pekerjaan','sakit_menahun','cacat','golongan_darah','warganegara','asuransi','status_dasar','suku','kursus','bahasa'])query()->where([
            ['nama', 'LIKE', '%' . $this->search_query . '%'],
            ['nik', 'LIKE', '%' . $this->search_query . '%'],
            ['tempat_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['tanggal_lahir', 'LIKE', '%' . $this->search_query . '%'],
            ['jenis_kelamin', 'LIKE', '%' . $this->search_query . '%'],
            ['telepon', 'LIKE', '%' . $this->search_query . '%'],
            ['email', 'LIKE', '%' . $this->search_query . '%'],
            ['identitas_elektronik', 'LIKE', '%' . $this->search_query . '%'],
            ['rt', 'LIKE', '%' . $this->search_query . '%'],
            ['rw', 'LIKE', '%' . $this->search_query . '%'],
            ['alamat', 'LIKE', '%' . $this->search_query . '%'],
            ['kodepos', 'LIKE', '%' . $this->search_query . '%'],
            ['nik_ayah', 'LIKE', '%' . $this->search_query . '%'],
            ['nama_ayah', 'LIKE', '%' . $this->search_query . '%'],
            ['nik_ibu', 'LIKE', '%' . $this->search_query . '%'],
            ['nama_ibu', 'LIKE', '%' . $this->search_query . '%'],
            ['akte_kelahiran', 'LIKE', '%' . $this->search_query . '%'],
            ['kelainan_fisik_mental', 'LIKE', '%' . $this->search_query . '%'],
            ['status_penduduk', 'LIKE', '%' . $this->search_query . '%']
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
            ['PENDUDUK'],
            ['SID - Sistem Informasi Desa'],
            [
                __('nama'),
                __('nik'),
                __('tempat_lahir'),
                __('tanggal_lahir'),
                __('jenis_kelamin'),
                __('agama'),
                __('telepon'),
                __('email'),
                __('identitas_elektronik'),
                __('hubungan_keluarga'),
                __('rt'),
                __('rw'),
                __('alamat'),
                __('kodepos'),
                __('pendidikan'),
                __('nik_ayah'),
                __('nama_ayah'),
                __('nik_ibu'),
                __('nama_ibu'),
                __('akte_kelahiran'),
                __('kawin'),
                __('akseptor_kb'),
                __('pekerjaan'),
                __('sakit_menahun'),
                __('cacat'),
                __('kelainan_fisik_mental'),
                __('golongan_darah'),
                __('warganegara'),
                __('asuransi'),
                __('status_penduduk'),
                __('status_dasar'),
                __('suku'),
                __('kursus'),
                __('bahasa')
            ]
        ];
    }

    /**
     * Map each row of the collection to an array for export.
     */
    public function map($row): array
    {
        return [
            'nama'                     => $row->nama,
            'nik'                      => $row->nik,
            'tempat_lahir'             => $row->tempat_lahir,
            'tanggal_lahir'            => Date::dateTimeToExcel(Carbon::parse($row->getAttributes()['tanggal_lahir'])), // Converts the parsed Carbon date to Excel's date format,
            'jenis_kelamin'            => $row->jenis_kelamin->label(),
            'agama'                    => $row->agama?->nama,
            'telepon'                  => $row->telepon,
            'email'                    => $row->email,
            'identitas_elektronik'     => $row->identitas_elektronik->label(),
            'hubungan_keluarga'        => $row->hubungan_keluarga?->nama,
            'rt'                       => $row->rt,
            'rw'                       => $row->rw,
            'alamat'                   => $row->alamat,
            'kodepos'                  => $row->kodepos,
            'pendidikan'               => $row->pendidikan?->nama,
            'nik_ayah'                 => $row->nik_ayah,
            'nama_ayah'                => $row->nama_ayah,
            'nik_ibu'                  => $row->nik_ibu,
            'nama_ibu'                 => $row->nama_ibu,
            'akte_kelahiran'           => $row->akte_kelahiran->label(),
            'kawin'                    => $row->kawin?->nama,
            'akseptor_kb'              => $row->akseptor_kb?->nama,
            'pekerjaan'                => $row->pekerjaan?->nama,
            'sakit_menahun'            => $row->sakit_menahun?->nama,
            'cacat'                    => $row->cacat?->nama,
            'kelainan_fisik_mental'    => $row->kelainan_fisik_mental->label(),
            'golongan_darah'           => $row->golongan_darah?->nama,
            'warganegara'              => $row->warganegara?->nama,
            'asuransi'                 => $row->asuransi?->nama,
            'status_penduduk'          => $row->status_penduduk->label(),
            'status_dasar'             => $row->status_dasar?->nama,
            'suku'                     => $row->suku?->nama,
            'kursus'                   => $row->kursus?->nama,
            'bahasa'                   => $row->bahasa?->nama
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => 0, // Number,
            'D' => 'dd mmmm yyyy',
            'K' => 0, // Number,
            'L' => 0, // Number,
            'N' => 0, // Number,
            'P' => 0, // Number,
            'R' => 0, // Number
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
                $event->sheet->getStyle('Q4:Q'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('R4:R'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('S4:S'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('T4:T'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('U4:U'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('V4:V'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('W4:W'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('X4:X'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('Y4:Y'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('Z4:Z'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AA4:AA'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AB4:AB'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AC4:AC'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AD4:AD'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AE4:AE'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AF4:AF'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AG4:AG'.$lastRow)->getAlignment()->setIndent(1);
                $event->sheet->getStyle('AH4:AH'.$lastRow)->getAlignment()->setIndent(1);

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
                foreach ($event->sheet->getColumnIterator('E') as $column) {
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
                // Iterasi setiap row dan terapkan warna
                foreach ($event->sheet->getColumnIterator('I') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (IdentitasElektronikEnum::cases() as $identitasElektronik) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $identitasElektronik->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($identitasElektronik->color());
                                break; // Keluar dari loop setelah cocok
                            }
                        }
                    }
                }
                // Iterasi setiap row dan terapkan warna
                foreach ($event->sheet->getColumnIterator('T') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (AkteKelahiranEnum::cases() as $akteKelahiran) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $akteKelahiran->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($akteKelahiran->color());
                                break; // Keluar dari loop setelah cocok
                            }
                        }
                    }
                }
                // Iterasi setiap row dan terapkan warna
                foreach ($event->sheet->getColumnIterator('Z') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (KelainanFisikMentalEnum::cases() as $kelainanFisikMental) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $kelainanFisikMental->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($kelainanFisikMental->color());
                                break; // Keluar dari loop setelah cocok
                            }
                        }
                    }
                }
                // Iterasi setiap row dan terapkan warna
                foreach ($event->sheet->getColumnIterator('AD') as $column) {
                    foreach ($column->getCellIterator() as $cell) {
                        foreach (StatusPendudukEnum::cases() as $statusPenduduk) {
                            // Bandingkan dengan label
                            if ($cell->getValue() === $statusPenduduk->label()) {
                                $event->sheet->getStyle($cell->getCoordinate())->getFont()->getColor()->setARGB($statusPenduduk->color());
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
            'title'     => 'Penduduk'
        ];
    }
}
