<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Dashboard</h1>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(34,197,94,0.15); color: var(--accent-green);">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-green);">Rp <?= number_format($total_pemasukan, 0, ',', '.') ?></div>
            <div class="metric-label">Total Pemasukan Bulan Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(239,68,68,0.15); color: var(--accent-red);">
                <i class="fas fa-arrow-trend-down"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-red);">Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></div>
            <div class="metric-label">Total Pengeluaran Bulan Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(74,108,247,0.15); color: var(--accent-blue);">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-blue);">Rp <?= number_format($kas_bersih, 0, ',', '.') ?></div>
            <div class="metric-label">Kas Bersih</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="metric-card">
            <div class="metric-icon" style="background: rgba(245,158,11,0.15); color: var(--accent-yellow);">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="metric-value" style="color: var(--accent-yellow);"><?= number_format($jumlah_transaksi, 0, ',', '.') ?></div>
            <div class="metric-label">Jumlah Transaksi</div>
        </div>
    </div>
</div>

<div class="card-dark mb-4">
    <h5 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Pemasukan vs Pengeluaran (12 Bulan Terakhir)</h5>
    <canvas id="chartKeuangan" height="100"></canvas>
</div>

<div class="card-dark">
    <h5 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Transaksi Terakhir</h5>
    <div style="overflow-x: auto;">
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Tipe</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($transaksi_terakhir)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 32px;">Belum ada transaksi</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transaksi_terakhir as $trx): ?>
                        <tr>
                            <td><?= esc($trx->nomor_invoice) ?></td>
                            <td><?= date('d M Y', strtotime($trx->tanggal)) ?></td>
                            <td><?= esc($trx->nama_pasien) ?></td>
                            <td>
                                <?php if ($trx->tipe_transaksi === 'pemasukan'): ?>
                                    <span class="badge-green">Pemasukan</span>
                                <?php else: ?>
                                    <span class="badge-red">Pengeluaran</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right; font-weight: 600;">Rp <?= number_format($trx->total_jumlah, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKeuangan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($bulan_labels) ?>,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: <?= json_encode($chart_pemasukan) ?>,
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                },
                {
                    label: 'Pengeluaran',
                    data: <?= json_encode($chart_pengeluaran) ?>,
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgba(239, 68, 68, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#e8e8e8',
                        font: { size: 13 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#8b8d97', font: { size: 12 } },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                },
                y: {
                    ticks: {
                        color: '#8b8d97',
                        font: { size: 12 },
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    },
                    grid: { color: 'rgba(255,255,255,0.04)' }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>