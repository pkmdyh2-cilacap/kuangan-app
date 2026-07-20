<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Tambah Layanan</h1>
</div>

<div class="card-dark" style="max-width: 600px;">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert-danger-custom">
            <ul class="mb-0" style="padding-left: 18px;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?= form_open('/layanan/save') ?>
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="nama_layanan" class="form-label-dark">Nama Layanan</label>
            <input type="text" name="nama_layanan" id="nama_layanan" class="form-control-dark w-100"
                   value="<?= esc(old('nama_layanan')) ?>" placeholder="Masukkan nama layanan" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label-dark">Kategori</label>
            <select name="kategori" id="kategori" class="form-control-dark w-100" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Obat" <?= old('kategori') === 'Obat' ? 'selected' : '' ?>>Obat</option>
                <option value="Jasa Dokter" <?= old('kategori') === 'Jasa Dokter' ? 'selected' : '' ?>>Jasa Dokter</option>
                <option value="Lab" <?= old('kategori') === 'Lab' ? 'selected' : '' ?>>Lab</option>
                <option value="Tindakan" <?= old('kategori') === 'Tindakan' ? 'selected' : '' ?>>Tindakan</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="harga" class="form-label-dark">Harga (Rp)</label>
            <input type="number" name="harga" id="harga" class="form-control-dark w-100"
                   value="<?= esc(old('harga')) ?>" placeholder="Masukkan harga" min="0" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="/layanan" class="btn-sm-custom" style="background: rgba(255,255,255,0.1); padding: 8px 16px;">
                Batal
            </a>
        </div>
    <?= form_close() ?>
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