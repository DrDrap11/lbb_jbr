<?php

namespace App\Models;

use CodeIgniter\Model;

class Liabilitas extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'liabilitas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'author',
        'cabang',
        'dana',
        'keterangan',
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
        return $this->db->table('liabilitas')
            ->select('
                liabilitas.*,
                cabang.nama_cabang as nama_cabang,
                cabang.kode_cabang as kode_cabang,
                users.name as name
            ')
            ->join('cabang', 'liabilitas.cabang = cabang.kode_cabang')
            ->join('users', 'liabilitas.author = users.id')
            ->get()
            ->getResultArray();
    }
    public function findDataInBetween($start, $end)
    {
        $startDate = date('Y-m-01', strtotime($start));

        $endDate = date('Y-m-t', strtotime($end));

        $startMonth = date('m', strtotime($start));
        $startYear = date('Y', strtotime($start));

        $endMonth = date('m', strtotime($end));
        $endYear = date('Y', strtotime($end));

        return $this->db->table('liabilitas')
            // ->join('akun', 'liabilitas.kode_akun = akun.kode_akun')
            ->join('cabang', 'liabilitas.cabang = cabang.kode_cabang')
            ->join('users', 'liabilitas.author = users.id')
            ->where("MONTH(liabilitas.created_at) >= '$startMonth'")
            ->where("YEAR(liabilitas.created_at) >= '$startYear'")
            ->where("MONTH(liabilitas.created_at) <= '$endMonth'")
            ->where("YEAR(liabilitas.created_at) <= '$endYear'")
            ->get()
            ->getResultArray();
    }
    public function getTotal($bulan){
        $builder = $this->db->table('liabilitas');

        // Lakukan query ke database berdasarkan bulan
        $builder->where('MONTH(created_at)', $bulan);
        
        // Kelompokkan data berdasarkan kategori
        $builder->groupBy('keterangan');
        
        // Hitung total dana per kategori
        $builder->select('keterangan, SUM(dana) as total_dana');
        
        // Dapatkan hasil query sebagai array of objects
        $results = $builder->get()->getResultArray();
        
        // Definisikan array kategori yang ingin ditampilkan
        $kategoriList = array('tabungan_desa', 'simpanan_wajib', 'simasya_tapel', 'tabanas_pmk');
        
        // Buat array kosong untuk menyimpan hasil akhir
        $data = array();
        
        // Loop melalui kategori yang ditentukan dan cek apakah ada data yang sesuai
        foreach ($kategoriList as $kategori) {
            $found = false;
        
            // Loop melalui hasil query untuk mencocokkan kategori
            foreach ($results as $result) {
                if ($result['keterangan'] === $kategori) {
                    // $result['total_dana'] = number_to_currency($result['total_dana'], 'IDR'); // Convert to IDR format
                    $data[] = $result;
                    $found = true;
                    break;
                }
            }
        
            // Jika tidak ada data yang cocok, tambahkan kategori dengan total_dana 0
            if (!$found) {
                $data[] = array('keterangan' => $kategori, 'total_dana' => '0');
            }
        }
        
        // Kembalikan hasil akhir
        return $data;

    }
}
