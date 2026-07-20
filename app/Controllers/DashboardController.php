<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class DashboardController extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    public function index()
    {
        $bulan = (int) date('m');
        $tahun = (int) date('Y');

        $totalPemasukan   = $this->transaksiModel->getTotalPemasukan($bulan, $tahun);
        $totalPengeluaran = $this->transaksiModel->getTotalPengeluaran($bulan, $tahun);
        $kasBersih        = $totalPemasukan - $totalPengeluaran;

        $jumlahTransaksi = $this->transaksiModel
            ->where('EXTRACT(MONTH FROM tanggal)', $bulan)
            ->where('EXTRACT(YEAR FROM tanggal)', $tahun)
            ->countAllResults();

        $transaksiTerakhir = $this->transaksiModel->getWithPasien();
        $transaksiTerakhir = array_slice($transaksiTerakhir, 0, 5);

        $chartPemasukan   = [];
        $chartPengeluaran = [];
        $bulanLabels      = [];

        for ($i = 11; $i >= 0; $i--) {
            $m = $bulan - $i;
            $y = $tahun;
            if ($m <= 0) {
                $m += 12;
                $y--;
            }
            $chartPemasukan[]   = (int) $this->transaksiModel->getTotalPemasukan($m, $y);
            $chartPengeluaran[] = (int) $this->transaksiModel->getTotalPengeluaran($m, $y);
            $bulanLabels[]      = date('M Y', mktime(0, 0, 0, $m, 1, $y));
        }

        return view('dashboard/index', [
            'total_pemasukan'    => $totalPemasukan,
            'total_pengeluaran'  => $totalPengeluaran,
            'kas_bersih'         => $kasBersih,
            'jumlah_transaksi'   => $jumlahTransaksi,
            'transaksi_terakhir' => $transaksiTerakhir,
            'chart_pemasukan'    => $chartPemasukan,
            'chart_pengeluaran'  => $chartPengeluaran,
            'bulan_labels'       => $bulanLabels,
        ]);
    }
}
