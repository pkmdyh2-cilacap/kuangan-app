<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;

class LaporanController extends BaseController
{
    protected $transaksiModel;
    protected $detailModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel    = new DetailTransaksiModel();
    }

    public function labaRugi()
    {
        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));

        $pemasukan = $this->transaksiModel
            ->where('tipe_transaksi', 'pemasukan')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $pengeluaran = $this->transaksiModel
            ->where('tipe_transaksi', 'pengeluaran')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $totalPemasukan   = 0;
        $totalPengeluaran = 0;

        $kategoriPemasukan   = [];
        $kategoriPengeluaran = [];

        foreach ($pemasukan as $trx) {
            $totalPemasukan += $trx->total_jumlah;
            $details = $this->detailModel->getByTransaksi($trx->id);
            foreach ($details as $d) {
                $kat = $d->kategori;
                if (!isset($kategoriPemasukan[$kat])) {
                    $kategoriPemasukan[$kat] = 0;
                }
                $kategoriPemasukan[$kat] += $d->subtotal;
            }
        }

        foreach ($pengeluaran as $trx) {
            $totalPengeluaran += $trx->total_jumlah;
            $details = $this->detailModel->getByTransaksi($trx->id);
            foreach ($details as $d) {
                $kat = $d->kategori;
                if (!isset($kategoriPengeluaran[$kat])) {
                    $kategoriPengeluaran[$kat] = 0;
                }
                $kategoriPengeluaran[$kat] += $d->subtotal;
            }
        }

        return view('laporan/labarugi', [
            'pemasukan'           => $pemasukan,
            'pengeluaran'         => $pengeluaran,
            'total_pemasukan'     => $totalPemasukan,
            'total_pengeluaran'   => $totalPengeluaran,
            'laba_bersih'         => $totalPemasukan - $totalPengeluaran,
            'kategori_pemasukan'  => $kategoriPemasukan,
            'kategori_pengeluaran'=> $kategoriPengeluaran,
            'bulan'               => $bulan,
            'tahun'               => $tahun,
        ]);
    }

    public function cashFlow()
    {
        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));

        $pemasukan = $this->transaksiModel
            ->where('tipe_transaksi', 'pemasukan')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $pengeluaran = $this->transaksiModel
            ->where('tipe_transaksi', 'pengeluaran')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->orderBy('tanggal', 'ASC')
            ->findAll();

        $totalPemasukan   = 0;
        $totalPengeluaran = 0;

        foreach ($pemasukan as $trx) {
            $totalPemasukan += $trx->total_jumlah;
        }
        foreach ($pengeluaran as $trx) {
            $totalPengeluaran += $trx->total_jumlah;
        }

        return view('laporan/cashflow', [
            'pemasukan'         => $pemasukan,
            'pengeluaran'       => $pengeluaran,
            'total_pemasukan'   => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo_akhir'       => $totalPemasukan - $totalPengeluaran,
            'bulan'             => $bulan,
            'tahun'             => $tahun,
        ]);
    }

    public function bagiHasil()
    {
        $bulan = (int) ($this->request->getGet('bulan') ?? date('m'));
        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));

        $pemasukan = $this->transaksiModel
            ->where('tipe_transaksi', 'pemasukan')
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->findAll();

        $dokterData = [];

        foreach ($pemasukan as $trx) {
            $details = $this->detailModel->getByTransaksi($trx->id);
            foreach ($details as $d) {
                if ($d->kategori === 'Jasa Dokter') {
                    $namaDokter = $d->nama_layanan;
                    if (!isset($dokterData[$namaDokter])) {
                        $dokterData[$namaDokter] = [
                            'nama'            => $namaDokter,
                            'total_tindakan'  => 0,
                            'jumlah'          => 0,
                            'komisi'          => 0,
                        ];
                    }
                    $dokterData[$namaDokter]['total_tindakan'] += $d->kuantitas;
                    $dokterData[$namaDokter]['jumlah']         += $d->subtotal;
                    $dokterData[$namaDokter]['komisi']         += (int) ($d->subtotal * 0.15);
                }
            }
        }

        return view('laporan/bagihasil', [
            'dokter_data' => array_values($dokterData),
            'bulan'       => $bulan,
            'tahun'       => $tahun,
        ]);
    }
}
