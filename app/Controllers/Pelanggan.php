<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDataCustomer;
use App\Models\ModelPelanggan;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Pelanggan extends BaseController
{
    public function index()
    {
        //
    }

    public function formTambah()
    {
        $json = ['data' => view('pelanggan/modalAddCustomer')];
        echo json_encode($json);
    }

    public function save()
    {
        $namecustomer = $this->request->getPost('namecust');
        $telp = $this->request->getPost('telp');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namecust' => [
                'rules' => 'required',
                'label' => 'Name Customer',
                'errors' => [
                    'required' => '{field} can\'t be empty'
                ]
            ],
            'telp' => [
                'rules' => 'required|is_unique[pelanggan.peltelp]',
                'label' => 'Contact Number',
                'errors' => [
                    'required' => '{field} can\'t be empty',
                    'is_unique' => '{field} The phone number must not be the same'
                ]
            ],

        ]);
        if (!$valid) {
            $json = [
                'error' => [
                    'errNameCustomer' => $validation->getError('namecust'),
                    'errTelp' => $validation->getError('telp'),
                ]
            ];
        } else {
            $modelCustomer = new ModelPelanggan();

            $modelCustomer->insert([
                'pelnama' => $namecustomer,
                'peltelp' => $telp
            ]);

            $rowData = $modelCustomer->ambilLastData()->getRowArray();

            $json = [
                'success' => 'Customer data is successfully saved. Call the data?',
                'namecustomer' => $rowData['pelnama'],
                'idcustomer' => $rowData['pelid']
            ];
        }
        echo json_encode($json);
    }

    public function modalData()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('pelanggan/modaldata')
            ];
            echo json_encode($json);
        }
    }

    public function listData()
    {
        $request = Services::request();
        $datamodel = new ModelDataCustomer($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $buttonChoose = "<button type=\"button\" class=\"btn btn-sm btn-info\" onclick=\"choose('" . $list->pelid . "','" . $list->pelnama . "')\">Choose</button>";
                $buttonDelete = "<button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"hapus('" . $list->pelid . "','" . $list->pelnama . "')\">Delete</button>";


                $row[] = $no;
                $row[] = $list->pelnama;
                $row[] = $list->peltelp;
                $row[] = $buttonChoose . " " . $buttonDelete;
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

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $modelCustomer = new ModelPelanggan();
            $modelCustomer->delete($id);

            $json = [
                'success' => 'Success delete data Customer'
            ];

            echo json_encode($json);
        }
    }
}
