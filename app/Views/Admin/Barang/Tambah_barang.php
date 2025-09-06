<?= $this->extend('Admin/Templates/Index'); ?>

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
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-header">
                    <a href="/Admin/atk">&laquo; Kembali ke daftar barang</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/Admin/tambah') ?> " method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-12">

                             <div class="form-group">
    <label for="nama_barang">Nama Barang</label>
    <select name="nama_barang" id="nama_barang" 
            class="form-control form-control-user <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>">
        <option value="">Pilih Nama Barang</option>
        <?php foreach ($master_barang as $barang) : ?>
            <option value="<?= $barang['kode_brg']; ?>">
                <?= $barang['nama_brg']; ?> (<?= ucfirst($barang['jenis_brg']); ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <div id="nama_barangFeedback" class="invalid-feedback">
        <?= $validation->getError('nama_barang'); ?>
    </div>
</div>


                                <div class="form-group">
                                    <label for="satuan_barang">Satuan Barang</label>
                                    <select name="satuan_barang" id="satuan_barang" class="form-control form-control-user <?= ($validation->hasError('satuan_barang')) ? 'is-invalid' : ''; ?>">
                                        <option value="">Pilih Satuan Barang</option>
                                        <?php foreach ($satuan as $satuan) : ?>
                                            <option value="<?= $satuan['satuan_id']; ?>"><?= $satuan['nama_satuan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <div id="satuan_barangFeedback" class="invalid-feedback">
                                        <?= $validation->getError('satuan_barang'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" name="stok" id="stok" class="form-control form-control-user <?= $validation->hasError('stok') ? 'is-invalid' : ''; ?>" value="<?= old('stok'); ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('stok'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-block btn-primary">Tambah Data</button>
                            </div>
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
        // Validasi untuk field stok
        $('#stok').on('input', function() {
            var nilaiInput = parseInt($(this).val());

            if (isNaN(nilaiInput) || nilaiInput <= 0) {
                $(this).val('');
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text(
                    'Stok harus diisi dengan angka lebih dari 0.');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        });

        // Validasi untuk field nama_barang
        $('#input-nama_barang').on('input', function() {
            var namaBarangInput = $(this).val().trim();

            if (namaBarangInput === '') {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Nama Barang harus diisi.');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        });

        // Validasi untuk field satuan_barang
        $('#input-satuan_barang').on('change', function() {
            var satuanBarangInput = $(this).val().trim();

            if (satuanBarangInput === '') {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('Satuan Barang harus dipilih.');
            } else {
                $(this).removeClass('is-invalid');
                $(this).siblings('.invalid-feedback').text('');
            }
        });

        // Validasi saat pengiriman formulir
        $('form').submit(function() {
            var inputJumlah = $('#stok').val();
            var nilaiInputJumlah = parseInt(inputJumlah);

            if (isNaN(nilaiInputJumlah) || nilaiInputJumlah <= 0) {
                $('#stok').val('');
                $('#stok').addClass('is-invalid');
                $('#stok').siblings('.invalid-feedback').text(
                    'Stok harus diisi dengan angka lebih dari 0.');
                return false;
            }

            var namaBarangInput = $('#input-nama_barang').val().trim();
            if (namaBarangInput === '') {
                $('#input-nama_barang').addClass('is-invalid');
                $('#input-nama_barang').siblings('.invalid-feedback').text('Nama Barang harus diisi.');
                return false;
            }

            var satuanBarangInput = $('#input-satuan_barang').val().trim();
            if (satuanBarangInput === '') {
                $('#input-satuan_barang').addClass('is-invalid');
                $('#input-satuan_barang').siblings('.invalid-feedback').text(
                    'Satuan Barang harus dipilih.');
                return false;
            }

            return true;
        });

        // Fungsi untuk menyembunyikan pesan sukses setelah beberapa detik
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        });
    });
</script>

<?= $this->endSection(); ?>