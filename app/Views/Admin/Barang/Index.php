<?= $this->extend('Admin/Templates/Index'); ?>

<?= $this->section('page-content'); ?>
<?php

use App\Models\TransaksiBarangModel;

$transaksiModel = new TransaksiBarangModel();
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"></h1>

    <?php if (session()->getFlashdata('error-msg')) : ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('error-msg'); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg')) : ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible show fade" role="alert">

                <div class="alert-body">
                    <button class="close" data-dismiss>x</button>
                    <b><i class="fa fa-check"></i></b>
                    <?= session()->getFlashdata('msg'); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3>Daftar Barang </h3>
                    <a href="tambahForm" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Barang
                    </a>

                    <a href="<?php echo base_url('Admin/atk_trash/'); ?>" class="btn btn-success">
                        <i class="fa fa-archive"></i> Arsip Barang
                    </a>

                    <a href="<?php echo base_url('Admin/lap_barang/'); ?>" class="btn btn-success">
                        <i class="fa fa-print"></i> Cetak
                    </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 15%;">No</th>
                                    <th style="width: 25%;">Nama Barang</th>
                                    <th style="width: 10%;">Stok</th>
                                    <th style="width: 10%;">Satuan</th>
                                    <th style="width: 25%;">Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 15%;">No</th>
                                    <th style="width: 25%;">Nama Barang</th>
                                    <th style="width: 10%;">Stok</th>
                                    <th style="width: 10%;">Satuan</th>
                                    <th style="width: 25%;">Opsi</th>
                                </tr>
                            </tfoot>

                            <tbody>

                                <?php if ($barangs) { ?>
                                <?php foreach ($barangs as $num => $data) {
                                        $transaksiKeluar = $transaksiModel->where('kode_barang', $data['kode_barang'])
                                            ->where('jenis_transaksi', 'keluar')
                                            ->first();
                                    ?>


                                <tr>
                                    <td><?= $num + 1; ?></td>
                                    <td><?= $data['nama_brg']; ?>(<?= $data['merk']; ?>)

                                        <?php if ($data['stok'] < 10) : ?>
                                    <td>
                                        <span
                                            class="btn btn-danger text-white d-flex justify-content-center align-items-center">
                                            <?= $data['stok']; ?>
                                        </span>
                                    </td>
                                    <?php else : ?>
                                    <td>
                                        <?= $data['stok']; ?>
                                    </td>
                                    <?php endif; ?>
                                    </td>
                                    <td><?= $data['nama_satuan']; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url("/Admin/formTambahStok/{$data['kode_barang']}") ?>"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-plus"></i> Tambah Stok
                                        </a>
                                        <a href="/Admin/formKurangStok/<?= $data['kode_barang'] ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fa fa-minus"></i> Kurang Stok
                                        </a>
                                        <!-- <a href="<?= base_url("/Admin/softDelete/{$data['kode_barang']}") ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fa fa-trash"></i> Hapus Barang
                                        </a> -->
                                        <?php
                                            if (!$transaksiKeluar) : ?>
                                        <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalKonfirmasiDelete"
                                            data-kodebarang="<?= $data['kode_barang'] ?>">
                                            <i class="fa fa-trash"></i> Hapus Barang
                                        </a>

                                        <?php
                                            endif;
                                            ?>

                                        <!-- <a href="#" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalKonfirmasiDelete"
                                            data-kodebarang="<?= $data['kode_barang'] ?>">
                                        <i class="fa fa-trash"></i> Hapus Barang
                                        </a> -->

                                    </td>


                                </tr>
                                <?php } ?>
                                <!-- end of foreach                -->
                                <?php } else { ?>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="text-gray-900 text-center">Data belum ada.</h3>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="modal fade" id="modalKonfirmasiDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus barang ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $($this).remove();
    })

}, 3000);
$('#modalKonfirmasiDelete').on('show.bs.modal', function(e) {
    var kodeBarang = $(e.relatedTarget).data('kodebarang');
    $('#deleteLink').attr('href',
        '<?= base_url("/Admin/softDelete/") ?>' +
        '/' + kodeBarang);
});
</script>
<?= $this->endSection(); ?>