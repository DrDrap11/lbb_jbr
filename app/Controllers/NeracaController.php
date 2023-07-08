<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Akun;
use App\Models\Cabang;
use App\Models\Neraca;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NeracaController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Neraca();
        $modelCabang = new Cabang();
        $modelAkun = new Akun();
        if ($this->request->getMethod(true) !== 'POST') {
            return view('pages/data/dataNeraca', [
                //dd([
                'title' => 'Data Neraca',
                'content' => $model->getAllAssociateData(),
                'cabang' => $modelCabang->findAll(),
                'akun' => $modelAkun->findAll()
            ]);
        }

        $data = [
            'author' => session()->get('id'),
            'nama_akun' => $this->request->getVar('nama_akun'),
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
                'text' => 'Gagal membuat neraca'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil membuat neraca'
        ]);
    }

    public function update($id = null)
    {
        $model = new Neraca();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $data = [
            // 'author' => $this->request->getVar('author'),
            'nama_akun' => $this->request->getVar('nama_akun'),
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
                'text' => 'Gagal update neraca'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil update neraca'
        ]);
    }

    public function delete($id = null)
    {
        $model = new Neraca();
        if (!$model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal hapus neraca'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasi hapus neraca'
        ]);
    }

    public function export($start, $end)
    {
        helper('number');
        $model = new Neraca();
        $dataExport = $model->findDataInBetween($start, $end);
        //dd($dataExport);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PT. Lembaga Keuangan Mikro BKD Berkah Kabupaten Jember')
            ->setCellValue('A2', 'Laporan Neraca')
            ->setCellValue('A3', 'Periode ' . date('d/m/Y', strtotime($start)) . ' sampai ' . date('d/m/Y', strtotime($end)))
            ->setCellValue('A5', 'No.')
            ->setCellValue('B5', 'Nama Akun')
            ->setCellValue('C5', 'Kode Akun')
            ->setCellValue('D5', 'Nama Cabang')
            ->setCellValue('E5', 'Dana')
            ->setCellValue('F5', 'Tanggal');

        $column = 6;
        $no = 1;
        $total = 0; // Variable to store the total value

        // tulis data mobil ke cell
        foreach ($dataExport as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                ->setCellValue('B' . $column, $data['nama_akun'])
                ->setCellValue('C' . $column, $data['kode_akun'])
                ->setCellValue('D' . $column, $data['nama_cabang'])
                ->setCellValue('E' . $column, number_to_currency($data['dana'], 'IDR'))
                ->setCellValue('F' . $column, date('d/m/Y', strtotime($data['created_at'])));


            $total += $data['dana']; // Add the "Dana" value to the total
            $column++;
        }

        // Add the total row
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('D' . $column, 'Total:')
            ->setCellValue('E' . $column, number_to_currency($total, 'IDR'));

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Neraca Periode ' . $start . ' Sampai ' . $end;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
