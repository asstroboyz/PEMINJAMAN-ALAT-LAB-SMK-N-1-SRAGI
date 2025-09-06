<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-900"><?= esc($title) ?></h1>

    <?php if (session()->getFlashdata('PesanGagal')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('PesanGagal') ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <a href="/admin/KategoriMerk">&laquo; Kembali ke daftar</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/Admin/SaveKategorimerk') ?>" method="post">
                <?= csrf_field(); ?>

                <div class="form-group">
                    <label for="kategori_id">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control <?= ($validation->hasError('kategori_id')) ? 'is-invalid' : ''; ?>">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach ($kategori as $k) : ?>
                            <option value="<?= $k['id'] ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                                <?= esc($k['nama_kategori']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= $validation->getError('kategori_id'); ?></div>
                </div>

                <div class="form-group">
                    <label for="merk_id">Merk</label>
                    <select name="merk_id" id="merk_id" class="form-control <?= ($validation->hasError('merk_id')) ? 'is-invalid' : ''; ?>">
                        <option value="">-- Pilih Merk --</option>
                        <?php foreach ($merk as $m) : ?>
                            <option value="<?= $m['id'] ?>" <?= old('merk_id') == $m['id'] ? 'selected' : '' ?>>
                                <?= esc($m['nama_merk']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= $validation->getError('merk_id'); ?></div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Tambah</button>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    });
</script>
<?= $this->endSection(); ?>
