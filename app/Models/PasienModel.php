<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table            = 'pasien';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = ['nomor_rekam_medis', 'nama', 'no_telepon', 'created_at', 'updated_at'];

    protected $validationRules = [
        'nomor_rekam_medis' => 'required|is_unique[pasien.nomor_rekam_medis,id,{id}]',
        'nama'              => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'nomor_rekam_medis' => [
            'is_unique' => 'Nomor rekam medis sudah digunakan.',
        ],
    ];

    public function search($keyword)
    {
        return $this->groupStart()
            ->like('nama', $keyword)
            ->orLike('nomor_rekam_medis', $keyword)
            ->orLike('no_telepon', $keyword)
            ->groupEnd()
            ->findAll();
    }
}
