<?php

namespace App\Models;

use CodeIgniter\Model;

class Neraca extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'neraca';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'author',
        'kategori',
        'kode_akun',
        'keterangan',
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
        return $this->db->table('neraca')
            ->select('
                neraca.*,
                cabang.nama_cabang as nama_cabang,
                cabang.kode_cabang as kode_cabang,
                akun.nama_akun as nama_akun,
                akun.keterangan as keterangan,
                akun.kode_akun as kode_akun,
                users.name as name
            ')
            ->join('akun', 'neraca.kode_akun = akun.kode_akun')
            ->join('cabang', 'neraca.cabang = cabang.kode_cabang')
            ->join('users', 'neraca.author = users.id')
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

        return $this->db->table('neraca')
            ->join('akun', 'neraca.kode_akun = akun.kode_akun')
            ->join('cabang', 'neraca.cabang = cabang.kode_cabang')
            ->join('users', 'neraca.author = users.id')
            ->where("MONTH(neraca.created_at) >= '$startMonth'")
            ->where("YEAR(neraca.created_at) >= '$startYear'")
            ->where("MONTH(neraca.created_at) <= '$endMonth'")
            ->where("YEAR(neraca.created_at) <= '$endYear'")
            ->get()
            ->getResultArray();
    }

    public function getDataByMonth()
    {
        $builder = $this->db->table('neraca');
        $builder->select("DATE_FORMAT(neraca.created_at, '%M-%Y') as month, kategori, SUM(dana) as dana");
        $builder->groupBy("MONTH(neraca.created_at), kategori");
        $builder->orderBy("MONTH(neraca.created_at), kategori");

        $query = $builder->get();

        return $query->getResultArray();
    }
}
