<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:09
 */
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PENDUDUK</title>
    <style>
    @media print {
        body {
            -print-color-adjust: exact;
        }
    }

    @page {
        size: A4 landscape;
        -webkit-print-color-adjust: exact;
    }

    h2,
    h3 {
        text-align: center;
        font-weight: bold;
        color: #6777ef;
    }

    table {
        border-collapse: collapse;
        font-size: 0.9em;
        font-family: sans-serif;
        width: 100%;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }

    table thead tr {
        background-color: #6777ef;
        color: #ffffff;
        text-align: left;
    }

    table th {
        white-space: nowrap;
    }

    table th,
    table td {
        padding: 5px;
    }

    table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    table tbody tr:last-of-type {
        border-bottom: 2px solid #6777ef;
    }

    .badge-primary {
        background-color: #6777ef;
    }

    .badge-secondary {
        background-color: #cdd3d8;
    }

    .badge-success {
        background-color: #47c363;
    }

    .badge-danger {
        background-color: #fc544b;
    }

    .badge-warning {
        background-color: #ffa426;
    }

    .badge-info {
        background-color: #3abaf4;
    }

    .badge-cobalt {
        background-color: #005ca9;
    }

    .badge-lavender {
        background-color: #9c88ff;
    }

    .badge {
        color: #fff;
        vertical-align: middle;
        padding: 4px 10px !important;
        font-weight: 600;
        letter-spacing: 0.3px;
        font-size: 12px;
        border-radius: 5px !important;
        padding: 4px 10px !important;
    }
    </style>
</head>

<body onload="window.print(); ">
    <!-- window.close(); -->
    <h2>PENDUDUK</h2>
    <h3>SID - Sistem Informasi Desa</h3>
    <table>
        <thead>
            <tr>
                <th>{{ __('nama') }}</th>
                <th>{{ __('nik') }}</th>
                <th>{{ __('tempat_lahir') }}</th>
                <th>{{ __('tanggal_lahir') }}</th>
                <th>{{ __('jenis_kelamin') }}</th>
                <th>{{ __('agama') }}</th>
                <th>{{ __('telepon') }}</th>
                <th>{{ __('email') }}</th>
                <th>{{ __('identitas_elektronik') }}</th>
                <th>{{ __('hubungan_keluarga') }}</th>
                <th>{{ __('rt') }}</th>
                <th>{{ __('rw') }}</th>
                <th>{{ __('alamat') }}</th>
                <th>{{ __('kodepos') }}</th>
                <th>{{ __('pendidikan') }}</th>
                <th>{{ __('nik_ayah') }}</th>
                <th>{{ __('nama_ayah') }}</th>
                <th>{{ __('nik_ibu') }}</th>
                <th>{{ __('nama_ibu') }}</th>
                <th>{{ __('akte_kelahiran') }}</th>
                <th>{{ __('kawin') }}</th>
                <th>{{ __('akseptor_kb') }}</th>
                <th>{{ __('pekerjaan') }}</th>
                <th>{{ __('sakit_menahun') }}</th>
                <th>{{ __('cacat') }}</th>
                <th>{{ __('kelainan_fisik_mental') }}</th>
                <th>{{ __('golongan_darah') }}</th>
                <th>{{ __('warganegara') }}</th>
                <th>{{ __('asuransi') }}</th>
                <th>{{ __('status_penduduk') }}</th>
                <th>{{ __('status_dasar') }}</th>
                <th>{{ __('suku') }}</th>
                <th>{{ __('kursus') }}</th>
                <th>{{ __('bahasa') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penduduk as $data)
            <tr>
                <td>{{ $data->nama }}</td>
                <td align="right">{{ $data->nik }}</td>
                <td>{{ $data->tempat_lahir }}</td>
                <td>{{ $data->tanggal_lahir }}</td>
                <td>{!! $data->jenis_kelamin->badge() !!}</td>
                <td>{{ $data->agama?->nama }}</td>
                <td>{{ $data->telepon }}</td>
                <td>{{ $data->email }}</td>
                <td>{!! $data->identitas_elektronik->badge() !!}</td>
                <td>{{ $data->hubungan_keluarga?->nama }}</td>
                <td align="right">{{ $data->rt }}</td>
                <td align="right">{{ $data->rw }}</td>
                <td>{{ $data->alamat }}</td>
                <td align="right">{{ $data->kodepos }}</td>
                <td>{{ $data->pendidikan?->nama }}</td>
                <td align="right">{{ $data->nik_ayah }}</td>
                <td>{{ $data->nama_ayah }}</td>
                <td align="right">{{ $data->nik_ibu }}</td>
                <td>{{ $data->nama_ibu }}</td>
                <td>{!! $data->akte_kelahiran->badge() !!}</td>
                <td>{{ $data->kawin?->nama }}</td>
                <td>{{ $data->akseptor_kb?->nama }}</td>
                <td>{{ $data->pekerjaan?->nama }}</td>
                <td>{{ $data->sakit_menahun?->nama }}</td>
                <td>{{ $data->cacat?->nama }}</td>
                <td>{!! $data->kelainan_fisik_mental->badge() !!}</td>
                <td>{{ $data->golongan_darah?->nama }}</td>
                <td>{{ $data->warganegara?->nama }}</td>
                <td>{{ $data->asuransi?->nama }}</td>
                <td>{!! $data->status_penduduk->badge() !!}</td>
                <td>{{ $data->status_dasar?->nama }}</td>
                <td>{{ $data->suku?->nama }}</td>
                <td>{{ $data->kursus?->nama }}</td>
                <td>{{ $data->bahasa?->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>