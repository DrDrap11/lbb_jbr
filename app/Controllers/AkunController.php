<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun;

class AkunController extends BaseController
{
    public function index()
    {
        $model = new Akun();
        if ($this->request->getMethod(true) !== 'POST') {
            return view('pages/master/masterAkun', [
                'title' => 'Master Akun',
                'content' => $model->findAll(),
            ]);
        }

        $data = [
            'nama_akun' => $this->request->getVar('nama_akun'),
            'kode_akun' => $this->request->getVar('kode_akun'),
            'keterangan' => $this->request->getVar('keterangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal membuat akun'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil membuat akun'
        ]);
    }

    public function update($id = null)
    {
        $model = new Akun();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $data = [
            'nama_akun' => $this->request->getVar('nama_akun'),
            'kode_akun' => $this->request->getVar('kode_akun'),
            'keterangan' => $this->request->getVar('keterangan'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal update akun'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil update akun'
        ]);
    }

    public function delete($id = null)
    {
        $model = new Akun();
        if (!$model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal hapus akun'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasi hapus akun'
        ]);
    }
}
