<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = ['transaksi_id', 'layanan_id', 'kuantitas', 'subtotal'];

    protected $validationRules = [
        'transaksi_id' => 'required|integer',
        'layanan_id'   => 'required|integer',
        'kuantitas'    => 'required|greater_than[0]',
        'subtotal'     => 'required|greater_than[0]',
    ];

    public function getByTransaksi($transaksiId)
    {
        return $this->select('detail_transaksi.*, layanan.nama_layanan, layanan.kategori')
            ->join('layanan', 'layanan.id = detail_transaksi.layanan_id')
            ->where('detail_transaksi.transaksi_id', $transaksiId)
            ->findAll();
    }

    public function getDetailLengkap()
    {
        return $this->select('detail_transaksi.*, layanan.nama_layanan, layanan.kategori, transaksi.nomor_invoice, transaksi.tanggal')
            ->join('layanan', 'layanan.id = detail_transaksi.layanan_id')
            ->join('transaksi', 'transaksi.id = detail_transaksi.transaksi_id')
            ->orderBy('transaksi.tanggal', 'DESC')
            ->findAll();
    }
}
