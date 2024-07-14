<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPelanggan;
use App\Models\ModelUsers;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Model;

class Users extends BaseController
{
    public function index()
    {
        return view('users/data');
    }

    public function listData()
    {
        try {
            if ($this->request->isAJAX()) {
                $db = \Config\Database::connect();
                $builder = $db->table('users')
                    ->select('users.userid, users.usernama, levels.levelnama, users.useraktif, users.userlevelid')
                    ->join('levels', 'levels.levelid = users.userlevelid');

                // Hitung total records
                $totalRecords = $builder->countAllResults(false);

                // Setup limit dan offset
                $limit = $this->request->getPost('length');
                $start = $this->request->getPost('start');
                $builder->limit($limit, $start);

                // Ambil data
                $data = $builder->get()->getResult();

                $datatableData = [];
                $no = $start + 1;
                foreach ($data as $row) {
                    // Tambahkan tombol view ke dalam data jika userlevelid bukan '1'
                    $viewButton = ($row->userlevelid != '1') ? '<button type="button" class="btn btn-sm btn-info" onclick="view(\'' . $row->userid . '\')">View</button>' : '';

                    $datatableData[] = [
                        'nomor' => $no++,
                        'userid' => $row->userid,
                        'usernama' => $row->usernama,
                        'levelnama' => $row->levelnama,
                        'useraktif' => ($row->useraktif == '1') ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Non-Active</span>',
                        'action' => $viewButton,
                    ];
                }

                // Kirim respons JSON dengan data dan informasi total records
                return $this->response->setJSON([
                    'draw' => $this->request->getPost('draw'),
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $totalRecords,
                    'data' => $datatableData,
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }

    function formTambah()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();

            $data = [
                'datalevel' => $db->table('levels')->where('levelid !=', '1')->get()
            ];
            echo view('users/modalTambah', $data);
        }
    }

    function formEdit()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getPost('userid');
            $modelUser = new ModelUsers();
            $rowUser = $modelUser->find($iduser);

            if ($rowUser) {
                $db = \Config\Database::connect();

                $data = [
                    'datalevel' => $db->table('levels')->where('levelid !=', '1')->get(),
                    'iduser' => $iduser,
                    'namalengkap' => $rowUser['usernama'],
                    'level' => $rowUser['userlevelid'],
                    'status' => $rowUser['useraktif']
                ];
                echo view('users/modalEdit', $data);
            }
        }
    }
    function simpan()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getVar('iduser');
            $namalengkap = $this->request->getVar('namalengkap');
            $level = $this->request->getVar('level');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'iduser' => [
                    'rules' => 'required|is_unique[users.userid]',
                    'label' => 'ID User',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',

                    ]
                ], 'namalengkap' => [
                    'rules' => 'required',
                    'label' => 'Nama Lengkap',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'level' => [
                    'rules' => 'required',
                    'label' => 'Level',
                    'errors' => [
                        'required' => '{field} wajib pilih',

                    ]
                ],
            ]);
            if (!$valid) {
                $error = [
                    'iduser' => $validation->getError('iduser'),
                    'namalengkap' => $validation->getError('namalengkap'),
                    'level' => $validation->getError('level'),
                ];
                $json = [
                    'error' => $error
                ];
            } else {
                $modelUser = new ModelUsers();
                $modelUser->insert([
                    'userid' => $iduser,
                    'usernama' => $namalengkap,
                    'userlevelid' => $level
                ]);
                $json = [
                    'success' => 'Simpan data user berhasil'
                ];
            }
            echo json_encode($json);
        }
    }

    function update()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getVar('iduser');
            $namalengkap = $this->request->getVar('namalengkap');
            $level = $this->request->getVar('level');
            $status = $this->request->getVar('status'); // Add this line to get the status

            $modelUser = new ModelUsers();
            $modelUser->update($iduser, [
                'userid' => $iduser,
                'usernama' => $namalengkap,
                'userlevelid' => $level,
                'useraktif' => $status // Add this line to update the status
            ]);
            $json = [
                'success' => 'Update data user berhasil'
            ];

            echo json_encode($json);
        }
    }

    function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getVar('iduser');

            $modelUser = new ModelUsers();
            $rowUser = $modelUser->find($iduser);

            $useraktif = $rowUser['useraktif'];

            if ($useraktif == '1') {
                $modelUser->update($iduser, [
                    'useraktif' => '0'
                ]);
            } else {
                $modelUser->update($iduser, [
                    'useraktif' => '1'
                ]);
            }

            $json = [
                'success' => ''
            ];
            echo json_encode($json);
        }
    }

    function hapus()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getPost('iduser');

            $modelUser = new ModelUsers();
            $modelUser->delete($iduser);
            $json = [
                'success' => 'Id User berhasil dihapus !'
            ];
            echo json_encode($json);
        }
    }

    function resetPassword()
    {
        if ($this->request->isAJAX()) {
            $iduser = $this->request->getPost('iduser');

            $modelUser = new ModelUsers();
            $passRandom = rand(1, 99999);

            $passHashBaru = password_hash($passRandom, PASSWORD_DEFAULT);

            $modelUser->update($iduser, [
                'userpassword' => $passHashBaru
            ]);
            $json = [
                'success' => '',
                'passwordBaru' => $passRandom
            ];
            echo json_encode($json);
        }
    }
}
