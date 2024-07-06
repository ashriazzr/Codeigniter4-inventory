<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Laporan extends BaseController
{
    public function index()
    {
        return view('laporan/index');
    }

    public function cetak_barang_masuk()
    {
        return view('/laporan/viewBarangMasuk');
    }
}
