<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Laporan Laba Rugi</h1>
    <a href="<?= base_url('laporan/laba-rugi/export?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn-primary-custom">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>
</div>

<div class="card-dark mb-4">
    <?= form_open('laporan/laba-rugi', ['method' => 'get']) ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label-dark">Bulan</label>
                <select name="bulan" class="form-control-dark">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= $m == $bulan ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-dark">Tahun</label>
                <select name="tahun" class="form-control-dark">
                    <?php for ($y = 2024; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary-custom"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    <?= form_close() ?>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(34, 197, 94, 0.15); color: var(--accent-green);">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-green);">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></div>
            <div class="metric-label">Total Pemasukan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(239, 68, 68, 0.15); color: var(--accent-red);">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-red);">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
            <div class="metric-label">Total Pengeluaran</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(74, 108, 247, 0.15); color: var(--accent-blue);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="metric-value" style="color: <?= $laba_bersih >= 0 ? 'var(--accent-green)' : 'var(--accent-red)' ?>;">
                Rp <?= number_format($laba_bersih, 0, ',', '.') ?>
            </div>
            <div class="metric-label">Laba Bersih</div>
        </div>
    </div>
</div>

<div class="card-dark mb-4">
    <h3 style="font-size: 16px; margin-bottom: 16px; color: var(--accent-green);"><i class="fas fa-arrow-down me-2"></i>Pendapatan per Kategori</h3>
    <?php if (!empty($kategori_pemasukan)): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori_pemasukan as $kategori => $total): ?>
                    <tr>
                        <td><?= esc($kategori) ?></td>
                        <td style="text-align: right; font-weight: 600; color: var(--accent-green);">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid rgba(255,255,255,0.1);">
                    <td style="font-weight: 700;">Total Pendapatan</td>
                    <td style="text-align: right; font-weight: 700; color: var(--accent-green);">
                        Rp <?= number_format($total_pemasukan, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-arrow-down"></i>
            <p>Tidak ada data pemasukan untuk periode ini.</p>
        </div>
    <?php endif; ?>
</div>

<div class="card-dark mb-4">
    <h3 style="font-size: 16px; margin-bottom: 16px; color: var(--accent-red);"><i class="fas fa-arrow-up me-2"></i>Pengeluaran per Kategori</h3>
    <?php if (!empty($kategori_pengeluaran)): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategori_pengeluaran as $kategori => $total): ?>
                    <tr>
                        <td><?= esc($kategori) ?></td>
                        <td style="text-align: right; font-weight: 600; color: var(--accent-red);">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid rgba(255,255,255,0.1);">
                    <td style="font-weight: 700;">Total Pengeluaran</td>
                    <td style="text-align: right; font-weight: 700; color: var(--accent-red);">
                        Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-arrow-up"></i>
            <p>Tidak ada data pengeluaran untuk periode ini.</p>
        </div>
    <?php endif; ?>
</div>

<div class="card-dark">
    <h3 style="font-size: 16px; margin-bottom: 16px;"><i class="fas fa-list me-2"></i>Detail Transaksi</h3>
    <?php if (!empty($pemasukan) || !empty($pengeluaran)): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Invoice</th>
                    <th>Tipe</th>
                    <th>Metode Bayar</th>
                    <th style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pemasukan as $trx): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($trx->tanggal)) ?></td>
                        <td><span class="badge-blue"><?= esc($trx->nomor_invoice) ?></span></td>
                        <td><span class="badge-green">Pemasukan</span></td>
                        <td><?= ucfirst($trx->metode_pembayaran) ?></td>
                        <td style="text-align: right; color: var(--accent-green); font-weight: 600;">
                            Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($pengeluaran as $trx): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($trx->tanggal)) ?></td>
                        <td><span class="badge-blue"><?= esc($trx->nomor_invoice) ?></span></td>
                        <td><span class="badge-red">Pengeluaran</span></td>
                        <td><?= ucfirst($trx->metode_pembayaran) ?></td>
                        <td style="text-align: right; color: var(--accent-red); font-weight: 600;">
                            Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid rgba(255,255,255,0.1);">
                    <td colspan="4" style="font-weight: 700;">Laba Bersih</td>
                    <td style="text-align: right; font-weight: 700; color: <?= $laba_bersih >= 0 ? 'var(--accent-green)' : 'var(--accent-red)' ?>;">
                        Rp <?= number_format($laba_bersih, 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>Tidak ada transaksi untuk periode ini.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
