<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
                'auto_increment' => true,
            ],
            'transaksi_id' => [
                'type'       => 'INT',
            ],
            'layanan_id' => [
                'type'       => 'INT',
            ],
            'kuantitas' => [
                'type' => 'INT',
            ],
            'subtotal' => [
                'type' => 'BIGINT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('transaksi_id', 'transaksi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('layanan_id', 'layanan', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi');
    }
}
