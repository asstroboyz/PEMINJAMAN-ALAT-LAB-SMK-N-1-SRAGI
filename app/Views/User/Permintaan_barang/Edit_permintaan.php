<!-- View: app/Views/Pegawai/Permintaan_barang/Edit_permintaan.php -->
<?= $this->extend('Pegawai/Templates/Index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Form Edit Barang</h1>

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
                    <a href="/Pegawai/list_permintaan/<?= $permintaan['id_permintaan_barang'] ?>">&laquo; Kembali ke
                        daftar permintaan barang</a>
                </div>
                <div class="card-body">
                    <?php if (isset($validation) && $validation->hasError('perihal', 'jumlah', 'detail')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                                <li><?= $validation->getError('perihal') ?>
                                </li>
                                <li><?= $validation->getError('jumlah') ?>
                                </li>
                                <li><?= $validation->getError('detail') ?>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('/Pegawai/updatePermin/' . $permintaan['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kode_barang">Pilih Barang</label>
                                    <select name="kode_barang" id="kode_barang" class="form-control" required>
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($barangList as $brg) : ?>
                                            <option value="<?= $brg['kode_barang'] ?>" data-satuan="<?= $brg['nama_satuan'] ?>" <?= ($brg['kode_barang'] == $permintaan['kode_barang']) ? 'selected' : ''; ?>>
                                                <?= $brg['nama_brg'] ?>
                                                (<?= $brg['tipe_barang'] ?>)
                                            </option>
                                        <?php endforeach; ?>


                                    </select>
                                </div>
                                <input type="hidden" name="id_permintaan_barang" id="" value="<?= $permintaan['id_permintaan_barang'] ?>">
                                <p>Satuan: <span id="satuan_barang"></span></p>


                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" name="perihal" id="perihal" class="form-control <?= $validation->hasError('perihal') ? 'is-invalid' : ''; ?>" value="<?= old('perihal') ?? $permintaan['perihal'] ?? ''; ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('perihal'); ?>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control <?= $validation->hasError('jumlah') ? 'is-invalid' : ''; ?>" value="<?= old('jumlah') ?? $permintaan['jumlah'] ?? '' ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="detail">Jelaskan lebih rinci</label>
                                    <textarea name="detail" id="detail" cols="30" rows="13" class="form-control <?= $validation->hasError('detail') ? 'is-invalid' : ''; ?>"><?= $permintaan['detail'] ?? ''; ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('detail'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">Update Data</button>
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

            // Memastikan nilaiInput adalah angka bulat positif
            if (isNaN(nilaiInput) || nilaiInput <= 0) {
                $(this).val('');
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').text(
                    'Jumlah harus diisi dengan angka bulat positif.');
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
                $(this).siblings('.invalid-feedback').text('Perihal tidak boleh kosong.');
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
                $(this).siblings('.invalid-feedback').text('Detail tidak boleh kosong.');
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
                    'Jumlah harus diisi dengan angka lebih dari 0.');
            } else {
                $('#jumlah').removeClass('is-invalid');
                $('#jumlah').siblings('.invalid-feedback').text('');
            }

            if (inputPerihal.trim() === '') {
                $('#perihal').addClass('is-invalid');
                $('#perihal').siblings('.invalid-feedback').text('Perihal tidak boleh kosong.');
            } else {
                $('#perihal').removeClass('is-invalid');
                $('#perihal').siblings('.invalid-feedback').text('');
            }

            if (inputDetail.trim() === '') {
                $('#detail').addClass('is-invalid');
                $('#detail').siblings('.invalid-feedback').text('Detail tidak boleh kosong.');
            } else {
                $('#detail').removeClass('is-invalid');
                $('#detail').siblings('.invalid-feedback').text('');
            }

            // Mencegah pengiriman formulir jika ada input yang tidak valid
            if (isNaN(nilaiInputJumlah) || nilaiInputJumlah <= 0 || inputPerihal.trim() === '' ||
                inputDetail.trim() === '') {
                return false;
            }

            return true; // Mengizinkan pengiriman formulir jika semua input valid
        });
    });
</script>
<?= $this->endSection(); ?>