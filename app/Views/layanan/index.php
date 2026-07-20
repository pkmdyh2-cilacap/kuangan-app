<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Layanan & Inventory</h1>
    <a href="/layanan/create" class="btn-primary-custom">
        <i class="fas fa-plus"></i> Tambah Layanan
    </a>
</div>

<div class="card-dark">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <a href="/layanan?kategori=Semua" class="btn-sm-custom <?= ($kategori ?? '') === 'Semua' || empty($kategori) ? 'btn-view' : '' ?>" style="background: <?= ($kategori ?? '') === 'Semua' || empty($kategori) ? 'var(--accent-blue)' : 'rgba(255,255,255,0.1)' ?>;">Semua</a>
            <a href="/layanan?kategori=Obat" class="btn-sm-custom" style="background: <?= ($kategori ?? '') === 'Obat' ? 'var(--accent-blue)' : 'rgba(255,255,255,0.1)' ?>;">Obat</a>
            <a href="/layanan?kategori=Jasa Dokter" class="btn-sm-custom" style="background: <?= ($kategori ?? '') === 'Jasa Dokter' ? 'var(--accent-blue)' : 'rgba(255,255,255,0.1)' ?>;">Jasa Dokter</a>
            <a href="/layanan?kategori=Lab" class="btn-sm-custom" style="background: <?= ($kategori ?? '') === 'Lab' ? 'var(--accent-blue)' : 'rgba(255,255,255,0.1)' ?>;">Lab</a>
            <a href="/layanan?kategori=Tindakan" class="btn-sm-custom" style="background: <?= ($kategori ?? '') === 'Tindakan' ? 'var(--accent-blue)' : 'rgba(255,255,255,0.1)' ?>;">Tindakan</a>
        </div>
        <form action="/layanan" method="GET" class="d-flex gap-2">
            <?php if (!empty($kategori)): ?>
                <input type="hidden" name="kategori" value="<?= esc($kategori) ?>">
            <?php endif; ?>
            <input type="text" name="search" class="form-control-dark" placeholder="Cari layanan..." value="<?= esc($search ?? '') ?>" style="width: 250px;">
            <button type="submit" class="btn-primary-custom">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <?php if (empty($layanan)): ?>
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>Belum ada data layanan</p>
        </div>
    <?php else: ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($layanan as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($item->nama_layanan) ?></td>
                        <td>
                            <?php
                                $badgeClass = 'badge-blue';
                                if ($item->kategori === 'Obat') $badgeClass = 'badge-green';
                                elseif ($item->kategori === 'Jasa Dokter') $badgeClass = 'badge-blue';
                                elseif ($item->kategori === 'Lab') $badgeClass = 'badge-red';
                                elseif ($item->kategori === 'Tindakan') $badgeClass = 'badge-green';
                            ?>
                            <span class="<?= $badgeClass ?>"><?= esc($item->kategori) ?></span>
                        </td>
                        <td>Rp <?= number_format($item->harga, 0, ',', '.') ?></td>
                        <td>
                            <a href="/layanan/edit/<?= $item->id ?>" class="btn-sm-custom btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="/layanan/delete/<?= $item->id ?>" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn-sm-custom btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.classList.remove('active');
    });
    const layananLink = document.querySelector('.sidebar-menu a[href="/layanan"]');
    if (layananLink) layananLink.classList.add('active');
</script>
<?= $this->endSection() ?>