<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ModelProduct;
use App\Models\ModelCategory;
use App\Models\ModelUnit;

class Product extends BaseController
{

    public function __construct()
    {
        $this->product = new ModelProduct();
        $this->category = new ModelCategory();
        $this->unit = new ModelUnit();
    }

    public function index()
    {
        $searchbutton = $this->request->getPost('searchbutton');
        if (isset($searchbutton)) {
            $search = $this->request->getPost('search');
            session()->set('search_product', $search);
            redirect()->to('/product/index');
        } else {
            $search = session()->get('search_product');
        }

        $totalData = $search ? $this->product->showData_search($search)->countAllResults() : $this->product->showData()->countAllResults();

        $dataProduct = $search ? $this->product->showData_search($search)->paginate(10, 'product') : $this->product->showData()->paginate(10, 'product');

        $nohalaman = $this->request->getVar('page_product') ? $this->request->getVar('page_product') : 1;

        $data = [
            'showData' => $dataProduct,
            'pager' => $this->product->pager,
            'nohalaman' => $nohalaman,
            'totalData' => $totalData,
            'search' => $search
        ];
        return view('product/viewProduct', $data);
    }

    public function addProduct()
    {
        $modelcategory = new ModelCategory();
        $modelunit = new ModelUnit();
        $data = [
            'datacategory' => $modelcategory->findAll(),
            'dataunit' => $modelunit->findAll()
        ];
        return view('product/formAddProduct', $data);
    }

    public function saveData()
    {

        $codeproduct = $this->request->getVar('codeproduct');
        $nameproduct = $this->request->getVar('nameproduct');
        $category = $this->request->getVar('category');
        $unit = $this->request->getVar('unit');
        $price = $this->request->getVar('price');
        $stock = $this->request->getVar('stock');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'codeproduct' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Code Product',
                'errors' => [
                    'required' => '{field} Data cannot be empty',
                    'is_unique' => '{field} Data already exists'
                ]
            ],
            'nameproduct' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Name Product',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'category' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Category',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'unit' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Unit',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'price' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Price',
                'errors' => [
                    'required' => '{field} Data cannot be empty',
                    'numeric' => '{field} Only in the form of numbers'
                ]
            ],
            'stock' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Stock',
                'errors' => [
                    'required' => '{field} Data cannot be empty',
                    'numeric' => '{field} Only in the form of numbers'
                ]
            ],
            'image' => [
                'rules' => 'mime_in[image,image/png,image/jpg,image/jpeg]|ext_in[image,png,jpg,gif,jpeg]',
                'label' => 'Image'
            ]

        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                  ' . $validation->listErrors() . '
                </div>'
            ];
            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/product/addProduct');
        } else {
            $image = $_FILES['image']['name'];
            if ($image != NULL) {
                $nameFileImage = $codeproduct;
                $fileImage = $this->request->getFile('image');
                $fileImage->move('upload', $nameFileImage . '.' . $fileImage->getExtension());

                $pathImage = 'upload/' . $fileImage->getName();
            } else {
                $pathImage = '';
            }

            $this->product->insert([
                'brgkode' => $codeproduct,
                'brgnama' => $nameproduct,
                'brgkatid' => $category,
                'brgsatid' => $unit,
                'brgharga' => $price,
                'brgstock' => $stock,
                'brggambar' => $pathImage

            ]);

            $pesan_success = [
                'success' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Success!</h5>
                The data with code <strong>' . $codeproduct . '</strong> has been successfully saved.
                </div>'
            ];
            session()->setFlashdata($pesan_success);
            return redirect()->to('/product/addProduct');
        }
    }

    public function editProduct($code)
    {
        $cekData = $this->product->find($code);
        if ($cekData) {

            $modelcategory = new ModelCategory();
            $modelunit = new ModelUnit();

            $data = [
                'codeproduct' => $cekData['brgkode'],
                'nameproduct' => $cekData['brgnama'],
                'category' => $cekData['brgkatid'],
                'unit' => $cekData['brgsatid'],
                'price' => $cekData['brgharga'],
                'stock' => $cekData['brgstock'],
                'datacategory' => $modelcategory->findAll(),
                'dataunit' => $modelunit->findAll(),
                'image' => $cekData['brggambar']

            ];
            return view('/product/formEditProduct', $data);
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-ban"></i> Sorry!</h5>
           Data product is not found !
            </div>'
            ];
            session()->setFlashdata($pesan_error);
            return redirect()->to('/product/index');
        }
    }

    public function updateData()
    {

        $codeproduct = $this->request->getVar('codeproduct');
        $nameproduct = $this->request->getVar('nameproduct');
        $category = $this->request->getVar('category');
        $unit = $this->request->getVar('unit');
        $price = $this->request->getVar('price');
        $stock = $this->request->getVar('stock');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'nameproduct' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Name Product',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'category' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Category',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'unit' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Unit',
                'errors' => [
                    'required' => '{field} Data cannot be empty'
                ]
            ],
            'price' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Price',
                'errors' => [
                    'required' => '{field} Data cannot be empty',
                    'numeric' => '{field} Only in the form of numbers'
                ]
            ],
            'stock' => [
                'rules' => 'required|is_unique[product.brgkode]',
                'label' => 'Stock',
                'errors' => [
                    'required' => '{field} Data cannot be empty',
                    'numeric' => '{field} Only in the form of numbers'
                ]
            ],
            'image' => [
                'rules' => 'mime_in[image,image/png,image/jpg,image/jpeg]|ext_in[image,png,jpg,gif,jpeg]',
                'label' => 'Image'
            ]

        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                  ' . $validation->listErrors() . '
                </div>'
            ];
            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/product/addProduct');
        } else {
            $cekData = $this->product->find($codeproduct);
            $pathImagePast = $cekData['brggambar'];

            $image = $_FILES['image']['name'];

            if ($image != NULL) {
                if ($pathImagePast && file_exists($pathImagePast)) {
                    unlink($pathImagePast);
                }
                $nameFileImage = $codeproduct;
                $fileImage = $this->request->getFile('image');
                $fileImage->move('upload', $nameFileImage . '.' . $fileImage->getExtension());

                $pathImage = 'upload/' . $fileImage->getName();
            } else {
                $pathImage = $pathImagePast;
            }

            $this->product->update($codeproduct, [
                'brgnama' => $nameproduct,
                'brgkatid' => $category,
                'brgsatid' => $unit,
                'brgharga' => $price,
                'brgstock' => $stock,
                'brggambar' => $pathImage

            ]);

            $pesan_success = [
                'success' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Success!</h5>
                The data with code <strong>' . $codeproduct . '</strong> has been successfully update.
                </div>'
            ];
            session()->setFlashdata($pesan_success);
            return redirect()->to('/product/index');
        }
    }

    public function deleteData($code)
    {
        $cekData = $this->product->find($code);
        if ($cekData) {
            $pathImagePast = $cekData['brggambar'];
            unlink($pathImagePast);
            $this->product->delete($code);
            $pesan_success = [
                'success' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Success!</h5>
                The data with code <strong>' . $code . '</strong> has been successfully delete.
                </div>'
            ];
            session()->setFlashdata($pesan_success);
            return redirect()->to('/product/index');
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-ban"></i> Sorry!</h5>
           Data product is not found !
            </div>'
            ];
            session()->setFlashdata($pesan_error);
            return redirect()->to('/product/index');
        }
    }
}
