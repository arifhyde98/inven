<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function show($page = 'index')
    {
        $allowedPages = ['index', 'pemesanan', 'jual_barang', 'cetak_barcode', 'stok_opname', 'data_cicilan', 'penjelasan'];
        if (!in_array($page, $allowedPages)) {
            $page = 'index';
        }

        return view("dokumentasi.{$page}", compact('page'));
    }
}
