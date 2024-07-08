<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelBarangMasuk;
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
    public function cetak_barang_keluar()
    {
        return view('/laporan/viewBarangKeluar');
    }

    public function print_product_income_period()
    {
        $firstDate = $this->request->getPost('firstDate');
        $lastDate = $this->request->getPost('lastDate');

        $modelBarangkeluar = new ModelBarangMasuk();
        $dataLaporan = $modelBarangkeluar->laporanPeriode($firstDate, $lastDate);

        $data = [
            'datalaporan' => $dataLaporan,
            'firstDate' => $firstDate,
            'lastDate' => $lastDate
        ];
        return view('laporan/printReportIncomingGoods', $data);
    }
    public function print_product_outgoing_period()
    {
        $firstDate = $this->request->getPost('firstDate');
        $lastDate = $this->request->getPost('lastDate');

        $modelBarangMasuk = new ModelBarangKeluar();
        $dataLaporan = $modelBarangMasuk->laporanPeriode($firstDate, $lastDate);

        $data = [
            'datalaporan' => $dataLaporan,
            'firstDate' => $firstDate,
            'lastDate' => $lastDate
        ];
        return view('laporan/printReportOutgoingGoods', $data);
    }

    public function tampilGrafikBarangMasuk()
    {
        $bulan = $this->request->getPost('bulan');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT tglfaktur AS tgl, totalharga FROM barangmasuk WHERE DATE_FORMAT(tglfaktur, '%Y-%m') = '$bulan' ORDER BY tglfaktur ASC")->getResult();

        $data = [
            'grafik' => $query
        ];
        $json = [
            'data' => view('laporan/grafikBarangMasuk', $data)
        ];
        echo json_encode($json);
    }
}
