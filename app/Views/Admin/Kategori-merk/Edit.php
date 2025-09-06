<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900"><?= esc($title) ?></h1>

    <form action="/Admin/KategoriMerk_update/<?= $relasi['id'] ?>" method="post">
        <?= csrf_field(); ?>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control">
                <?php foreach ($kategori as $k) : ?>
                    <option value="<?= $k['id'] ?>" <?= $relasi['kategori_id'] == $k['id'] ? 'selected' : '' ?>>
                        <?= esc($k['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="merk_id">Merk</label>
            <select name="merk_id" id="merk_id" class="form-control">
                <?php foreach ($merk as $m) : ?>
                    <option value="<?= $m['id'] ?>" <?= $relasi['merk_id'] == $m['id'] ? 'selected' : '' ?>>
                        <?= esc($m['nama_merk']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="/Admin/relasi_index" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection(); ?>
