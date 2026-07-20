<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table            = 'layanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = ['nama_layanan', 'kategori', 'harga', 'created_at', 'updated_at'];

    protected $validationRules = [
        'nama_layanan' => 'required|max_length[255]',
        'kategori'     => 'required|max_length[50]',
        'harga'        => 'required|greater_than[0]',
    ];

    public function getByKategori($kategori)
    {
        return $this->where('kategori', $kategori)->findAll();
    }

    public function search($keyword)
    {
        return $this->groupStart()
            ->like('nama_layanan', $keyword)
            ->orLike('kategori', $keyword)
            ->groupEnd()
            ->findAll();
    }
}
