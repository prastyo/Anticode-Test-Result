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
    <title>KELAHIRAN</title>
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
    <h2>KELAHIRAN</h2>
    <h3>SID - Sistem Informasi Desa</h3>
    <table>
        <thead>
            <tr>
                <th>{{ __('nama_anak') }}</th>
                <th>{{ __('jenis_kelamin') }}</th>
                <th>{{ __('ayah_nama') }}</th>
                <th>{{ __('ayah_nik') }}</th>
                <th>{{ __('ibu_nama') }}</th>
                <th>{{ __('ibu_nik') }}</th>
                <th>{{ __('hari_lahir') }}</th>
                <th>{{ __('tempat_lahir') }}</th>
                <th>{{ __('tanggal_lahir') }}</th>
                <th>{{ __('jam_lahir') }}</th>
                <th>{{ __('jenis_persalinan') }}</th>
                <th>{{ __('anak_ke') }}</th>
                <th>{{ __('berat_bayi') }}</th>
                <th>{{ __('panjang_bayi') }}</th>
                <th>{{ __('tempat_dilahirkan') }}</th>
                <th>{{ __('penolong_kelahiran') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelahiran as $data)
            <tr>
                <td>{{ $data->nama_anak }}</td>
                <td>{!! $data->jenis_kelamin->badge() !!}</td>
                <td>{{ $data->ayah?->nama }}</td>
                <td>{{ $data->ayah?->nik }}</td>
                <td>{{ $data->ibu?->nama }}</td>
                <td>{{ $data->ibu?->nik }}</td>
                <td>{{ $data->hari_lahir }}</td>
                <td>{{ $data->tempat_lahir }}</td>
                <td>{{ $data->tanggal_lahir }}</td>
                <td>{{ $data->jam_lahir }}</td>
                <td>{{ $data->jenis_persalinan?->nama }}</td>
                <td>{{ $data->anak_ke }}</td>
                <td>{{ $data->berat_bayi }}</td>
                <td>{{ $data->panjang_bayi }}</td>
                <td>{{ $data->tempat_dilahirkan?->nama }}</td>
                <td>{{ $data->penolong_kelahiran?->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>