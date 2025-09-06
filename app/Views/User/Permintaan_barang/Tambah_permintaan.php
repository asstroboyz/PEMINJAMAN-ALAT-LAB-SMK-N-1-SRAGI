<?= $this->extend('Pegawai/Templates/Index'); ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Permintaan Barang</h1>

    <?php if (session()->getFlashdata('msg')) : ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('msg'); ?>
            </div>
        </div>
    </div>

    <?php endif; ?>
    <form action="<?= base_url('/Pegawai/simpanPermintaan') ?> " method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-12">

                <div class="card shadow">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">

                                <a href="/Pegawai/permintaan">&laquo; Kembali ke daftar barang</a>
                            </div>
                            <div class="col-6 text-right">

                                <button type="button" class="btn btn-primary" id="add-form">Tambah form</button>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kode_barang">Pilih Barang</label>
                                    <select name="kode_barang[]" id="kode_barang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($barangList as $brg) : ?>
                                        <option value="<?= $brg['kode_barang']; ?>"
                                            data-satuan="<?= $brg['nama_satuan']; ?>">
                                            <?= $brg['nama_brg']; ?>(<?= $brg['merk']; ?>)</option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <p>Satuan: <span id="satuan_barang"></span></p>
                                <div class="form-group">
                                    <label for="jumlah">jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah" class="form-control" autofocus
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" name="perihal[]" id="perihal" class="form-control" autofocus
                                        required>
                                </div>


                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="detail">Jelaskan lebih rinci</label>
                                    <textarea name="detail[]" id="detail[]" cols="30" rows="13" class="form-control"
                                        required></textarea>

                                </div>


                            </div>
                        </div>
                    </div>

                </div>
                <div class="" id="form"></div>
                <button class="btn btn-block btn-primary my-2" id="btn_tambah">Tambah Data</button>
            </div>
        </div>

    </form>
</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
// add new form
$('#add-form').on('click', function() {
    $('#btn_tambah').remove();
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
                                <div class="form-group">
                                    <label for="kode_barang">Pilih Barang</label>
                                    <select name="kode_barang[]" id="kode_barang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($barangList as $brg) : ?>
                                        <option value="<?= $brg['kode_barang']; ?>"
                                            data-satuan="<?= $brg['nama_satuan']; ?>"><?= $brg['merk']; ?>
                                            - <?= $brg['nama_satuan']; ?></option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>
                                <p>Satuan: <span id="satuan_barang"></span></p>
                                <div class="form-group">
                                    <label for="jumlah">jumlah</label>
                                    <input type="number" name="jumlah[]" id="jumlah" class="form-control" autofocus
                                        required>
                                </div>
                                <div class="form-group ">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" name="perihal[]" id="perihal" class="form-control" autofocus
                                        required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="detail">Jelaskan lebih rinci</label>
                                    <textarea name="detail[]" id="detail[]" cols="30" rows="13" class="form-control"
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-block btn-primary my-2" id="btn_tambah">Tambah Data</button>
        `);
});

// remove form
$('#form').on('click', '#remove-form', function() {
    $(this).closest('.row').remove();
});


$(document).ready(function() {
    // Saat dropdown 'kode_barang' berubah
    $('#kode_barang').change(function() {
        // Mendapatkan satuan dari data-satuan yang disimpan di opsi terpilih
        var selectedSatuan = $('option:selected', this).data('satuan');

        // Menampilkan satuan di elemen dengan ID 'satuan_barang'
        $('#satuan_barang').text(selectedSatuan);
    });

    // Validasi input jumlah agar tidak bernilai 0 atau negatif
    $('#jumlah').on('input', function() {
        var inputJumlah = $(this).val();

        // Menggunakan parseInt untuk mengonversi nilai input ke tipe data integer
        var nilaiInput = parseInt(inputJumlah);

        // Memastikan nilaiInput adalah angka bulat positif dan tidak 0
        if (isNaN(nilaiInput) || nilaiInput <= 0) {
            $(this).val('');
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text(
                'Jumlah harus diisi dengan angka bulat positif lebih dari 0.'
            );
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });

    // Validasi input perihal agar tidak kosong
    $('#perihal').on('input', function() {
        var inputPerihal = $(this).val();
        if (inputPerihal.trim() === '') {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text(
                'Perihal tidak boleh kosong.');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });

    // Validasi input detail agar tidak kosong
    $('#detail').on('input', function() {
        var inputDetail = $(this).val();
        if (inputDetail.trim() === '') {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').text(
                'Detail tidak boleh kosong.');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').text('');
        }
    });

    // Submit formulir hanya jika input jumlah, perihal, dan detail valid
    $('form').submit(function() {
        var inputJumlah = $('#jumlah').val();
        var inputPerihal = $('#perihal').val();
        var inputDetail = $('#detail').val();

        var nilaiInputJumlah = parseInt(inputJumlah);

        if (isNaN(nilaiInputJumlah) || nilaiInputJumlah <= 0) {
            $('#jumlah').val('');
            $('#jumlah').addClass('is-invalid');
            $('#jumlah').siblings('.invalid-feedback').text(
                'Jumlah harus diisi dengan angka bulat positif lebih dari 0.'
            );
        } else {
            $('#jumlah').removeClass('is-invalid');
            $('#jumlah').siblings('.invalid-feedback').text('');
        }

        if (inputPerihal.trim() === '') {
            $('#perihal').addClass('is-invalid');
            $('#perihal').siblings('.invalid-feedback').text(
                'Perihal tidak boleh kosong.');
        } else {
            $('#perihal').removeClass('is-invalid');
            $('#perihal').siblings('.invalid-feedback').text('');
        }

        if (inputDetail.trim() === '') {
            $('#detail').addClass('is-invalid');
            $('#detail').siblings('.invalid-feedback').text(
                'Detail tidak boleh kosong.');
        } else {
            $('#detail').removeClass('is-invalid');
            $('#detail').siblings('.invalid-feedback').text('');
        }

        // Mencegah pengiriman formulir jika ada input yang tidak valid
        if (isNaN(nilaiInputJumlah) || nilaiInputJumlah <= 0 || inputPerihal
            .trim() === '' ||
            inputDetail.trim() === '') {
            return false;
        }

        return true; // Mengizinkan pengiriman formulir jika semua input valid
    });

    // Menghilangkan pesan alert setelah 3 detik
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);
});
</script>


<?= $this->endSection(); ?>