<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun;
use App\Models\Cabang;
use App\Models\Laba;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LabaController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Laba();
        $modelCabang = new Cabang();
        $modelAkun = new Akun();
        if ($this->request->getMethod(true) !== 'POST') {
            return view('pages/data/dataLaba', [
                'title' => 'Data Laba',
                'content' => $model->getAllAssociateData(),
                'cabang' => $modelCabang->findAll(),
                'akun' => $modelAkun->findAll(),
            ]);
        }

        // $time = Time::createFromFormat('j-M-Y', 'America/Chicago');

        $data = [
            'author' => session()->get('id'),
            'kategori' => $this->request->getVar('kategori'),
            'kode_akun' => $this->request->getVar('kode_akun'),
            'cabang' => $this->request->getVar('cabang'),
            'dana' => $this->request->getVar('dana'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal membuat laba'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil membuat laba'
        ]);
    }

    public function update($id = null)
    {
        $model = new Laba();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $data = [
            'kategori' => $this->request->getVar('kategori'),
            'kode_akun' => $this->request->getVar('kode_akun'),
            'cabang' => $this->request->getVar('cabang'),
            'dana' => $this->request->getVar('dana'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal update laba'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil update laba'
        ]);
    }

    public function delete($id = null)
    {
        $model = new Laba();
        if (!$model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal hapus laba'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasi hapus laba'
        ]);
    }

    public function export($start, $end, $category)
    {
        helper('number');
        $model = new Laba();
        // $kategori = explode('all', $category);
        $dataUser = $model->findDataInBetween($start, $end, $category);
        // dd($dataUser);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PT. Lembaga Keuangan Mikro BKD Berkah Kabupaten Jember')
            ->setCellValue('A2', 'Laporan Laba')
            ->setCellValue('A3', 'Periode ' . date('d/m/Y', strtotime($start)) . ' sampai ' . date('d/m/Y', strtotime($end)))
            ->setCellValue('A5', 'No.')
            ->setCellValue('B5', 'Nama Akun')
            ->setCellValue('C5', 'Kode Akun')
            ->setCellValue('D5', 'Nama Cabang')
            ->setCellValue('E5', 'Kategori')
            ->setCellValue('F5', 'Dana')
            ->setCellValue('G5', 'Tanggal');


        $column = 6;
        $no = 1;
        $total = 0; // Variable to store the total value

        // tulis data mobil ke cell
        foreach ($dataUser as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['nama_akun'])
                ->setCellValue('C' . $column, $data['kode_akun'])
                ->setCellValue('D' . $column, $data['nama_cabang'])
                ->setCellValue('E' . $column, $data['kategori'])
                ->setCellValue('F' . $column, number_to_currency($data['dana'], 'IDR'))
                // ->setCellValue('G' . $column, $data['created_at']->format('d-m-Y'));
                ->setCellValue('G' . $column, date('d-m-Y', strtotime($data['created_at'])));

            $total += $data['dana']; // Add the "Dana" value to the total
            $column++;
        }

        // Add the total row
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('E' . $column, 'Total:')
            ->setCellValue('F' . $column, number_to_currency($total, 'IDR'));

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Laba Periode ' . $start . ' Sampai ' . $end . ' kategori ' . $category;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
