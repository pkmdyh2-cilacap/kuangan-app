<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= esc($transaksi['nomor_invoice']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f5f5f5;
            color: #333;
            padding: 40px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            padding: 48px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 24px;
            border-bottom: 2px solid #e5e7eb;
        }
        .clinic-info h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1d29;
            margin-bottom: 4px;
        }
        .clinic-info p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h1 {
            font-size: 28px;
            font-weight: 800;
            color: #4a6cf7;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .invoice-meta {
            margin-top: 8px;
        }
        .invoice-meta p {
            font-size: 13px;
            color: #6b7280;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 36px;
        }
        .info-box {
            flex: 1;
        }
        .info-box h4 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .info-box p {
            font-size: 14px;
            line-height: 1.7;
        }
        .info-box .label {
            color: #6b7280;
            font-size: 13px;
        }
        .info-box .value {
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }
        thead th {
            background: #f9fafb;
            text-align: left;
            padding: 12px 16px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
        }
        tbody td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid #f3f4f6;
        }
        tbody tr:last-child td {
            border-bottom: 2px solid #e5e7eb;
        }
        .text-right { text-align: right; }
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 40px;
        }
        .total-box {
            width: 280px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        .total-row.grand-total {
            border-top: 2px solid #1a1d29;
            margin-top: 8px;
            padding-top: 12px;
            font-size: 18px;
            font-weight: 700;
        }
        .invoice-footer {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 12px;
        }
        .badge-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pemasukan {
            background: #dcfce7;
            color: #16a34a;
        }
        .badge-pengeluaran {
            background: #fef2f2;
            color: #dc2626;
        }
        @media print {
            body {
                background: #fff;
                padding: 0;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .invoice-container {
                box-shadow: none;
                border-radius: 0;
                padding: 24px;
                max-width: 100%;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="clinic-info">
                <h2><i class="fas fa-hospital"></i> Klinik Keuangan</h2>
                <p>
                    Jl. Contoh Alamat No. 123<br>
                    Telp: (021) 1234-5678<br>
                    Email: info@klinikkeuangan.id
                </p>
            </div>
            <div class="invoice-title">
                <h1>Invoice</h1>
                <div class="invoice-meta">
                    <p><strong><?= esc($transaksi['nomor_invoice']) ?></strong></p>
                    <p><?= date('d M Y', strtotime($transaksi['tanggal'])) ?></p>
                </div>
            </div>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h4>Informasi Pasien</h4>
                <?php if ($transaksi['tipe'] === 'pemasukan' && !empty($transaksi['nama_pasien'])): ?>
                    <p><span class="label">Nama:</span> <span class="value"><?= esc($transaksi['nama_pasien']) ?></span></p>
                <?php else: ?>
                    <p><span class="label">Tipe:</span> <span class="badge-type badge-pengeluaran">Pengeluaran</span></p>
                <?php endif; ?>
            </div>
            <div class="info-box" style="text-align: right;">
                <h4>Detail Transaksi</h4>
                <p>
                    <span class="label">Tipe:</span>
                    <span class="badge-type <?= $transaksi['tipe'] === 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' ?>">
                        <?= ucfirst($transaksi['tipe']) ?>
                    </span>
                </p>
                <p><span class="label">Metode Bayar:</span> <span class="value"><?= esc($transaksi['metode_pembayaran']) ?></span></p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Layanan</th>
                    <th>Kategori</th>
                    <th class="text-right">Kuantitas</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($item['nama_layanan']) ?></td>
                        <td><?= esc($item['kategori'] ?? '-') ?></td>
                        <td class="text-right"><?= $item['kuantitas'] ?></td>
                        <td class="text-right" style="font-weight: 600;">
                            Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-box">
                <div class="total-row grand-total">
                    <span>Total</span>
                    <span style="color: #1a1d29;">Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <div class="invoice-footer">
            <p>Terima kasih atas kunjungan Anda. Semoga lekas sembuh.</p>
            <p style="margin-top: 4px;">Invoice ini dicetak secara otomatis dan sah tanpa tanda tangan.</p>
        </div>
    </div>
</body>
</html>
