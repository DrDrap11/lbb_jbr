<?php

namespace App\Models;

use CodeIgniter\Model;

class POS2 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pos2';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'author',
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
        return $this->db->table('pos2')
            ->select('
                pos2.*,
                cabang.nama_cabang as nama_cabang,
                cabang.kode_cabang as kode_cabang,
                akun.nama_akun as nama_akun,
                akun.kode_akun as kode_akun,
                akun.keterangan as keterangan,
                users.name as name
            ')
            ->join('akun', 'pos2.kode_akun = akun.kode_akun')
            ->join('cabang', 'pos2.cabang = cabang.kode_cabang')
            ->join('users', 'pos2.author = users.id')
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

        return $this->db->table('pos2')
            ->join('akun', 'pos2.kode_akun = akun.kode_akun')
            ->join('cabang', 'pos2.cabang = cabang.kode_cabang')
            ->join('users', 'pos2.author = users.id')
            ->where("MONTH(pos2.created_at) >= '$startMonth'")
            ->where("YEAR(pos2.created_at) >= '$startYear'")
            ->where("MONTH(pos2.created_at) <= '$endMonth'")
            ->where("YEAR(pos2.created_at) <= '$endYear'")
            ->get()
            ->getResultArray();
    }
}
