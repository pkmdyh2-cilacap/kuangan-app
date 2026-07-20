<?= $this->extend('layout/master') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Tambah Transaksi <?= $tipe === 'pemasukan' ? 'Pemasukan' : 'Pengeluaran' ?></h1>
    <a href="/transaksi/<?= $tipe ?>" class="btn-primary-custom" style="background: var(--text-secondary);">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?= form_open('/transaksi/store') ?>
    <?= csrf_field() ?>
    <input type="hidden" name="tipe_transaksi" value="<?= $tipe ?>">

    <div class="row">
        <div class="col-md-8">
            <div class="card-dark mb-4">
                <h5 style="margin-bottom: 20px; font-weight: 600;">Informasi Transaksi</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label-dark">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control-dark"
                               value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-dark">Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control-dark" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="tunai" <?= old('metode_pembayaran') === 'tunai' ? 'selected' : '' ?>>Tunai</option>
                            <option value="debit" <?= old('metode_pembayaran') === 'debit' ? 'selected' : '' ?>>Debit</option>
                            <option value="qris" <?= old('metode_pembayaran') === 'qris' ? 'selected' : '' ?>>QRIS</option>
                        </select>
                    </div>
                </div>

                <?php if ($tipe === 'pemasukan'): ?>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label-dark">Pasien</label>
                            <select name="pasien_id" class="form-control-dark" required>
                                <option value="">-- Pilih Pasien --</option>
                                <?php foreach ($pasien_list as $ps): ?>
                                    <option value="<?= $ps->id ?>" <?= old('pasien_id') == $ps->id ? 'selected' : '' ?>>
                                        <?= esc($ps->nama) ?> (<?= esc($ps->nomor_rekam_medis) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label-dark">Keterangan</label>
                    <textarea name="keterangan" class="form-control-dark" rows="3"
                              placeholder="Keterangan transaksi..."><?= old('keterangan') ?></textarea>
                </div>
            </div>

            <div class="card-dark mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 style="font-weight: 600;">Detail Items</h5>
                    <button type="button" class="btn-primary-custom" id="addItemBtn">
                        <i class="fas fa-plus"></i> Tambah Item
                    </button>
                </div>

                <div id="items-container">
                    <div class="item-row mb-3 p-3" style="background: var(--bg-input); border-radius: 8px;">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <label class="form-label-dark">Layanan</label>
                                <select name="layanan_id[]" class="form-control-dark layanan-select" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    <?php foreach ($layanan_list as $lay): ?>
                                        <option value="<?= $lay->id ?>" data-harga="<?= $lay->harga ?>">
                                            <?= esc($lay->nama_layanan) ?> - Rp <?= number_format($lay->harga, 0, ',', '.') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-dark">Kuantitas</label>
                                <input type="number" name="kuantitas[]" class="form-control-dark kuantitas-input"
                                       value="1" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-dark">Subtotal</label>
                                <div class="subtotal-display" style="padding: 10px 14px; font-weight: 600; color: var(--accent-green);">
                                    Rp 0
                                </div>
                                <input type="hidden" name="subtotal[]" class="subtotal-input" value="0">
                            </div>
                            <div class="col-md-2 text-end">
                                <button type="button" class="btn-sm-custom btn-delete remove-item-btn" style="margin-top: 24px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dark" style="position: sticky; top: 24px;">
                <h5 style="margin-bottom: 20px; font-weight: 600;">Ringkasan</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: var(--text-secondary);">Tipe</span>
                    <span class="<?= $tipe === 'pemasukan' ? 'badge-green' : 'badge-red' ?>">
                        <?= ucfirst($tipe) ?>
                    </span>
                </div>
                <hr style="border-color: rgba(255,255,255,0.06); margin: 16px 0;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span style="font-size: 16px; font-weight: 600;">Total</span>
                    <span id="total-display" style="font-size: 20px; font-weight: 700; color: var(--accent-blue);">
                        Rp 0
                    </span>
                </div>
                <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="padding: 12px;">
                    <i class="fas fa-save"></i> Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
<?= form_close() ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let itemIndex = 1;
    const container = document.getElementById('items-container');
    const addBtn = document.getElementById('addItemBtn');

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function hitungSubtotal(row) {
        const select = row.querySelector('.layanan-select');
        const kuantitas = parseInt(row.querySelector('.kuantitas-input').value) || 0;
        const option = select.options[select.selectedIndex];
        const harga = option && option.dataset.harga ? parseInt(option.dataset.harga) : 0;
        const subtotal = harga * kuantitas;
        row.querySelector('.subtotal-display').textContent = formatRupiah(subtotal);
        row.querySelector('.subtotal-input').value = subtotal;
        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(function (row) {
            const select = row.querySelector('.layanan-select');
            const kuantitas = parseInt(row.querySelector('.kuantitas-input').value) || 0;
            const option = select.options[select.selectedIndex];
            const harga = option && option.dataset.harga ? parseInt(option.dataset.harga) : 0;
            total += harga * kuantitas;
        });
        document.getElementById('total-display').textContent = formatRupiah(total);
    }

    function bindRowEvents(row) {
        row.querySelector('.layanan-select').addEventListener('change', function () {
            hitungSubtotal(row);
        });
        row.querySelector('.kuantitas-input').addEventListener('input', function () {
            hitungSubtotal(row);
        });
        row.querySelector('.remove-item-btn').addEventListener('click', function () {
            if (document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                hitungTotal();
            }
        });
    }

    bindRowEvents(container.querySelector('.item-row'));

    addBtn.addEventListener('click', function () {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('select, input').forEach(function (el) {
            if (el.tagName === 'SELECT') el.selectedIndex = 0;
            if (el.type === 'number') el.value = '1';
        });

        newRow.querySelector('.subtotal-display').textContent = formatRupiah(0);
        newRow.querySelector('.subtotal-input').value = 0;
        container.appendChild(newRow);
        bindRowEvents(newRow);
        itemIndex++;
    });
});
</script>
<?= $this->endSection() ?>
