<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Detail Pasien</h1>
    <?= anchor('pasien', '<i class="fas fa-arrow-left"></i> Kembali', ['class' => 'btn btn-primary-custom', 'style' => 'background:var(--text-secondary);']) ?>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-dark">
            <table class="table-dark-custom">
                <tbody>
                    <tr>
                        <td style="width: 140px; color: var(--text-secondary);">Nomor RM</td>
                        <td>: <?= esc($pasien->nomor_rekam_medis) ?></td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-secondary);">Nama</td>
                        <td>: <?= esc($pasien->nama) ?></td>
                    </tr>
                    <tr>
                        <td style="color: var(--text-secondary);">No Telepon</td>
                        <td>: <?= esc($pasien->no_telepon) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-dark">
            <h5 class="mb-3" style="font-size: 16px; font-weight: 600;">Riwayat Transaksi</h5>
            <?php if (!empty($transaksi_list) && count($transaksi_list) > 0): ?>
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi_list as $trx): ?>
                        <tr>
                            <td><?= esc(date('d/m/Y', strtotime($trx->tanggal))) ?></td>
                            <td><?= esc($trx->keterangan) ?></td>
                            <td>Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state" style="padding: 24px 12px;">
                    <i class="fas fa-receipt" style="font-size: 32px;"></i>
                    <p class="mt-2">Belum ada transaksi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>
