<?php echo $this->extend('Admin/Templates/Index') ?>
<?php echo $this->section('page-content'); ?>
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-900">Form Tambah Barang</h1>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo session()->getFlashdata('msg'); ?>
    </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <a href="/Admin/master_barang">&laquo; Kembali ke daftar barang</a>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/Admin/saveBarang') ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">

                        <!-- Nama Barang -->
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input name="nama_barang" type="text"
                                class="form-control <?php echo ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>"
                                id="input-nama_barang" placeholder="Masukkan Nama Barang"
                                value="<?php echo old('nama_barang'); ?>" />
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('nama_barang'); ?>
                            </div>
                        </div>

                        <!-- Kategori Barang -->
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="form-control <?php echo ($validation->hasError('kategori_id')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_barang as $k) : ?>
                                    <option value="<?= $k['id']; ?>" <?= old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                                        <?= $k['nama_kategori']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('kategori_id'); ?>
                            </div>
                        </div>

                        <!-- Merk Barang (Dropdown, otomatis terisi oleh JS) -->
                        <div class="form-group">
                            <label for="merk_id">Merk</label>
                            <select name="merk_id" id="merk_id"
                                class="form-control <?php echo ($validation->hasError('merk_id')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Merk (Pilih kategori dulu) --</option>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('merk_id'); ?>
                            </div>
                        </div>

                        <!-- Spesifikasi -->
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi</label>
                            <input name="spesifikasi" type="text"
                                class="form-control <?php echo ($validation->hasError('spesifikasi')) ? 'is-invalid' : ''; ?>"
                                id="input-spesifikasi" placeholder="Masukkan Spesifikasi Barang"
                                value="<?php echo old('spesifikasi'); ?>" />
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('spesifikasi'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <!-- Jenis Barang -->
                        <div class="form-group">
                            <label for="jenis_brg">Jenis Barang</label>
                            <select name="jenis_brg" id="jenis_brg"
                                class="form-control <?php echo ($validation->hasError('jenis_brg')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Jenis Barang --</option>
                                <option value="hrd" <?php echo old('jenis_brg') == 'hrd' ? 'selected' : '' ?>>hrd</option>
                                <option value="sfw" <?php echo old('jenis_brg') == 'sfw' ? 'selected' : '' ?>>sfw</option>
                                <option value="tools" <?php echo old('jenis_brg') == 'tools' ? 'selected' : '' ?>>Tools</option>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('jenis_brg'); ?>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div class="form-group">
                            <label for="id_satuan">Satuan</label>
                            <select name="id_satuan" id="id_satuan"
                                class="form-control <?php echo ($validation->hasError('id_satuan')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Satuan --</option>
                                <?php foreach ($satuan as $s) : ?>
                                    <option value="<?= $s['satuan_id']; ?>" <?= old('id_satuan') == $s['satuan_id'] ? 'selected' : '' ?>>
                                        <?= $s['nama_satuan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('id_satuan'); ?>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select name="is_active" id="is_active"
                                class="form-control <?php echo ($validation->hasError('is_active')) ? 'is-invalid' : ''; ?>">
                                <option value="1" <?= old('is_active') == '1' ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= old('is_active') == '0' ? 'selected' : '' ?>>Nonaktif</option>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $validation->getError('is_active'); ?>
                            </div>
                        </div>

                    </div>
                </div>
                <button class="btn btn-block btn-primary mt-4">Tambah Data</button>
            </form>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('additional-js'); ?>
<script>
$(document).ready(function() {
    // Filter merk otomatis sesuai kategori
    $('#kategori_id').on('change', function() {
        var kategoriId = $(this).val();
        $('#merk_id').html('<option value="">Loading...</option>');
        if (kategoriId !== '') {
            $.get('/Admin/getMerkByKategori/' + kategoriId, function(data) {
                var options = '<option value="">-- Pilih Merk --</option>';
                if (data.length > 0) {
                    data.forEach(function(m) {
                        options += '<option value="' + m.id + '">' + m.nama_merk + '</option>';
                    });
                } else {
                    options += '<option value="">(Tidak ada merk di kategori ini)</option>';
                }
                $('#merk_id').html(options);
            });
        } else {
            $('#merk_id').html('<option value="">-- Pilih Merk (Pilih kategori dulu) --</option>');
        }
    });

    // Restore merk_id kalau form gagal dan kembali dari validation
    <?php if (old('kategori_id') && old('merk_id')): ?>
        var kategoriIdOld = '<?= old('kategori_id') ?>';
        var merkIdOld = '<?= old('merk_id') ?>';
        $.get('/Admin/getMerkByKategori/' + kategoriIdOld, function(data) {
            var options = '<option value="">-- Pilih Merk --</option>';
            if (data.length > 0) {
                data.forEach(function(m) {
                    var selected = m.id == merkIdOld ? 'selected' : '';
                    options += '<option value="' + m.id + '" ' + selected + '>' + m.nama_merk + '</option>';
                });
            } else {
                options += '<option value="">(Tidak ada merk di kategori ini)</option>';
            }
            $('#merk_id').html(options);
        });
    <?php endif; ?>

    // Optional: Fade alert
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);
});
</script>
<?php echo $this->endSection(); ?>
