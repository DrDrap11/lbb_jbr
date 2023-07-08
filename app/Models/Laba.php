<?php

namespace App\Models;

use CodeIgniter\Model;

class Laba extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'laba';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'author',
        'kategori',
        'kode_akun',
        'cabang',
        'dana',
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
        return $this->db->table('laba')
            ->select('
                laba.*,
                cabang.nama_cabang as nama_cabang,
                cabang.kode_cabang as kode_cabang,
                akun.nama_akun as nama_akun,
                akun.kode_akun as kode_akun,
                akun.keterangan as keterangan,
                users.name as name
            ')
            ->join('akun', 'laba.kode_akun = akun.kode_akun')
            ->join('cabang', 'laba.cabang = cabang.kode_cabang')
            ->join('users', 'laba.author = users.id')
            ->get()
            ->getResultArray();
    }

    public function findDataInBetween($start, $end, $category)
    {
        $startDate = date('Y-m-01', strtotime($start));

        $endDate = date('Y-m-t', strtotime($end));

        $startMonth = date('m', strtotime($start));
        $startYear = date('Y', strtotime($start));

        $endMonth = date('m', strtotime($end));
        $endYear = date('Y', strtotime($end));

        
        
            if($category == 'all'){
                return $this->db->table('laba')
            ->join('akun', 'laba.kode_akun = akun.kode_akun')
            ->join('cabang', 'laba.cabang = cabang.kode_cabang')
            ->join('users', 'laba.author = users.id')
            ->where("MONTH(laba.created_at) >= '$startMonth'")
            ->where("YEAR(laba.created_at) >= '$startYear'")
            ->where("MONTH(laba.created_at) <= '$endMonth'")
            ->where("YEAR(laba.created_at) <= '$endYear'")
            ->get()
            ->getResultArray();
            }else{
                return $this->db->table('laba')
            ->join('akun', 'laba.kode_akun = akun.kode_akun')
            ->join('cabang', 'laba.cabang = cabang.kode_cabang')
            ->join('users', 'laba.author = users.id')
            ->where("MONTH(laba.created_at) >= '$startMonth'")
            ->where("YEAR(laba.created_at) >= '$startYear'")
            ->where("MONTH(laba.created_at) <= '$endMonth'")
            ->where("YEAR(laba.created_at) <= '$endYear'")
            ->where('kategori' , $category)
            ->get()
            ->getResultArray();
            }
    }

    public function getDataByMonth()
    {
        $builder = $this->db->table('laba');
        $builder->select("DATE_FORMAT(laba.created_at, '%M-%Y') as month, kategori, SUM(dana) as dana");
        $builder->groupBy("MONTH(laba.created_at), kategori");
        $builder->orderBy("MONTH(laba.created_at), kategori");

        $query = $builder->get();

        return $query->getResultArray();
    }
}
