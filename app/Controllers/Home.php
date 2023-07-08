<?php

namespace App\Controllers;

use App\Models\Cabang;
use App\Models\Kolektibilitas;
use App\Models\Laba;
use App\Models\Liabilitas;
use App\Models\Mutasi;
use App\Models\Neraca;
use App\Models\POS2;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Date;



class Home extends BaseController
{
    public function index()
    {
        $modelCabang = new Cabang();
        $modelKolektibilitas = new Kolektibilitas();
        $modelLaba = new Laba();
        $modelLiabilitas = new Liabilitas();
        $modelMutasi = new Mutasi();
        $modelNeraca = new Neraca();
        $modelPOS2 = new POS2();
        $modelUser = new User();

        //neraca chart
        $data = $modelNeraca->getDataByMonth();
        // dd($data);
        $labels = [];
        $values = [];
        $dataset = [];
        $chartData = [];
        $categories = [];
        $months = [];
        foreach ($data as $row) {
            $category = $row['kategori'];
            $month = $row['month'];
            $amount = (int) $row['dana'];

            // Add category to categories array if it's not already present
            if (!in_array($category, $categories)) {
                $categories[] = $category;
            }

            // Add month to months array if it's not already present
            if (!in_array($month, $months)) {
                $months[] = $month;
            }

            // Add data to chartData array
            $chartData[] = [
                'category' => $category,
                'month' => $month,
                'amount' => $amount,
            ];
        }

        //labachart
        $data = $modelLaba->getDataByMonth();
        $chartLaba = [];
        $categoriesLaba = [];
        $monthsLaba = [];

        foreach ($data as $row) {
            $category = $row['kategori'];
            $month = $row['month'];
            $amount = (int) $row['dana'];

            // Add category to categoriesLaba array if it's not already present
            if (!in_array($category, $categoriesLaba)) {
                $categoriesLaba[] = $category;
            }

            // Add month to monthsLaba array if it's not already present
            if (!in_array($month, $monthsLaba)) {
                $monthsLaba[] = $month;
            }

            // Add data to chartLaba array
            $chartLaba[] = [
                'category' => $category,
                'month' => $month,
                'amount' => $amount,
            ];
        }


        //kolektibiltas
        if (isset($_POST['bulan'])) {
            $bulan = $this->request->getPost('bulan');
            // $bulan = Date('m');
            $dataK = $modelKolektibilitas->getTotal($bulan);
            return json_encode($dataK);
        }

        //mutasi
        if (isset($_POST['bulanmut'])) {
            $bulan = $this->request->getPost('bulanmut');
            // $bulan = Date('m');
            $dataM = $modelMutasi->getTotal($bulan);
            return json_encode($dataM);
            // dd($dataM);
        }

        //liabilitas
        if (isset($_POST['bulanlia'])) {
            $bulan = $this->request->getPost('bulanlia');
            // $bulan = Date('m');
            $dataL = $modelLiabilitas->getTotal($bulan);
            return json_encode($dataL);
            // dd($dataM);
        }

        return view('pages/index', [
            'title' => 'Dashboard',
            'user' => $modelUser->countAllResults(),
            'pos2' => $modelPOS2->countAllResults(),
            'neraca' => $modelNeraca->countAllResults(),
            'mutasi' => $modelMutasi->countAllResults(),
            'liabilitas' => $modelLiabilitas->countAllResults(),
            'laba' => $modelLaba->countAllResults(),
            'kolektibilitas' => $modelKolektibilitas->countAllResults(),
            'cabang' => $modelCabang->countAllResults(),
            // 'chartData' => $chartData
            'label' => $labels,
            'values' => $values,
            'dataset' => $dataset,
            'categories' => $categories,
            'chartData' => $chartData,
            'months' => $months,
            'categoriesLaba' => $categoriesLaba,
            'chartLaba' => $chartLaba,
            'monthsLaba' => $monthsLaba,
            // 'grupdata' => $dataK,
            // 'totals' => $totals
        ]);
    }

    private function groupDataByCategory($dataK)
    {
        $groupedData = [];

        foreach ($dataK as $item) {
            $kategori = $item->kategori;

            if (!isset($groupedData[$kategori])) {
                $groupedData[$kategori] = [];
            }

            $groupedData[$kategori][] = $item;
        }

        return $groupedData;
    }

    private function calculateTotalsByCategory($data)
    {
        $totals = [];

        foreach ($data as $kategori => $items) {
            $total = 0;

            foreach ($items as $item) {
                $total += $item->dana;
            }

            $totals[$kategori] = $total;
        }

        return $totals;
    }
}
