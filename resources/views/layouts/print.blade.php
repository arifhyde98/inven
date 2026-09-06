<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cetak Dokumen') &mdash; {{ \App\Models\PengaturanUmum::first()->nama_perusahaan ?? 'JInventory' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #333;
            background: #fff;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 0;
            }
        }
        .thermal-receipt {
            max-width: 320px;
            margin: auto;
            font-size: 12px;
            font-family: monospace;
        }
        .table-condensed td, .table-condensed th {
            padding: 4px 6px;
        }
    </style>
    @stack('styles')
</head>
<body onload="window.print()">
    <div class="container-fluid py-3">
        <div class="row no-print mb-3">
            <div class="col-12 text-right">
                <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Cetak Dokumen</button>
                <button onclick="window.close()" class="btn btn-secondary"><i class="fas fa-times"></i> Tutup</button>
            </div>
        </div>
        @yield('content')
    </div>
</body>
</html>
