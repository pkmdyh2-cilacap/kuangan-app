<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'nomor_invoice', 'tanggal', 'tipe_transaksi', 'metode_pembayaran',
        'total_jumlah', 'pasien_id', 'keterangan', 'created_at', 'updated_at',
    ];

    protected $validationRules = [
        'nomor_invoice'     => 'required|is_unique[transaksi.nomor_invoice,id,{id}]',
        'tipe_transaksi'    => 'required|in_list[pemasukan,pengeluaran]',
        'metode_pembayaran' => 'required|in_list[tunai,debit,qris]',
        'total_jumlah'      => 'required|greater_than[0]',
    ];

    public function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Ymd') . '-';
        $last = $this->select('nomor_invoice')
            ->like('nomor_invoice', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($last) {
            $lastNum = (int) substr($last->nomor_invoice, -4);
            $nextNum = str_pad($lastNum + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '0001';
        }

        return $prefix . $nextNum;
    }

    public function getTransaksiBulanan($bulan, $tahun)
    {
        return $this->where('tipe_transaksi', 'pemasukan')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->findAll();
    }

    public function getPengeluaranBulanan($bulan, $tahun)
    {
        return $this->where('tipe_transaksi', 'pengeluaran')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->findAll();
    }

    public function getTotalPemasukan($bulan, $tahun)
    {
        return $this->selectSum('total_jumlah')
            ->where('tipe_transaksi', 'pemasukan')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->get()
            ->getRow()
            ->total_jumlah ?? 0;
    }

    public function getTotalPengeluaran($bulan, $tahun)
    {
        return $this->selectSum('total_jumlah')
            ->where('tipe_transaksi', 'pengeluaran')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->get()
            ->getRow()
            ->total_jumlah ?? 0;
    }

    public function getWithPasien()
    {
        return $this->select('transaksi.*, pasien.nama as nama_pasien')
            ->join('pasien', 'pasien.id = transaksi.pasien_id', 'left')
            ->orderBy('transaksi.tanggal', 'DESC')
            ->findAll();
    }

    public function getByIdWithDetails($id)
    {
        return $this->select('transaksi.*, pasien.nama as nama_pasien')
            ->join('pasien', 'pasien.id = transaksi.pasien_id', 'left')
            ->where('transaksi.id', $id)
            ->first();
    }
}
