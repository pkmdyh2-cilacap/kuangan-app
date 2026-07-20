<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Laporan Bagi Hasil Dokter</h1>
    <a href="<?= base_url('laporan/bagi-hasil/export?bulan=' . $bulan . '&tahun=' . $tahun) ?>" class="btn btn-primary-custom">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>
</div>

<div class="card-dark mb-4">
    <?= form_open('laporan/bagi-hasil', ['method' => 'get']) ?>
        <?= csrf_field() ?>
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label-dark">Bulan</label>
                <select name="bulan" class="form-control form-control-dark">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= $m == $bulan ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label-dark">Tahun</label>
                <select name="tahun" class="form-control form-control-dark">
                    <?php for ($y = 2024; $y <= 2026; $y++): ?>
                        <option value="<?= $y ?>" <?= $y == $tahun ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary-custom"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>
    <?= form_close() ?>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(74, 108, 247, 0.15); color: var(--accent-blue);">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="metric-value"><?= count($dokter_data) ?></div>
            <div class="metric-label">Dokter Aktif</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(245, 158, 11, 0.15); color: var(--accent-yellow);">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-yellow);">
                Rp <?= number_format(array_sum(array_column($dokter_data, 'komisi')), 0, ',', '.') ?>
            </div>
            <div class="metric-label">Total Komisi (15%)</div>
        </div>
    </div>
</div>

<div class="card-dark">
    <?php if (!empty($dokter_data)): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokter</th>
                    <th style="text-align: right;">Total Tindakan</th>
                    <th style="text-align: right;">Jumlah Tindakan</th>
                    <th style="text-align: right;">Komisi (15%)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($dokter_data as $dokter): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td style="font-weight: 600;"><?= esc($dokter['nama'] ?? $dokter->nama) ?></td>
                        <td style="text-align: right;"><?= number_format($dokter['total_tindakan'] ?? $dokter->total_tindakan, 0, ',', '.') ?></td>
                        <td style="text-align: right;"><?= ($dokter['jumlah'] ?? $dokter->jumlah) ?>x</td>
                        <td style="text-align: right; font-weight: 700; color: var(--accent-yellow);">
                            Rp <?= number_format($dokter['komisi'] ?? $dokter->komisi, 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="border-top: 2px solid rgba(255,255,255,0.1); background: rgba(245, 158, 11, 0.05);">
                    <td colspan="2" style="font-weight: 700;">Total Komisi Dokter</td>
                    <td style="text-align: right; font-weight: 700;">
                        Rp <?= number_format(array_sum(array_column($dokter_data, 'total_tindakan')), 0, ',', '.') ?>
                    </td>
                    <td style="text-align: right; font-weight: 700;">
                        <?= array_sum(array_column($dokter_data, 'jumlah')) ?>x
                    </td>
                    <td style="text-align: right; font-weight: 700; color: var(--accent-yellow); font-size: 16px;">
                        Rp <?= number_format(array_sum(array_column($dokter_data, 'komisi')), 0, ',', '.') ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-user-md"></i>
            <p>Tidak ada data bagi hasil dokter untuk periode ini.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('.table-dark-custom tbody tr').forEach(function(row) {
        row.style.cursor = 'default';
    });
</script>
<?= $this->endSection() ?>
