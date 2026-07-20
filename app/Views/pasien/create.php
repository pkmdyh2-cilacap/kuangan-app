<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Tambah Pasien</h1>
</div>

<div class="card-dark" style="max-width: 600px;">
    <?php if (session()->has('errors')): ?>
        <div class="alert-danger-custom">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php foreach (session('errors') as $error): ?>
                <div><?= esc($error) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= form_open('pasien/save') ?>
    <?= csrf_field() ?>

    <div class="mb-3">
        <label class="form-label-dark" for="no_rm">Nomor Rekam Medis</label>
        <input type="text" name="no_rm" id="no_rm" class="form-control form-control-dark" value="<?= esc(old('no_rm')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label-dark" for="nama">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control form-control-dark" value="<?= esc(old('nama')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label-dark" for="no_telepon">No Telepon</label>
        <input type="text" name="no_telepon" id="no_telepon" class="form-control form-control-dark" value="<?= esc(old('no_telepon')) ?>">
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary-custom"><i class="fas fa-save"></i> Simpan</button>
        <?= anchor('pasien', '<i class="fas fa-arrow-left"></i> Batal', ['class' => 'btn btn-primary-custom', 'style' => 'background:var(--text-secondary);']) ?>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>
