<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Laporan Arus Kas</h1>
    <a href="<?= base_url('laporan/cash-flow/export?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn-primary-custom">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>
</div>

<div class="card-dark mb-4">
    <?= form_open('laporan/cash-flow', ['method' => 'get']) ?>
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

<div class="row g-4">
    <div class="col-md-6">
        <div class="card-dark" style="height: 100%;">
            <h3 style="font-size: 16px; margin-bottom: 16px; color: var(--accent-green);">
                <i class="fas fa-arrow-down me-2"></i>Kas Masuk (Pemasukan)
            </h3>
            <?php if (!empty($pemasukan)): ?>
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pemasukan as $trx): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($trx->tanggal)) ?></td>
                                <td><span class="badge-blue"><?= esc($trx->nomor_invoice) ?></span></td>
                                <td style="text-align: right; font-weight: 600; color: var(--accent-green);">
                                    Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid rgba(255,255,255,0.1); background: rgba(34, 197, 94, 0.05);">
                            <td colspan="2" style="font-weight: 700;">Total Kas Masuk</td>
                            <td style="text-align: right; font-weight: 700; color: var(--accent-green); font-size: 16px;">
                                Rp <?= number_format($total_pemasukan, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="empty-state" style="padding: 32px 16px;">
                    <i class="fas fa-arrow-down"></i>
                    <p>Tidak ada kas masuk untuk periode ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-dark" style="height: 100%;">
            <h3 style="font-size: 16px; margin-bottom: 16px; color: var(--accent-red);">
                <i class="fas fa-arrow-up me-2"></i>Kas Keluar (Pengeluaran)
            </h3>
            <?php if (!empty($pengeluaran)): ?>
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                            <th style="text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengeluaran as $trx): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($trx->tanggal)) ?></td>
                                <td><span class="badge-blue"><?= esc($trx->nomor_invoice) ?></span></td>
                                <td style="text-align: right; font-weight: 600; color: var(--accent-red);">
                                    Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid rgba(255,255,255,0.1); background: rgba(239, 68, 68, 0.05);">
                            <td colspan="2" style="font-weight: 700;">Total Kas Keluar</td>
                            <td style="text-align: right; font-weight: 700; color: var(--accent-red); font-size: 16px;">
                                Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="empty-state" style="padding: 32px 16px;">
                    <i class="fas fa-arrow-up"></i>
                    <p>Tidak ada kas keluar untuk periode ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card-dark mt-4">
    <div class="row align-items-center">
        <div class="col-md-4">
            <div class="metric-card" style="background: rgba(34, 197, 94, 0.08); border-color: rgba(34, 197, 94, 0.2);">
                <div class="metric-label" style="margin-bottom: 4px;">Total Kas Masuk</div>
                <div class="metric-value" style="color: var(--accent-green); font-size: 20px;">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card" style="background: rgba(239, 68, 68, 0.08); border-color: rgba(239, 68, 68, 0.2);">
                <div class="metric-label" style="margin-bottom: 4px;">Total Kas Keluar</div>
                <div class="metric-value" style="color: var(--accent-red); font-size: 20px;">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="metric-card" style="background: rgba(74, 108, 247, 0.08); border-color: rgba(74, 108, 247, 0.2);">
                <div class="metric-label" style="margin-bottom: 4px;">Saldo Akhir</div>
                <div class="metric-value" style="color: <?= $saldo_akhir >= 0 ? 'var(--accent-blue)' : 'var(--accent-red)' ?>; font-size: 20px;">
                    Rp <?= number_format($saldo_akhir, 0, ',', '.') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
