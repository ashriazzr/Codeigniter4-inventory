<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelProduct;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelTempBarangMasuk;

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
                'dethargabeli' => $sellprice,
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
}
