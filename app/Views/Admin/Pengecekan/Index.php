<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Pengecekan Barang</h1>

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
                    <a href="/Admin/adm_inventaris">&laquo; Kembali ke daftar barang</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/Admin/simpanPengecekan') ?> " method="post"
                        enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <input type="hidden" name="id_inventaris" value="<?= $barang['kode_barang'] ?>">
                                <div class="form-group ">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input name="nama_barang" type="text" class="form-control form-control-user "
                                        id="input-nama_barang" placeholder="Masukkan Nama Barang"
                                        value="<?= $barang['nama_brg'] ?>" readonly>

                                </div>
                            </div>
                            <input name="lokasi_barang" type="text" class="form-control form-control-user "
                                id="input-lokasi_barang" placeholder="Masukkan Lokasi Barang"
                                value="<?= $barang['lokasi'] ?>">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="lokasi">Runagan </label>
                                    <select name="lokasi" class="form-control form-control-user" id="input-lokasi">
                                        <option value="">Pilih Ruangan</option>
                                        <option value="Staf Umum" <?php if ($barang['lokasi'] == 'Staf Umum') : ?>
                                            selected <?php endif; ?>>Staf Umum</option>
                                        <option value="LPDSS" <?php if ($barang['lokasi'] == 'LPDSS') : ?> selected
                                            <?php endif; ?>>LPDSS
                                        </option>
                                        <option value="Produksi" <?php if ($barang['lokasi'] == 'Produksi') : ?>
                                            selected <?php endif; ?>>Produksi
                                        </option>
                                        <option value="Kepela" <?php if ($barang['lokasi'] == 'Kepela') : ?> selected
                                            <?php endif; ?>>Kepela</option>
                                        <option value="PST" <?php if ($barang['lokasi'] == 'PST') : ?> selected
                                            <?php endif; ?>>PST</option>
                                        <option value="Lobby" <?php if ($barang['lokasi'] == 'Lobby') : ?> selected
                                            <?php endif; ?>>Lobby</option>
                                        <option value="Gudang" <?php if ($barang['lokasi'] == 'Gudang') : ?> selected
                                            <?php endif; ?>>Gudang</option>
                                        <option value="Dapur" <?php if ($barang['lokasi'] == 'Dapur') : ?> selected
                                            <?php endif; ?>>Dapur</option>
                                        <option value="Mushola" <?php if ($barang['lokasi'] == 'Mushola') : ?> selected
                                            <?php endif; ?>>Mushola</option>
                                    </select>

                                </div>
                            </div>
                            <!-- keterangan -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" type="text" class="form-control form-control-user "
                                        id="input-keterangan"></textarea>
                                </div>
                            </div>
                            <!-- kondisi -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="kondisi">Kondisi</label>
                                    <select name="kondisi" class="form-control form-control-user" id="input-kondisi">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-block btn-primary">Simpan</button>
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