<?=$this->extend('Admin/Templates/Index');?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Stok Barang</h1>

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
                    <a href="/Admin/atk">&laquo; Kembali ke daftar barang</a>
                </div>
                <div class="card-body">
                    <form
                        action="/Admin/tambahStok/<?= $kode_barang; ?>"
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input name="kode_barang" type="text" class="form-control" id="kode_barang"
                                        value="<?= $kode_barang; ?>"
                                        readonly />
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok Barang Yang Tersedia</label>
                                    <input name="stok" type="text" class="form-control" id="stok"
                                        value="<?= $stok; ?>"
                                        readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_barang_masuk">Tanggal Masuk</label>
                                    <input name="tanggal_barang_masuk" type="date"
                                        class="form-control <?= ($validation->hasError('tanggal_barang_masuk')) ? 'is-invalid' : ''; ?>"
                                        id="tanggal_barang_masuk"
                                        value="<?= old('tanggal_barang_masuk'); ?>" />
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal_barang_masuk'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_penambahan_stok">Jumlah Penambahan Stok</label>
                                    <input name="jumlah_penambahan_stok" type="number"
                                        class="form-control <?= ($validation->hasError('jumlah_penambahan_stok')) ? 'is-invalid' : ''; ?>"
                                        id="jumlah_penambahan_stok" placeholder="Jumlah Penambahan Stok"
                                        value="<?= old('jumlah_penambahan_stok'); ?>" />
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah_penambahan_stok'); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">Tambah Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        })
    }, 3000);
    document.addEventListener('DOMContentLoaded', function() {
        var inputJumlahPenambahanStok = document.getElementById('jumlah_penambahan_stok');

        inputJumlahPenambahanStok.addEventListener('input', function() {
            var nilaiInput = parseInt(inputJumlahPenambahanStok.value);

            if (isNaN(nilaiInput) || nilaiInput <= 0) {
                inputJumlahPenambahanStok.value = '';
            }
        });
    });
</script>
<?= $this->endSection(); ?>