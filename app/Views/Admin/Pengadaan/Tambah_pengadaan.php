<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Pengadaan Barang</h1>

    <?php if (session()->getFlashdata('msg')) : ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('msg'); ?>
            </div>
        </div>
    </div>

    <?php endif; ?>

    <form action="<?= base_url('/Admin/simpanPengadaan') ?> " method="post" enctype="multipart/form-data" id="form">
        <div class="row">
            <div class="col-12">

                <div class="card shadow">
                    <div class="card-header">
                        <!-- kiri kanan -->
                        <div class="row">
                            <div class="col-6">
                                <a href="/Admin/pengadaan">&laquo; Kembali ke daftar pengadaan barang</a>
                            </div>
                            <div class="col-6 text-right">

                                <button type="button" class="btn btn-primary" id="add-form">Tambah form</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= helper('form'); ?>

                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group ">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input name="nama_barang[]" type="text" class="form-control form-control-user"
                                        id="input-nama_barang" placeholder="Masukkan Nama Barang" value="" required />

                                </div>
                                <div class="form-group ">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <textarea name="spesifikasi[]" class="form-control form-control-user "
                                        id="input-spesifikasi" placeholder="Masukkan spesifikasi Barang"
                                        required></textarea>

                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah"
                                        class="form-control form-control-user " autofocus required>

                                </div>
                                <div class="form-group">
                                    <label for="tahun_periode">Pilih Tahun</label>
                                    <select name="tahun_periode" class="form-control form-control-user "
                                        id="input-tahun_periode" required>
                                        <option value="" disabled selected>Pilih Tahun</option>
                                        <?php
                                        $startYear = date('Y'); // Tahun sekarang
                                        $numOfYears = 15; // Jumlah tahun yang ingin ditampilkan

                                        for ($i = 0; $i < $numOfYears; $i++) {
                                            $year = $startYear + $i;
                                            echo "<option value=\"$year\">" . $year . "</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="alasan_pengadaan">alasan pengadaan Barang</label>
                                    <textarea name="alasan_pengadaan[]" class="form-control form-control-user"
                                        id="input-alasan_pengadaan" cols="30" rows="13"
                                        placeholder="Masukkan alasan pengadaan Barang" required></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="form"></div>

        <button class="btn btn-block btn-primary" id="btn_submit">Tambah Data</button>
    </form>

</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js">
</script>
<script>
// add new form
$('#add-form').on('click', function() {
    $('#btn_submit').remove();
    $('#form').append(`
        <div class="row my-2">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                    <button type="button" class="btn btn-danger" id="remove-form">Hapus</button>
                    </div>
                    <div class="card-body">
                        <?= helper('form'); ?>
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input name="nama_barang[]" type="text" class="form-control form-control-user " id="input-nama_barang" placeholder="Masukkan Nama Barang" value="" required/>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <textarea name="spesifikasi[]" class="form-control form-control-user " id="input-spesifikasi" placeholder="Masukkan spesifikasi Barang" required></textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah" class="form-control form-control-user " value="" autofocus required>
                                    
                                </div>
                                
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="alasan_pengadaan">alasan pengadaan Barang</label>
                                    <textarea name="alasan_pengadaan[]" class="form-control form-control-user " id="input-alasan_pengadaan" cols="30" rows="13" placeholder="Masukkan alasan pengadaan Barang" required></textarea>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `);
    $('#form').append(`<button class="btn btn-block btn-primary" id="btn_submit">Tambah Data</button>`);
});
// hapus form
$('#form').on('click', '#remove-form', function() {
    $(this).closest('.row').remove();
});
</script>
<?= $this->endSection(); ?>