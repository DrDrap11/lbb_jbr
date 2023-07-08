<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Cabang;
use App\Models\Mutasi;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MutasiController extends BaseController
{
    public function index()
    {
        helper('number');
        $model = new Mutasi();
        $modelCabang = new Cabang();
        if ($this->request->getMethod(true) !== 'POST') {
            return view('pages/data/dataMutasi', [
                //dd([
                'title' => 'Master Mutasi',
                'content' => $model->getAllAssociateData(),
                'cabang' => $modelCabang->findAll(),
            ]);
        }

        $data = [
            'author' => session()->get('id'),
            'cabang' => $this->request->getVar('cabang'),
            'dana' => $this->request->getVar('dana'),
            'kategori' => $this->request->getVar('kategori'),
            'waktu' => $this->request->getVar('waktu'),
            'nasabah' => $this->request->getVar('nasabah'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->insert($data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal membuat mutasi'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil membuat mutasi'
        ]);
    }

    public function update($id = null)
    {
        $model = new Mutasi();
        if ($this->request->getMethod(true) !== 'POST') {
            return $this->response->setJSON($model->find($id));
        }

        $data = [
            'cabang' => $this->request->getVar('cabang'),
            'dana' => $this->request->getVar('dana'),
            'kategori' => $this->request->getVar('kategori'),
            'waktu' => $this->request->getVar('waktu'),
            'nasabah' => $this->request->getVar('nasabah'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!$model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal update mutasi'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasil update mutasi'
        ]);
    }

    public function delete($id = null)
    {
        $model = new Mutasi();
        if (!$model->where('id', $id)->delete($id)) {
            return $this->response->setJSON([
                'status' => FALSE,
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Gagal hapus mutasi'
            ]);
        }

        return $this->response->setJSON([
            'status' => TRUE,
            'icon' => 'success',
            'title' => 'Success!',
            'text' => 'Berhasi hapus mutasi'
        ]);
    }
    public function export($start, $end)
    {
        helper('number');
        $model = new Mutasi();
        $dataUser = $model->findDataInBetween($start, $end);
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'PT. Lembaga Keuangan Mikro BKD Berkah Kabupaten Jember')
            ->setCellValue('A2', 'Laporan Mutasi')
            ->setCellValue('A3', 'Periode ' . date('d/m/Y', strtotime($start)) . ' sampai ' . date('d/m/Y', strtotime($end)))
            ->setCellValue('A5', 'No.')
            // ->setCellValue('B1', 'Nama Akun')
            ->setCellValue('B5', 'Nasabah')
            ->setCellValue('C5', 'Nama Cabang')
            ->setCellValue('D5', 'Kategori')
            ->setCellValue('E5', 'Dana')
            ->setCellValue('F5', 'Tanggal');

        // $totaln = $this->calculateTotal($data);

        $column = 6;
        $no = 1;
        $total = 0; // Variable to store the total value
        $totaln = 0;

        // tulis data mobil ke cell
        foreach ($dataUser as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $no++)
                // ->setCellValue('B' . $column, $data['nama_akun'])
                ->setCellValue('B' . $column, $data['nasabah'])
                ->setCellValue('C' . $column, $data['nama_cabang'])
                ->setCellValue('D' . $column, $data['kategori'])
                ->setCellValue('E' . $column, number_to_currency($data['dana'], 'IDR'))
                ->setCellValue('F' . $column, date('d/m/Y', strtotime($data['created_at'])));

            $total += $data['dana']; // Add the "Dana" value to the total
            $totaln += $data['nasabah'];
            $column++;
        }

        // Add the total row
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B' . $column, 'Total:' . $totaln . 'Nasabah')
            ->setCellValue('E' . $column, 'Total:')
            ->setCellValue('F' . $column, number_to_currency($total, 'IDR'));

        // tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Mutasi Periode ' . $start . ' Sampai ' . $end;

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    private function calculateTotal($data)
    {
        // Inisialisasi total
        $totaln = 0;

        // Melakukan perulangan dan menjumlahkan field tertentu
        foreach ($data as $item) {
            $totaln += $item['num'];
        }

        return $totaln;
    }
}
