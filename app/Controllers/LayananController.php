<?php

namespace App\Controllers;

use App\Models\LayananModel;

class LayananController extends BaseController
{
    protected $layananModel;

    public function __construct()
    {
        $this->layananModel = new LayananModel();
    }

    public function index()
    {
        $search   = $this->request->getGet('search');
        $kategori = $this->request->getGet('kategori');

        $builder = $this->layananModel->builder();

        if ($kategori) {
            $builder->where('kategori', $kategori);
        }

        if ($search) {
            $builder->groupStart()
                ->like('nama_layanan', $search)
                ->orLike('kategori', $search)
                ->groupEnd();
        }

        $data = $builder->orderBy('id', 'DESC')->get()->getResult();

        return view('layanan/index', [
            'layanan'  => $data,
            'search'   => $search,
            'kategori' => $kategori,
        ]);
    }

    public function create()
    {
        return view('layanan/create');
    }

    public function save()
    {
        $rules = [
            'nama_layanan' => 'required|max_length[255]',
            'kategori'     => 'required|in_list[Obat,Jasa Dokter,Lab,Tindakan]',
            'harga'        => 'required|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $this->layananModel->save([
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => $this->request->getPost('harga'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        return view('layanan/edit', ['layanan' => $layanan]);
    }

    public function update($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $rules = [
            'nama_layanan' => 'required|max_length[255]',
            'kategori'     => 'required|in_list[Obat,Jasa Dokter,Lab,Tindakan]',
            'harga'        => 'required|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $this->layananModel->update($id, [
            'nama_layanan' => $this->request->getPost('nama_layanan'),
            'kategori'     => $this->request->getPost('kategori'),
            'harga'        => $this->request->getPost('harga'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/layanan')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $this->layananModel->delete($id);
        return redirect()->to('/layanan')->with('success', 'Layanan berhasil dihapus.');
    }
}
