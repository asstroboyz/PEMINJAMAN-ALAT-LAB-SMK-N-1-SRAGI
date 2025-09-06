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
                    <a href="/Admin/Kategori">&laquo; Kembali ke daftar Kategori</a>
                </div>
                <div class="card-body">
                    <form action="/Admin/updateKategori" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <input type="hidden" name="id" value="<?= $kategori['id']; ?>">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="nama_kategori">Nama Merk</label>
                                    <input name="nama_kategori" type="text" class="form-control form-control-user <?= ($validation->hasError('nama_kategori')) ? 'is-invalid' : ''; ?>" id="input-nama_kategori" value="<?= $kategori['nama_kategori']; ?>" />
                                    <div id="nama_satuanFeedback" class="invalid-feedback">
                                        <?= $validation->getError('nama_kategori'); ?>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-block btn-warning">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection('page-content'); ?>
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