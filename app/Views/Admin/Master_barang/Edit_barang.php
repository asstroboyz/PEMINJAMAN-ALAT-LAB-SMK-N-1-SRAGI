<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Edit Data Barang</h1>

    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('msg'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <a href="/Admin/master_barang">&laquo; Kembali ke daftar barang</a>
                </div>
                <div class="card-body">
                    <form action="/Admin/editMaster/<?= $master_brg['kode_brg']; ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <!-- Kode Barang -->
                                <div class="form-group">
                                    <label for="kode_brg">Kode Barang</label>
                                    <input name="kode_brg" type="text"
                                        class="form-control <?= ($validation->hasError('kode_brg')) ? 'is-invalid' : ''; ?>"
                                        id="input-kode_brg"
                                        value="<?= $master_brg['kode_brg']; ?>" readonly />
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode_brg'); ?>
                                    </div>
                                </div>

                                <!-- Nama Barang -->
                                <div class="form-group">
                                    <label for="nama_brg">Nama Barang</label>
                                    <input name="nama_brg" type="text"
                                        class="form-control <?= ($validation->hasError('nama_brg')) ? 'is-invalid' : ''; ?>"
                                        id="input-nama_brg"
                                        value="<?= $master_brg['nama_brg']; ?>" />
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama_brg'); ?>
                                    </div>
                                </div>

                                <!-- Merk -->
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input name="merk" type="text"
                                        class="form-control <?= ($validation->hasError('merk')) ? 'is-invalid' : ''; ?>"
                                        id="input-merk"
                                        value="<?= $master_brg['merk']; ?>" />
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('merk'); ?>
                                    </div>
                                </div>

                                <!-- Spesifikasi -->
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <textarea name="spesifikasi" id="spesifikasi"
                                        class="form-control <?= ($validation->hasError('spesifikasi')) ? 'is-invalid' : ''; ?>"
                                        rows="3"><?= $master_brg['spesifikasi']; ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('spesifikasi'); ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <!-- Jenis Barang -->
                                <div class="form-group">
                                    <label for="jenis_brg">Jenis Barang</label>
                                    <select name="jenis_brg" id="jenis_brg"
                                        class="form-control <?= ($validation->hasError('jenis_brg')) ? 'is-invalid' : ''; ?>">
                                        <option value="">-- Pilih Jenis Barang --</option>
                                        <option value="hrd" <?= $master_brg['jenis_brg'] == 'hrd' ? 'selected' : ''; ?>>Hardware</option>
                                        <option value="sfw" <?= $master_brg['jenis_brg'] == 'sfw' ? 'selected' : ''; ?>>Software</option>
                                        <option value="tools" <?= $master_brg['jenis_brg'] == 'tools' ? 'selected' : ''; ?>>Tools</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jenis_brg'); ?>
                                    </div>
                                </div>

                                <!-- Satuan -->
                                <div class="form-group">
                                    <label for="id_satuan">Satuan</label>
                                    <select name="id_satuan" id="id_satuan"
                                        class="form-control <?= ($validation->hasError('id_satuan')) ? 'is-invalid' : ''; ?>">
                                        <option value="">-- Pilih Satuan --</option>
                                        <?php foreach ($satuan as $s) : ?>
                                            <option value="<?= $s['satuan_id']; ?>" <?= $master_brg['id_satuan'] == $s['satuan_id'] ? 'selected' : ''; ?>>
                                                <?= $s['nama_satuan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('id_satuan'); ?>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <select name="is_active" id="is_active"
                                        class="form-control <?= ($validation->hasError('is_active')) ? 'is-invalid' : ''; ?>">
                                        <option value="1" <?= $master_brg['is_active'] == '1' ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="0" <?= $master_brg['is_active'] == '0' ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('is_active'); ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <button class="btn btn-block btn-warning">Update Data</button>
                    </form>
                </div>
            </div>
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
