<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasienTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
                'auto_increment' => true,
            ],
            'nomor_rekam_medis' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'no_telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');
    }

    public function down()
    {
        $this->forge->dropTable('pasien');
    }
}
