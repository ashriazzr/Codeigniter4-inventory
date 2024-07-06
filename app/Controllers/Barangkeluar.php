<?php

namespace App\Controllers;

use Config\Database;
use App\Controllers\BaseController;
use App\Models\ModelBarangKeluar;
use App\Models\ModelDataBarangKeluar;
use App\Models\ModelDataProduct;
use App\Models\ModelDetailBarangkeluar;
use App\Models\ModelPelanggan;
use App\Models\ModelProduct;
use App\Models\ModelTempBarangKeluar;
use CodeIgniter\HTTP\ResponseInterface;
use SebastianBergmann\Invoker\Invoker;
use Config\Services;

class BarangKeluar extends BaseController
{
    private function buatFaktur()
    {
        $realDate = date('d-m-Y');
        $modelBarangkeluar = new ModelBarangKeluar();

        $hasil = $modelBarangkeluar->noFaktur($realDate)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        //nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmY', strtotime($realDate)) . sprintf('%04s', $nextNoUrut);
        return $noFaktur;
    }

    public function buatNoFaktur()
    {
        $realDate = $this->request->getPost('tanggal');
        $modelBarangkeluar = new ModelBarangKeluar();

        $hasil = $modelBarangkeluar->noFaktur($realDate)->getRowArray();
        $data = $hasil['nofaktur'];

        $lastNoUrut = substr($data, -4);
        // nomor urut ditambah 1
        $nextNoUrut = intval($lastNoUrut) + 1;
        // membuat format nomor transaksi berikutnya
        $noFaktur = date('dmY', strtotime($realDate)) . sprintf('%04s', $nextNoUrut);

        $json = [
            'nofaktur' => $noFaktur
        ];
        echo json_encode($json);
    }
    public function index()
    {
        return view('barangKeluar/viewdata');
    }

    public function data()
    {
        return view('barangkeluar/viewdata');
    }

    public function input()
    {
        $data = [
            'nofaktur' => $this->buatFaktur()
        ];
        return view('barangKeluar/forminput', $data);
    }

    public function showDataTemp()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modalTempBarangKeluar = new ModelTempBarangKeluar();
            $dataTemp = $modalTempBarangKeluar->showDataTemp($nofaktur);
            $data = [
                'showdata' => $dataTemp
            ];

