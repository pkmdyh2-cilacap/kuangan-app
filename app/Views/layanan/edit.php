<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Edit Layanan</h1>
</div>

<div class="card-dark" style="max-width: 600px;">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-danger-custom">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('/layanan/update/' . $layanan->id) ?>
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">

        <div class="mb-3">
            <label for="nama_layanan" class="form-label-dark">Nama Layanan</label>
            <input type="text" name="nama_layanan" id="nama_layanan" class="form-control-dark"
                   value="<?= esc(old('nama_layanan', $layanan->nama_layanan)) ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label-dark">Kategori</label>
            <select name="kategori" id="kategori" class="form-control-dark" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach (['Obat', 'Jasa Dokter', 'Lab', 'Tindakan'] as $kat): ?>
                    <option value="<?= $kat ?>" <?= old('kategori', $layanan->kategori) === $kat ? 'selected' : '' ?>><?= $kat ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="harga" class="form-label-dark">Harga (Rp)</label>
            <input type="number" name="harga" id="harga" class="form-control-dark"
                   value="<?= esc(old('harga', $layanan->harga)) ?>" min="0" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Update</button>
            <a href="/layanan" class="btn-primary-custom" style="background: var(--text-secondary);">Batal</a>
        </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
