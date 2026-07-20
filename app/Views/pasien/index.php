<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>
<div class="page-header">
    <h1>Data Pasien</h1>
    <?= anchor('pasien/create', '<i class="fas fa-plus"></i> Tambah Pasien', ['class' => 'btn-primary-custom']) ?>
</div>

<div class="card-dark mb-4">
    <form action="<?= base_url('pasien') ?>" method="get">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label-dark" for="search">Cari Pasien</label>
                <input type="text" name="search" id="search" class="form-control-dark" placeholder="Nama atau No. RM..." value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary-custom"><i class="fas fa-search"></i> Cari</button>
            </div>
        </div>
    </form>
</div>

<div class="card-dark">
    <?php if (!empty($pasien) && count($pasien) > 0): ?>
        <table class="table-dark-custom">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No RM</th>
                    <th>Nama</th>
                    <th>No Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($pasien as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($p->nomor_rekam_medis) ?></td>
                    <td><?= esc($p->nama) ?></td>
                    <td><?= esc($p->no_telepon ?? '-') ?></td>
                    <td>
                        <?= anchor('pasien/detail/' . $p->id, '<i class="fas fa-eye"></i>', ['class' => 'btn-sm-custom btn-view me-1']) ?>
                        <?= anchor('pasien/edit/' . $p->id, '<i class="fas fa-edit"></i>', ['class' => 'btn-sm-custom btn-edit me-1']) ?>
                        <?= form_open('pasien/delete/' . $p->id, ['style' => 'display:inline']) ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn-sm-custom btn-delete" onclick="return confirm('Yakin ingin menghapus?')"><i class="fas fa-trash"></i></button>
                        <?= form_close() ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-users"></i>
            <p>Tidak ada data pasien.</p>
            <?= anchor('pasien/create', 'Tambah Pasien Baru', ['class' => 'btn-primary-custom mt-3']) ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