            $json = [
                'data' => view('barangKeluar/dataTemp', $data)
            ];
            echo json_encode($json);
        }
    }

    function ambilDataProduct()
    {
        if ($this->request->isAJAX()) {
            $codeproduct = $this->request->getPost('codeproduct');

            $modelProduct = new ModelProduct();

            $cekData = $modelProduct->find($codeproduct);
            if ($cekData == null) {
                $json = [
                    'error' => 'Sorry, cannot found data'
                ];
            } else {
                $data = [
                    'nameproduct' => $cekData['brgnama'],
                    'sellprice' => $cekData['brgharga'],
                ];

                $json = [
                    'success' => $data
                ];
            }
            echo json_encode($json);
        }
    }
    function saveItem()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $codeproduct = $this->request->getPost('codeproduct');
            $nameproduct = $this->request->getPost('nameproduct');
            $sellprice = $this->request->getPost('sellprice');
            $jml = $this->request->getPost('jml');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelProduct = new ModelProduct();

            $ambilDataProduct = $modelProduct->find($codeproduct);
            $stockProduct = $ambilDataProduct['brgstock'];

            if ($jml > intval($stockProduct)) {
                $json = [
                    'error' => 'Stock not ready'
                ];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detnama' => $nameproduct,
                    'detbrgkode' => $codeproduct,
                    'dethargajual' => $sellprice,
                    'detjml' => $jml,
                    'detsubtotal' => intval($jml) * intval($sellprice)
                ]);

                $json = [
                    'success' => 'Success Add Item'
                ];
            }
            echo json_encode($json);
        }
    }

    function deleteItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarangKeluar = new ModelTempBarangKeluar();
            $modelTempBarangKeluar->delete($id);
            $json = [
                'success' => 'Delete item success'
            ];

            echo json_encode($json);
        }
    }

    public function modalSearchProduct()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('barangKeluar/modalSearchProduct')
            ];
            echo json_encode($json);
        }
    }

    function listDataProduct()
    {
        $request = Services::request();
        $datamodel = new ModelDataProduct($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $buttonChoose = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"choose('" . $list->brgkode . "')\">Choose</button>";

                $row[] = $no;
                $row[] = $list->brgkode;
                $row[] = $list->brgnama;
                $row[] = number_format($list->brgharga, 0, ",", ".");
                $row[] = number_format($list->brgstock, 0, ",", ".");
                $row[] = $buttonChoose;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    function modalPayment()
    {
        if ($this->request->isAJAX()) {

            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idcustomer = $this->request->getPost('idcustomer');
            $totalprice = $this->request->getPost('totalprice');

            $modelTemp = new ModelTempBarangKeluar();
            $cekData = $modelTemp->showDataTemp($nofaktur);

            if ($cekData->getNumRows() > 0) {
                $data = [
                    'nofaktur' => $nofaktur,
                    'tglfaktur' => $tglfaktur,
                    'idcustomer' => $idcustomer,
                    'totalprice' => $totalprice,

                ];

                $json = [
                    'data' => view('barangkeluar/modalPayment', $data)
                ];
            } else {
                $json = [
                    'error' => 'Sorry, data is not available yet'
                ];
            }
            echo json_encode($json);
        }
    }

    function savePayment()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $tglfaktur = $this->request->getPost('tglfaktur');
            $idcustomer = $this->request->getPost('idcustomer');
            $totalpayment = str_replace(".", "", $this->request->getPost('totalpayment'));
            $jumlahuang = str_replace(".", "", $this->request->getPost('jumlahuang'));
            $sisauang = str_replace(".", "", $this->request->getPost('sisauang'));

            $modelBarangkeluar  = new ModelBarangKeluar();

            //simpan ke table brang keluar

            $modelBarangkeluar->insert([
                'faktur' => $nofaktur,
                'tglfaktur' => $tglfaktur,
                'idpel' => $idcustomer,
                'totalharga' => $totalpayment,
                'jumlahuang' => $jumlahuang,
                'sisauang' => $sisauang,

            ]);

            $modelTemp = new ModelTempBarangKeluar();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $nofaktur]);

            $fieldDetail = [];
            foreach ($dataTemp->getResultArray() as $row) {
                $fieldDetail[] = [
                    'detfaktur' =>  $row['detfaktur'],
                    'detbrgkode' =>  $row['detbrgkode'],
                    'dethargajual' =>  $row['dethargajual'],
                    'detjml' =>  $row['detjml'],
                    'detsubtotal' =>  $row['detsubtotal'],
                ];
            }

            $modelDetail = new ModelDetailBarangkeluar();
            $modelDetail->insertBatch($fieldDetail);

            // hapus temp

            $modelTemp->deleteData($nofaktur);

            $json = [
                'success' => 'The transaction has been successfully saved.',
                'printfaktur' => site_url('barangKeluar/printFaktur/' . $nofaktur)
            ];
            echo json_encode($json);
        }
    }
    public function printFaktur($faktur)
    {
        $modelBarangkeluar = new ModelBarangKeluar();
        $modelDetail = new ModelDetailBarangkeluar();
        $modelCustomer = new ModelPelanggan();

        $cekData = $modelBarangkeluar->find($faktur);
        $dataCustomer = $modelCustomer->find($cekData['idpel']);
        $nameCustomer = ($dataCustomer != null) ? $dataCustomer['pelnama'] : '-';

        if ($cekData != null) {
            $data = [
                'faktur' => $faktur,
                'date' => $cekData['tglfaktur'],
                'namecustomer' => $nameCustomer,
                'detailproduct' => $modelDetail->showDataTemp($faktur),
                'jumlahuang' => $cekData['jumlahuang'],
                'sisauang' => $cekData['sisauang'],

            ];
            return view('barangkeluar/printFaktur', $data);
        } else {
            return redirect()->to(site_url('barangkeluar/niput'));
        }
    }

    public function listData()
    {
        $tglawal = $this->request->getPost('tglawal');
        $tglakhir = $this->request->getPost('tglakhir');

        $request = Services::request();
        $datamodel = new ModelDataBarangKeluar($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables($tglawal, $tglakhir);
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $buttonPrint = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"print('" . $list->faktur . "')\"><i class=\"fa fa-print\"></i></button>";
                $buttonDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->faktur . "')\"><i class=\"fa fa-trash-alt\"></i></button>";
                $buttonEdit = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit('" . $list->faktur . "')\"><i class=\"fa fa-edit\"></i></button>";


                $row[] = $no;
                $row[] = $list->faktur;
                $row[] = $list->tglfaktur;
                $row[] = $list->pelnama;
                $row[] = number_format($list->totalharga, 0, ",", ".");
                $row[] = $buttonPrint . " " . $buttonDelete . ' ' . $buttonEdit;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all($tglawal, $tglakhir),
                "recordsFiltered" => $datamodel->count_filtered($tglawal, $tglakhir),
                "data" => $data
            ];
            echo json_encode($output);
        }
    }
    function deleteTransaction()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelBarangkeluar = new ModelBarangKeluar();
            $db = \Config\Database::connect();
            $db->table('detail_barangkeluar')->delete(['detfaktur' => $faktur]);
            $modelBarangkeluar->delete($faktur);

            $json = [
                'success' => 'Success delete Transaction'
            ];
            echo json_encode($json);
        }
    }

    public function edit($faktur)
    {
        $modelBarangkeluar = new ModelBarangKeluar();
        $modelCustomer = new ModelPelanggan();
        $rowData = $modelBarangkeluar->find($faktur);
        $rowCustomer = $modelCustomer->find($rowData['idpel']);

        $data = [
            'nofaktur' => $faktur,
            'tanggal' => $rowData['tglfaktur'],
            'namecustomer' => $rowCustomer['pelnama'],

        ];
        return view('barangkeluar/formEdit', $data);
    }
    function ambilTotalPrice()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $modelDetail = new ModelDetailBarangkeluar();

            $totalPrice = $modelDetail->ambilTotalPrice($nofaktur);
            $json = [
                'totalprice' => "Rp. " . number_format($totalPrice, 0, ",", ".")
            ];
            echo json_encode($json);
        }
    }
    function showDataDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');

            $modelDetail = new ModelDetailBarangkeluar();
            $dataTemp = $modelDetail->showDataTemp($nofaktur);
            $data = [
                'showdata' => $dataTemp
            ];

            $json = [
                'data' => view('barangKeluar/datadetail', $data)
            ];
            echo json_encode($json);
        }
    }

    function deleteItemDetail()
    {

        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelDetail = new ModelDetailBarangkeluar();
            $modelBarangkeluar = new ModelBarangKeluar();

            $rowData = $modelDetail->find($id);
            $noFaktur = $rowData['detfaktur'];

            $modelDetail->delete($id);
            $totalPrice = $modelDetail->ambilTotalPrice($noFaktur);
            // LAKUKAN UPDATE TOTAL PRICE
            $modelBarangkeluar->update($noFaktur, [
                'totalharga' => $totalPrice
            ]);


            $json = [
                'success' => 'Delete item success'
            ];

            echo json_encode($json);
        }
    }
    function editItem()
    {
        if ($this->request->isAJAX()) {
            $iddetail = $this->request->getPost('iddetail');
            $jml = $this->request->getPost('jml');

            $modelDetail = new ModelDetailBarangkeluar();
            $modelBarangkeluar = new ModelBarangKeluar();

            $rowData = $modelDetail->find($iddetail);
            $noFaktur = $rowData['detfaktur'];
            $sellPrice = $rowData['dethargajual'];


            // melakukan update pada tabel detail
            $modelDetail->update($iddetail, [
                'detjml' => $jml,
                'detsubtotal' => intval($sellPrice) * $jml

            ]);

            // ambil total price
            $totalPrice = $modelDetail->ambilTotalPrice($noFaktur);
            //UPDATE BARANG KELUAR

            $modelBarangkeluar->update($noFaktur, [
                'totalharga' => $totalPrice
            ]);
            $json = [
                'success' => 'Success update Item'
            ];
            echo json_encode($json);
        }
    }

    function saveItemDetail()
    {
        if ($this->request->isAJAX()) {
            $nofaktur = $this->request->getPost('nofaktur');
            $codeproduct = $this->request->getPost('codeproduct');
            $nameproduct = $this->request->getPost('nameproduct');
            $sellprice = $this->request->getPost('sellprice');
            $jml = $this->request->getPost('jml');

            $modelTempBarangKeluar = new ModelDetailBarangkeluar();
            $modelProduct = new ModelProduct();

            $ambilDataProduct = $modelProduct->find($codeproduct);
            $stockProduct = $ambilDataProduct['brgstock'];

            if ($jml > intval($stockProduct)) {
                $json = [
                    'error' => 'Stock not ready'
                ];
            } else {
                $modelTempBarangKeluar->insert([
                    'detfaktur' => $nofaktur,
                    'detnama' => $nameproduct,
                    'detbrgkode' => $codeproduct,
                    'dethargajual' => $sellprice,
                    'detjml' => $jml,
                    'detsubtotal' => $jml * $sellprice
                ]);

                $modelBarangkeluar = new ModelBarangKeluar();
                // ambil total price
                $totalPrice = $modelTempBarangKeluar->ambilTotalPrice($nofaktur);
                //UPDATE BARANG KELUAR

                $modelBarangkeluar->update($nofaktur, [
                    'totalharga' => $totalPrice
                ]);

                $json = [
                    'success' => 'Success Add Item'
                ];
            }
            echo json_encode($json);
        }
    }
}
