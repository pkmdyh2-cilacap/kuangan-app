<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Transaksi <?= $tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' ?></h1>
    <a href="/transaksi/create/<?= $tipe ?>" class="btn-primary-custom">
        <i class="fas fa-plus"></i> <?= $tipe === 'pemasukan' ? 'Pemasukan Baru' : 'Pengeluaran Baru' ?>
    </a>
</div>

<div class="card-dark">
    <?php if (!empty($transaksi) && count($transaksi) > 0): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <?php if ($tipe === 'pemasukan'): ?>
                        <th>Pasien</th>
                    <?php endif; ?>
                    <th>Metode Bayar</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $i => $trx): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <span class="badge-blue"><?= esc($trx->nomor_invoice) ?></span>
                        </td>
                        <td><?= date('d M Y', strtotime($trx->tanggal)) ?></td>
                        <?php if ($tipe === 'pemasukan'): ?>
                            <td><?= esc($trx->nama_pasien ?? '-') ?></td>
                        <?php endif; ?>
                        <td><?= ucfirst(esc($trx->metode_pembayaran)) ?></td>
                        <td style="font-weight: 600;">
                            Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?>
                        </td>
                        <td>
                            <a href="/transaksi/detail/<?= $trx->id ?>" class="btn-sm-custom btn-view">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-receipt"></i>
            <p>Belum ada data transaksi <?= $tipe === 'pemasukan' ? 'pemasukan' : 'pengeluaran' ?></p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
