<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelLogin;
use CodeIgniter\Commands\Utilities\Publish;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{

    public function index()
    {
        return view('login/index');
    }

    public function cekUser()
    {
        $iduser = $this->request->getPost('iduser');
        $pass = $this->request->getPost('pass');

        $validation = \Config\Services::validation();


        $valid = $this->validate([
            'iduser' => [
                'label' => 'ID User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} can\'t be empty'
                ]
            ],
            'pass' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} can\'t be empty'
                ]
            ]
        ]);
        if (!$valid) {
            $sessError = [
                'errIdUser' => $validation->getError('iduser'),
                'errPassword' => $validation->getError('pass')
            ];
            session()->setFlashdata($sessError);
            return redirect()->to(site_url('login/index'));
        } else {
            $modelLogin = new ModelLogin();
            $cekUserLogin = $modelLogin->find($iduser);
            if ($cekUserLogin == null) {
                $sessError = [
                    'errIdUser' => 'Sorry cannot find User',
                ];
                session()->setFlashdata($sessError);
                return redirect()->to(site_url('login/index'));
            } else {
                if ($cekUserLogin['useraktif'] != '1') {
                    $sessError = [
                        'errIdUser' => 'Maaf user tidak aktif',
                    ];
                    session()->setFlashdata($sessError);
                    return redirect()->to(site_url('login/index'));
                } else {

                    $passwordUser = $cekUserLogin['userpassword'];
                    if (password_verify($pass, $passwordUser)) {
                        $idLevel = $cekUserLogin['userlevelid'];
                        $simpan_session = [
                            'iduser' => $iduser,
                            'namauser' => $cekUserLogin['usernama'],
                            'idlevel' => $idLevel
                        ];
                        session()->set($simpan_session);

                        return redirect()->to('/main/index');
                    } else {
                        $sessError = [
                            'errPassword' => 'Wrong password, try again!',
                        ];
                        session()->setFlashdata($sessError);
                        return redirect()->to(site_url('login/index'));
                    }
                }
            }
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login/index');
    }
}
