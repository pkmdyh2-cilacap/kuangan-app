<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run()
    {
        $pasien = [
            [
                'nomor_rekam_medis' => 'RM-0001',
                'nama'              => 'Andi Saputra',
                'no_telepon'        => '081234567890',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_rekam_medis' => 'RM-0002',
                'nama'              => 'Siti Rahayu',
                'no_telepon'        => '082345678901',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_rekam_medis' => 'RM-0003',
                'nama'              => 'Budi Hartono',
                'no_telepon'        => '083456789012',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_rekam_medis' => 'RM-0004',
                'nama'              => 'Dewi Lestari',
                'no_telepon'        => '084567890123',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_rekam_medis' => 'RM-0005',
                'nama'              => 'Rizky Pratama',
                'no_telepon'        => null,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pasien')->insertBatch($pasien);
    }
}
