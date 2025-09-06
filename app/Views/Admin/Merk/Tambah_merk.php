<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Merk</h1>

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
                    <a href="/Admin/merk">&laquo; Kembali ke daftar master merk</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/Admin/simpanMerk') ?> " method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group ">
                                    <label for="nama_merk">Nama Merk</label>
                                    <input name="nama_merk" type="text" class="form-control form-control-user <?= ($validation->hasError('nama_merk')) ? 'is-invalid' : ''; ?>" id="input-nama_merk" placeholder="Masukkan Nama Barang" value="<?= old('nama_merk'); ?>" />
                                    <div id="nama_satuanFeedback" class="invalid-feedback">
                                        <?= $validation->getError('nama_merk'); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-block btn-primary">Tambah Data</button>
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