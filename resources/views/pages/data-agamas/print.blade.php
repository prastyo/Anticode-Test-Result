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
    <title>DATA AGAMA</title>
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
    <h2>DATA AGAMA</h2>
    <h3>SID - Sistem Informasi Desa</h3>
    <table>
        <thead>
            <tr>
                <th>{{ __('nama') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataAgama as $data)
            <tr>
                <td>{{ $data->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>