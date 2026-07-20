<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\PasienModel;
use App\Models\LayananModel;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $detailModel;
    protected $pasienModel;
    protected $layananModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->detailModel    = new DetailTransaksiModel();
        $this->pasienModel    = new PasienModel();
        $this->layananModel   = new LayananModel();
    }

    public function index($tipe = 'pemasukan')
    {
        $data = $this->transaksiModel
            ->where('tipe_transaksi', $tipe)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        foreach ($data as &$row) {
            $pasien = $this->pasienModel->find($row->pasien_id);
            $row->nama_pasien = $pasien ? $pasien->nama : '-';
        }

        return view('transaksi/index', [
            'transaksi' => $data,
            'tipe'      => $tipe,
        ]);
    }

    public function create($tipe = 'pemasukan')
    {
        $pasienList  = $this->pasienModel->orderBy('nama', 'ASC')->findAll();
        $layananList = $this->layananModel->orderBy('kategori', 'ASC')->orderBy('nama_layanan', 'ASC')->findAll();

        return view('transaksi/create', [
            'tipe'         => $tipe,
            'pasien_list'  => $pasienList,
            'layanan_list' => $layananList,
        ]);
    }

    public function store()
    {
        $tipe = $this->request->getPost('tipe_transaksi');

        $rules = [
            'tanggal'            => 'required',
            'tipe_transaksi'     => 'required|in_list[pemasukan,pengeluaran]',
            'metode_pembayaran'  => 'required|in_list[tunai,debit,qris]',
            'keterangan'         => 'permit_empty',
        ];

        if ($tipe === 'pemasukan') {
            $rules['pasien_id'] = 'required|integer';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $layananIds = $this->request->getPost('layanan_id');
        $kuantitas  = $this->request->getPost('kuantitas');
        $subtotals  = $this->request->getPost('subtotal');

        if (!$layananIds || !is_array($layananIds) || empty($layananIds[0])) {
            return redirect()->back()->withInput()->with('error', 'Minimal harus ada satu item layanan.');
        }

        $totalJumlah = 0;
        foreach ($subtotals as $sub) {
            $totalJumlah += (int) str_replace(['.', ','], '', $sub);
        }

        $nomorInvoice = $this->transaksiModel->generateInvoiceNumber();

        $transaksiId = $this->transaksiModel->insert([
            'nomor_invoice'     => $nomorInvoice,
            'tanggal'           => $this->request->getPost('tanggal'),
            'tipe_transaksi'    => $tipe,
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'total_jumlah'      => $totalJumlah,
            'pasien_id'         => $tipe === 'pemasukan' ? $this->request->getPost('pasien_id') : null,
            'keterangan'        => $this->request->getPost('keterangan'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        $details = [];
        foreach ($layananIds as $idx => $layananId) {
            if (empty($layananId)) continue;
            $details[] = [
                'transaksi_id' => $transaksiId,
                'layanan_id'   => (int) $layananId,
                'kuantitas'    => (int) $kuantitas[$idx],
                'subtotal'     => (int) str_replace(['.', ','], '', $subtotals[$idx]),
            ];
        }

        $this->detailModel->insertBatch($details);

        return redirect()->to("/transaksi/detail/{$transaksiId}")->with('success', 'Transaksi berhasil dicatat.');
    }

    public function detail($id)
    {
        $transaksi = $this->transaksiModel->getByIdWithDetails($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/pemasukan')->with('error', 'Transaksi tidak ditemukan.');
        }

        $details = $this->detailModel->getByTransaksi($id);

        return view('transaksi/detail', [
            'transaksi' => $transaksi,
            'details'   => $details,
        ]);
    }

    public function invoice($id)
    {
        $transaksi = $this->transaksiModel->getByIdWithDetails($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/pemasukan')->with('error', 'Transaksi tidak ditemukan.');
        }

        $details = $this->detailModel->getByTransaksi($id);

        return view('transaksi/invoice', [
            'transaksi' => $transaksi,
            'details'   => $details,
        ]);
    }
}
