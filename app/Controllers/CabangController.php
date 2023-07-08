<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cabang;

class CabangController extends BaseController
{
    public function index()
    {
        $model = new Cabang();
        if ($this->request->getMethod(true) !== 'POST') {
            return view('pages/master/masterCabang', [
                'title' => 'Master Cabang',
                'content' => $model->findAll(),
            ]);
        }

        $data = [
            'nama_cabang' => $this->request->getVar('nama_cabang'),
            'kode_cabang' => $this->request->getVar('kode_cabang'),
            'alamat' => $this->request->getVar('alamat'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal membuat cabang'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil membuat cabang'
        ]);
    }

    public function update($id = null)
    {
        $model = new Cabang();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $data = [
            'nama_cabang' => $this->request->getVar('nama_cabang'),
            'kode_cabang' => $this->request->getVar('kode_cabang'),
            'alamat' => $this->request->getVar('alamat'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal update cabang'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil update cabang'
        ]);
    }

    public function delete($id = null)
    {
        $model = new Cabang();
        if (!$model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal hapus cabang'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasi hapus cabang'
        ]);
    }
}
