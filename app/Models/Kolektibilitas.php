<?php

namespace App\Models;

use CodeIgniter\Model;

class Kolektibilitas extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kolektibilitas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'author',
        'cabang',
        'dana',
        'kategori',
        'waktu',
        'nasabah',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function getAllAssociateData()
    {
        return $this->db->table('kolektibilitas')
            ->select('
                kolektibilitas.*,
                cabang.nama_cabang as nama_cabang,
                cabang.kode_cabang as kode_cabang,
                users.name as name
            ')
            ->join('cabang', 'kolektibilitas.cabang = cabang.kode_cabang')
            ->join('users', 'kolektibilitas.author = users.id')
            ->get()
            ->getResultArray();
    }

    public function findDataInBetween($start, $end)
    {
        $startDate = date('d', strtotime($start));

        $endDate = date('d', strtotime($end));

        $startMonth = date('m', strtotime($start));
        $startYear = date('Y', strtotime($start));

        $endMonth = date('m', strtotime($end));
        $endYear = date('Y', strtotime($end));

        return $this->db->table('kolektibilitas')
            ->join('cabang', 'kolektibilitas.cabang = cabang.kode_cabang')
            ->join('users', 'kolektibilitas.author = users.id')
            ->where("DATE(kolektibilitas.created_at) >= '$startDate'")
            ->where("MONTH(kolektibilitas.created_at) >= '$startMonth'")
            ->where("YEAR(kolektibilitas.created_at) >= '$startYear'")
            ->where("DATE(kolektibilitas.created_at) >= '$endDate'")
            ->where("MONTH(kolektibilitas.created_at) <= '$endMonth'")
            ->where("YEAR(kolektibilitas.created_at) <= '$endYear'")
            ->get()
            ->getResultArray();
    }

    public function getDataByMonth($bulan)
    {
        return $this->db->table('kolektibilitas')
            ->where('MONTH(kolektibilitas.created_at)', $bulan)
            ->get()
            ->getResultArray();
    }

    public function getTotal($bulan)
    {
        $builder = $this->db->table('kolektibilitas');

        // Lakukan query ke database berdasarkan bulan
        $builder->where('MONTH(created_at)', $bulan);

        // Kelompokkan data berdasarkan kategori
        $builder->groupBy('kategori');

        // Hitung total dana per kategori
        $builder->select('kategori, SUM(dana) as total_dana');

        // Dapatkan hasil query sebagai array of objects
        $results = $builder->get()->getResultArray();

        // Definisikan array kategori yang ingin ditampilkan
        $kategoriList = array('lancar', 'diragukan', 'macet');

        // Buat array kosong untuk menyimpan hasil akhir
        $data = array();

        // Loop melalui kategori yang ditentukan dan cek apakah ada data yang sesuai
        foreach ($kategoriList as $kategori) {
            $found = false;

            // Loop melalui hasil query untuk mencocokkan kategori
            foreach ($results as $result) {
                if ($result['kategori'] === $kategori) {
                    // $result['total_dana'] = number_format($result['total_dana'], 2, ',', '.'); // Convert to IDR format
                    $data[] = $result;
                    $found = true;
                    break;
                }
            }

            // Jika tidak ada data yang cocok, tambahkan kategori dengan total_dana 0
            if (!$found) {
                $data[] = array('kategori' => $kategori, 'total_dana' => '0');
            }
        }

        // Kembalikan hasil akhir
        return $data;
    }

    public function groupDataByCategory($dataK)
    {
        $groupedData = [];

        foreach ($dataK as $item) {
            $kategori = $item['kategori'];



            if (!isset($groupedData[$kategori])) {
                $groupedData[$kategori] = [];
            }

            $groupedData[$kategori][] = $item;
        }

        return $groupedData;
    }

    public function calculateTotalsByCategory($data)
    {
        $totals = [];

        foreach ($data as $kategori => $items) {
            $total = 0;

            foreach ($items as $item) {
                $total += $item['dana'];
            }

            $totals[$kategori] = $total;
        }

        return $totals;
    }
}
