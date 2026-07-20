<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Edit Pasien</h1>
</div>

<div class="card-dark" style="max-width: 600px;">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-danger-custom">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('pasien/update/' . $pasien->id) ?>
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="PATCH">

        <div class="mb-3">
            <label class="form-label-dark" for="nomor_rekam_medis">Nomor Rekam Medis</label>
            <input type="text" name="nomor_rekam_medis" id="nomor_rekam_medis" class="form-control-dark"
                   value="<?= esc(old('nomor_rekam_medis', $pasien->nomor_rekam_medis)) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label-dark" for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control-dark"
                   value="<?= esc(old('nama', $pasien->nama)) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label-dark" for="no_telepon">No Telepon</label>
            <input type="text" name="no_telepon" id="no_telepon" class="form-control-dark"
                   value="<?= esc(old('no_telepon', $pasien->no_telepon ?? '')) ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-primary-custom"><i class="fas fa-save"></i> Simpan</button>
            <a href="/pasien" class="btn-primary-custom" style="background: var(--text-secondary);">Batal</a>
        </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
