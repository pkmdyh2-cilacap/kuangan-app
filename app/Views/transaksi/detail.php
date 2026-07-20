<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Detail Transaksi</h1>
    <div>
        <a href="/transaksi/invoice/<?= $transaksi->id ?>" class="btn-primary-custom" style="background: var(--accent-green);" target="_blank">
            <i class="fas fa-print"></i> Cetak Invoice
        </a>
        <a href="/transaksi/<?= $transaksi->tipe_transaksi ?>" class="btn-primary-custom" style="background: var(--text-secondary);">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card-dark mb-4">
            <h5 style="margin-bottom: 20px; font-weight: 600;">Informasi Invoice</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-label-dark">Nomor Invoice</div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--accent-blue);">
                        <?= esc($transaksi->nomor_invoice) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-dark">Tanggal</div>
                    <div style="font-size: 16px;">
                        <?= date('d M Y', strtotime($transaksi->tanggal)) ?>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-label-dark">Tipe Transaksi</div>
                    <span class="<?= $transaksi->tipe_transaksi === 'pemasukan' ? 'badge-green' : 'badge-red' ?>">
                        <?= ucfirst($transaksi->tipe_transaksi) ?>
                    </span>
                </div>
                <div class="col-md-6">
                    <div class="form-label-dark">Metode Bayar</div>
                    <div style="font-size: 16px;"><?= ucfirst(esc($transaksi->metode_pembayaran)) ?></div>
                </div>
            </div>
            <?php if ($transaksi->tipe_transaksi === 'pemasukan' && !empty($transaksi->nama_pasien)): ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-label-dark">Nama Pasien</div>
                        <div style="font-size: 16px;"><?= esc($transaksi->nama_pasien) ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($transaksi->keterangan)): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="form-label-dark">Keterangan</div>
                        <div style="font-size: 14px;"><?= nl2br(esc($transaksi->keterangan)) ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-dark">
            <h5 style="margin-bottom: 20px; font-weight: 600;">Detail Items</h5>
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Layanan</th>
                        <th>Kategori</th>
                        <th>Kuantitas</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($item->nama_layanan) ?></td>
                            <td><?= esc($item->kategori) ?></td>
                            <td><?= $item->kuantitas ?></td>
                            <td style="text-align: right; font-weight: 600;">
                                Rp <?= number_format($item->subtotal, 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-dark" style="position: sticky; top: 24px;">
            <h5 style="margin-bottom: 20px; font-weight: 600;">Ringkasan Pembayaran</h5>
            <div class="d-flex justify-content-between mb-2">
                <span style="color: var(--text-secondary);">Subtotal Items</span>
                <span>Rp <?= number_format($transaksi->total_jumlah, 0, ',', '.') ?></span>
            </div>
            <hr style="border-color: rgba(255,255,255,0.06); margin: 16px 0;">
            <div class="d-flex justify-content-between align-items-center">
                <span style="font-size: 16px; font-weight: 600;">Total</span>
                <span style="font-size: 22px; font-weight: 700; color: var(--accent-green);">
                    Rp <?= number_format($transaksi->total_jumlah, 0, ',', '.') ?>
                </span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
