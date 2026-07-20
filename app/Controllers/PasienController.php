<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\TransaksiModel;

class PasienController extends BaseController
{
    protected $pasienModel;
    protected $transaksiModel;

    public function __construct()
    {
        $this->pasienModel     = new PasienModel();
        $this->transaksiModel  = new TransaksiModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');

        if ($search) {
            $data = $this->pasienModel->search($search);
        } else {
            $data = $this->pasienModel->orderBy('id', 'DESC')->findAll();
        }

        return view('pasien/index', [
            'pasien' => $data,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('pasien/create');
    }

    public function save()
    {
        $rules = [
            'nomor_rekam_medis' => 'required|is_unique[pasien.nomor_rekam_medis]',
            'nama'              => 'required|max_length[255]',
            'no_telepon'        => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $this->pasienModel->save([
            'nomor_rekam_medis' => $this->request->getPost('nomor_rekam_medis'),
            'nama'              => $this->request->getPost('nama'),
            'no_telepon'        => $this->request->getPost('no_telepon'),
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasien = $this->pasienModel->find($id);
        if (!$pasien) {
            return redirect()->to('/pasien')->with('error', 'Pasien tidak ditemukan.');
        }

        return view('pasien/edit', ['pasien' => $pasien]);
    }

    public function update($id)
    {
        $pasien = $this->pasienModel->find($id);
        if (!$pasien) {
            return redirect()->to('/pasien')->with('error', 'Pasien tidak ditemukan.');
        }

        $rules = [
            'nomor_rekam_medis' => "required|is_unique[pasien.nomor_rekam_medis,id,{$id}]",
            'nama'              => 'required|max_length[255]',
            'no_telepon'        => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $this->pasienModel->update($id, [
            'nomor_rekam_medis' => $this->request->getPost('nomor_rekam_medis'),
            'nama'              => $this->request->getPost('nama'),
            'no_telepon'        => $this->request->getPost('no_telepon'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function delete($id)
    {
        $pasien = $this->pasienModel->find($id);
        if (!$pasien) {
            return redirect()->to('/pasien')->with('error', 'Pasien tidak ditemukan.');
        }

        $this->pasienModel->delete($id);
        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function detail($id)
    {
        $pasien = $this->pasienModel->find($id);
        if (!$pasien) {
            return redirect()->to('/pasien')->with('error', 'Pasien tidak ditemukan.');
        }

        $transaksiList = $this->transaksiModel
            ->where('pasien_id', $id)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        return view('pasien/detail', [
            'pasien'         => $pasien,
            'transaksi_list' => $transaksiList,
        ]);
    }
}
