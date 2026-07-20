<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
                'auto_increment' => true,
            ],
            'nomor_invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'unique'     => true,
            ],
            'tanggal' => [
                'type' => 'TIMESTAMP',
            ],
            'tipe_transaksi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'metode_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'total_jumlah' => [
                'type' => 'BIGINT',
            ],
            'pasien_id' => [
                'type'         => 'INT',
                'null'         => true,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('pasien_id', 'pasien', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
