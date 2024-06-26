<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduct;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelTempBarangMasuk;
use App\Models\ModelBarangMasuk;
use App\Models\ModelDetailBarangMasuk;

class BarangMasuk extends BaseController
{
    public function index()
    {
        return view('barangMasuk/formInput');
    }

    function dataTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');

            $modelTemp = new ModelTempBarangMasuk();
            $data = [
                'dataTemp' => $modelTemp->showDataTemp($faktur)
            ];

            $json = [
                'data' => view('barangMasuk/dataTemp', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Sorry, the data cannot be retrieved.');
        }
    }

    public function ambilDataBarang()
    {
        if ($this->request->isAJAX()) {
            $codeproduct = $this->request->getPost('codeproduct');

            $modelProduct = new ModelProduct();
            $ambilData = $modelProduct->find($codeproduct);

            if ($ambilData == NULL) {
                $json = [
                    'error' => 'Data not found!'
                ];
            } else {
                $data = [
                    'nameproduct' => $ambilData['brgnama'],
                    'sellprice' => $ambilData['brgharga']
                ];

                $json = [
                    'success' => $data
                ];
            }

            echo json_encode($json);
        } else {
            exit('Data product is not found !');
        }
    }
    function simpanTemp()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $sellprice = $this->request->getPost('sellprice');
            $buyprice = $this->request->getPost('buyprice');
            $codeproduct = $this->request->getPost('codeproduct');
            $total = $this->request->getPost('total');

            $modelTempBarang = new ModelTempBarangMasuk();

            $modelTempBarang->insert([
                'detfaktur' => $faktur,
                'detbrgkode' => $codeproduct,
                'dethargamasuk' => $buyprice,
                'dethargajual' => $sellprice,
                'detjml' => $total,
                'detsubtotal' => intval($total) * intval($buyprice)
            ]);

            $json = [
                'success' => 'The addition has been successfully processed!'
            ];
            echo json_encode($json);
        } else {
            exit('Data product is not found !');
        }
    }
    function deleteItem()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelTempBarang = new ModelTempBarangMasuk();
            $modelTempBarang->delete($id);

            $json = [
                'success' => 'The item has been successfully deleted'
            ];
            echo json_encode($json);
        } else {
            exit('Data product is not found !');
        }
    }

    function searchDataProduct()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('/barangMasuk/modalSearchProduct')
            ];
            echo json_encode($json);
        } else {
            exit('Data product is not found !');
        }
    }

    function detailSearchProduct()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getPost('search');

            $modalProduct = new ModelProduct();

            $data = $modalProduct->showData_search($search)->get();
            if ($data != null) {
                $json = [
                    'data' => view('barangMasuk/detailDataProduct', [
                        'showData' => $data
                    ])
                ];
                echo json_encode($json);
            }
        } else {
            exit('Data product is not found !');
        }
    }

    function endTransaction()
    {
        if ($this->request->isAJAX()) {
            $faktur = $this->request->getPost('faktur');
            $tglfaktur = $this->request->getPost('tglfaktur');

            $modelTemp = new ModelTempBarangMasuk();
            $dataTemp = $modelTemp->getWhere(['detfaktur' => $faktur]);

            if ($dataTemp->getNumRows() == 0) {
                $json = [
                    'error' => 'Item data for this acture is not yet available'
                ];
            } else {
                // simpan ke tabel barang masuk
                $modelBarangMasuk = new ModelBarangMasuk();
                $totalSubtotal = 0;

                foreach ($dataTemp->getResultArray() as $total) :
                    $totalSubtotal += intval($total['detsubtotal']);
                endforeach;

                $modelBarangMasuk->insert([
                    'faktur' => $faktur,
                    'tglfaktur' => $tglfaktur,
                    'totalharga' => $totalSubtotal
                ]);

                //SIMPAN KE DETAIL BARANG MASUK
                $modelDetailBarangMasuk = new ModelDetailBarangMasuk();
                foreach ($dataTemp->getResultArray() as $row) :
                    $modelDetailBarangMasuk->insert([
                        'detfaktur' => $row['detfaktur'],
                        'detbrgkode' => $row['detbrgkode'],
                        'dethargamasuk' => $row['dethargamasuk'],
                        'dethargajual' => $row['dethargajual'],
                        'detjml' => $row['detjml'],
                        'detsubtotal' => $row['detsubtotal'],
                    ]);
                endforeach;

                // HAPUS DATA YANG ADA DOI TABEL TEMP BERDASAR FAKTUR

                $modelTemp->emptyTable();

                $json = [
                    'success' => 'The item has been successfully deleted'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Data product is not found !');
        }
    }
}
