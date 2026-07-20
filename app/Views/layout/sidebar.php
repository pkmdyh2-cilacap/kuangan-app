<aside class="sidebar">
    <div class="sidebar-brand">
        <h3><i class="fas fa-hospital me-2"></i>Klinik Keuangan</h3>
        <small>Manajemen Keuangan</small>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <a href="/" class="<?= uri_string() === '' ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <a href="/pasien" class="<?= strpos(uri_string(), 'pasien') !== false ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Pasien
        </a>
        <a href="/layanan" class="<?= strpos(uri_string(), 'layanan') !== false ? 'active' : '' ?>">
            <i class="fas fa-pills"></i> Layanan & Inventory
        </a>

        <div class="menu-label">Transaksi</div>
        <a href="/transaksi/pemasukan" class="<?= strpos(uri_string(), 'transaksi/pemasukan') !== false ? 'active' : '' ?>">
            <i class="fas fa-arrow-down"></i> Pemasukan
        </a>
        <a href="/transaksi/pengeluaran" class="<?= strpos(uri_string(), 'transaksi/pengeluaran') !== false ? 'active' : '' ?>">
            <i class="fas fa-arrow-up"></i> Pengeluaran
        </a>

        <div class="menu-label">Laporan</div>
        <a href="/laporan/laba-rugi" class="<?= strpos(uri_string(), 'laporan/laba-rugi') !== false ? 'active' : '' ?>">
            <i class="fas fa-file-invoice-dollar"></i> Laba Rugi
        </a>
        <a href="/laporan/cash-flow" class="<?= strpos(uri_string(), 'laporan/cash-flow') !== false ? 'active' : '' ?>">
            <i class="fas fa-money-bill-wave"></i> Cash Flow
        </a>
        <a href="/laporan/bagi-hasil" class="<?= strpos(uri_string(), 'laporan/bagi-hasil') !== false ? 'active' : '' ?>">
            <i class="fas fa-handshake"></i> Bagi Hasil Dokter
        </a>
    </nav>
</aside>
