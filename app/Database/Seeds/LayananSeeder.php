<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run()
    {
        $layanan = [
            [
                'nama_layanan' => 'Konsultasi Dokter Umum',
                'kategori'     => 'Jasa Dokter',
                'harga'        => 150000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Konsultasi Dokter Spesialis',
                'kategori'     => 'Jasa Dokter',
                'harga'        => 300000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Pemeriksaan Darah Lengkap',
                'kategori'     => 'Lab',
                'harga'        => 120000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Pemeriksaan Urine',
                'kategori'     => 'Lab',
                'harga'        => 80000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Pembersihan Gigi',
                'kategori'     => 'Tindakan',
                'harga'        => 200000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Tindakan Suntik',
                'kategori'     => 'Tindakan',
                'harga'        => 50000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Paracetamol 500mg',
                'kategori'     => 'Obat',
                'harga'        => 5000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Amoxicillin 500mg',
                'kategori'     => 'Obat',
                'harga'        => 15000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Vitamin C 1000mg',
                'kategori'     => 'Obat',
                'harga'        => 8000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'nama_layanan' => 'Obat Batuk Sirup',
                'kategori'     => 'Obat',
                'harga'        => 25000,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('layanan')->insertBatch($layanan);
    }
}
