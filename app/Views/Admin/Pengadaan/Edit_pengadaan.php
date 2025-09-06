<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Edit Pengadaan Barang</h1>

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
                    <a href="/Admin/detailPengadaan/<?= $pengadaan['id_pengadaan_barang'] ?>">&laquo; Kembali ke detail
                        pengadaan
                        barang</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/Admin/updatePengadaan/' . $pengadaan['id']) ?>" method="post"
                        enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input name="nama_barang" type="text"
                                        class="form-control form-control-user <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>"
                                        id="input-nama_barang" value="<?= $pengadaan['nama_barang']; ?>" />
                                    <div id="nama_barangFeedback" class="invalid-feedback">
                                        <?= $validation->getError('nama_barang'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi Barang</label>
                                    <input name="spesifikasi" type="text"
                                        class="form-control form-control-user <?= ($validation->hasError('spesifikasi')) ? 'is-invalid' : ''; ?>"
                                        id="input-spesifikasi"
                                        value="<?= old('spesifikasi') ?? $pengadaan['spesifikasi']; ?>" />
                                    <div id="spesifikasiFeedback" class="invalid-feedback">
                                        <?= $validation->getError('spesifikasi'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah"
                                        class="form-control form-control-user <?= $validation->hasError('jumlah') ? 'is-invalid' : ''; ?>"
                                        value="<?= $pengadaan['jumlah']; ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah'); ?>
                                    </div>
                                </div>

                                <input type="hidden" name="id_pengadaan_barang"
                                    value="<?= $pengadaan['id_pengadaan_barang']; ?>">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group">
                                    <label for="alasan_pengadaan">Jelaskan lebih rinci Alasan pengadaan</label>
                                    <textarea name="alasan_pengadaan" id="alasan_pengadaan" cols="30" rows="13"
                                        class="form-control <?= $validation->hasError('alasan_pengadaan') ? 'is-invalid' : ''; ?>"><?= $pengadaan['alasan_pengadaan']; ?>
                                    </textarea>

                                    <div class="invalid-feedback">
                                        <?= $validation->getError('alasan_pengadaan'); ?>
                                    </div>
                                </div>



                            </div>
                            <button class="btn btn-block btn-primary">Update Data</button>
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
$(document).ready(function() {
    $('#jumlah').on('input', function() {
        var nilaiInput = parseInt($(this).val());

        if (isNaN(nilaiInput) || nilaiInput <= 0) {
            $(this).val('');
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text(
                'Jumlah harus diisi dengan angka bulat positif lebih dari 0.');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });

    $('form').submit(function() {
        var inputJumlah = $('#jumlah').val();
        var nilaiInputJumlah = parseInt(inputJumlah);

        if (isNaN(nilaiInputJumlah) || nilaiInputJumlah <= 0) {
            $('#jumlah').val('');
            $('#jumlah').addClass('is-invalid');
            $('#jumlah').siblings('.invalid-feedback').text(
                'Jumlah harus diisi dengan angka bulat positif lebih dari 0.');
            return false;
        }

        return true;
    });

    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);
});
// Saat radio button berubah
$('input[type=radio]').click(function() {
    if ($(this).hasClass('anonym')) {
        $('.nama_pengaju').val('anonym').hide();
    } else {
        $('.nama_pengaju').show();
    }
});
</script>
<?= $this->endSection(); ?>