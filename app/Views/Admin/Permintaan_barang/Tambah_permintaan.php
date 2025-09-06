<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Barang</h1>

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
                    <a href="/inventaris">&laquo; Kembali ke daftar barang</a>
                </div>
                <div class="card-body">
                    <form
                        action="<?= base_url('/Admin/simpanPermin') ?> "
                        method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" name="perihal" id="perihal"
                                        class="form-control  <?= $validation->hasError('perihal') ? 'is-invalid' : ''; ?>"
                                        value="<?= old('perihal'); ?>"
                                        autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('perihal'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="detail">Jelaskan lebih rinci</label>
                                    <textarea name="detail" id="detail" cols="30" rows="13"
                                        class="form-control <?= $validation->hasError('detail') ? 'is-invalid' : ''; ?>"><?= old('detail'); ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('detail'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Nama Pengaju Permintaan Barang</label>
                                    <div class="form-check">
                                        <input class="form-check-input anonym" type="radio" name="nama_pengaju"
                                            id="nama_pengaju1" value="anonym" checked>
                                        <label class="form-check-label" for="nama_pengaju1">
                                            <span class="text-gray-800">Samarkan (anonym)</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nama_pengaju"
                                            id="nama_pengaju2" value="2">
                                        <label class="form-check-label" for="nama_pengaju2">
                                            <span class="text-gray-800">Gunakan nama sendiri</span>
                                        </label>
                                    </div>
                                    <input type="text" class="form-control nama_pengaju" name="nama_pengaju"
                                        value="<?= user()->username; ?>"
                                        readonly>
                                </div>

                            </div>
                            <button class="btn btn-block btn-primary">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
    $('.nama_pengaju').hide();
    $('input[type=radio]').click(function() {
        if ($(this).hasClass('anonym')) {
            $('.nama_pengaju').hide()
        } else {
            $('.nama_pengaju').show()
        }
    })
</script>
<?= $this->endSection(); ?>