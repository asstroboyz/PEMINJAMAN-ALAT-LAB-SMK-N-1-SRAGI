<?=$this->extend('Admin/Templates/Index');?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Kurang Sok Barang</h1>

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
                        action="<?= base_url('/Admin/kurangiStok/' . $kodeBarang) ?>"
                        method="post">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_barang_kurang">Kode Barang</label>
                                    <input name="kode_barang_kurang" type="text" class="form-control"
                                        id="kode_barang_kurang"
                                        value="<?= $kodeBarang; ?>"
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
                                    <label for="tanggal_barang_keluar">Tanggal Barang Keluar</label>
                                    <input name="tanggal_barang_keluar" type="date" class="form-control"
                                        id="tanggal_barang_keluar" required />
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pengurangan_stok">Jumlah Pengurangan Stok</label>
                                    <input name="jumlah_pengurangan_stok" type="number" class="form-control"
                                        id="jumlah_pengurangan_stok" placeholder="Jumlah Pengurangan Stok" />
                                </div>
                            </div>

                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-block">Kurangi Stok</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="modal" tabindex="-1" role="dialog" id="alertModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Peringatan!!!</h5>

            </div>
            <div class="modal-body">
                <p id="modalContent"></p>
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
        });
    }, 3000);
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Ambil elemen-elemen yang dibutuhkan
    //     var jumlahPenguranganStok = document.getElementById('jumlah_pengurangan_stok');
    //     var stokTersedia = parseInt(document.getElementById('stok').value);

    //     // Tambahkan event listener untuk meng-handle perubahan pada input jumlah pengurangan stok
    //     jumlahPenguranganStok.addEventListener('input', function() {
    //         // Ambil nilai dari input jumlah pengurangan stok
    //         var jumlahInput = parseInt(jumlahPenguranganStok.value);

    //         // Validasi agar jumlahInput tidak lebih sedikit atau minus dari stok yang tersedia
    //         if (isNaN(jumlahInput) || jumlahInput < 0) {
    //             alert('Jumlah pengurangan stok tidak valid.');
    //             jumlahPenguranganStok.value = ''; // Reset nilai input jika tidak valid
    //         } else if (jumlahInput > stokTersedia) {
    //             alert('Jumlah pengurangan stok tidak boleh melebihi stok yang tersedia.');
    //             jumlahPenguranganStok.value =
    //             stokTersedia; // Set nilai input menjadi stok yang tersedia
    //         }
    //     });
    // });
    document.addEventListener('DOMContentLoaded', function() {
        var jumlahPenguranganStok = document.getElementById('jumlah_pengurangan_stok');
        var stokTersedia = parseInt(document.getElementById('stok').value);
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        jumlahPenguranganStok.addEventListener('input', function() {
            var jumlahInput = parseInt(jumlahPenguranganStok.value);

            if (isNaN(jumlahInput) || jumlahInput < 0) {
                showAlertModal('Jumlah pengurangan stok tidak valid.');
                jumlahPenguranganStok.value = '';
            } else if (jumlahInput > stokTersedia) {
                showAlertModal('Jumlah pengurangan stok tidak boleh melebihi stok yang tersedia.');
                jumlahPenguranganStok.value = stokTersedia;
            }
        });

        function showAlertModal(message) {
            var modalContent = document.getElementById('modalContent');
            modalContent.innerText = message;

            alertModal.show();

            // Menutup modal otomatis setelah 2 detik
            setTimeout(function() {
                alertModal.hide();
            }, 4000);
        }
    });
</script>
<?= $this->endSection(); ?>