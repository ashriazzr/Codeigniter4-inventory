<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelCategory;

class Category extends BaseController
{

    public function __construct()
    {
        $this->category = new ModelCategory();
    }

    public function index()
    {
        $searchbutton = $this->request->getPost('searchbutton');
        if (isset($searchbutton)) {
            $search = $this->request->getPost('search');
            session()->set('search_category', $search);
            redirect()->to('/category/index');
        } else {
            $search = session()->get('search_category');
        }
        $dataCategory = $search ? $this->category->searchData($search)->paginate(5, 'category') : $this->category->paginate(5, 'category');

        $nohalaman = $this->request->getVar('page_category') ? $this->request->getVar('page_category') : 1;

        $data = [
            'showData' => $dataCategory,
            'pager' => $this->category->pager,
            'nohalaman' => $nohalaman,
            'search' => $search
        ];
        return view('category/viewCategory', $data);
    }

    public function formAdd()
    {
        return view('category/viewFormAdd');
    }

    public function saveData()
    {
        $namecategory = $this->request->getVar('namecategory');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namecategory' => [
                'rules' => 'required',
                'label' => 'Name Category',
                'errors' => [
                    'required' => '{field} can\'t be null'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNameCategory' => '<br><div class="alert alert-danger"> ' . $validation->getError() . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/category/formAdd');
        } else {
            $this->category->insert([
                'katnama' => $namecategory
            ]);
            $pesan = [
                'success' => '<div class="alert alert-success">"Success add data category"</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/category/index');
        }
    }

    public function formEdit($id)
    {
        $rowData = $this->category->find($id);
        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['katnama']
            ];
            return view('category/formEdit', $data);
        } else {
            exit('Data not found !');
        }
    }

    public function updateData()
    {
        $namecategory = $this->request->getVar('namecategory');
        $idcategory = $this->request->getVar('idcategory');
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namecategory' => [
                'rules' => 'required',
                'label' => 'Name Category',
                'errors' => [
                    'required' => '{field} can\'t be null'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNameCategory' => '<br><div class="alert alert-danger"> ' . $validation->getError() . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/category/formEdit/' . $idcategory);
        } else {
            $this->category->update($idcategory, [
                'katnama' => $namecategory
            ]);
            $pesan = [
                'success' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Success</h5>
                 Success update data
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/category/index');
        }
    }

    public function deleteData($id)
    {
        $rowData = $this->category->find($id);
        if ($rowData) {
            $this->category->delete($id);

            $pesan = [
                'success' => '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-check"></i> Success</h5>
             Success delete data
            </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/category/index');
        } else {
            exit('Data not found !');
        }
    }
}
