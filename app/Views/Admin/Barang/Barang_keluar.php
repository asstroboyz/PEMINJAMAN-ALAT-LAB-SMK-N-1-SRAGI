<?= $this->extend('Admin/Templates/Index'); ?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h1 class="h3 mb-4 text-gray-900"><?= $title; ?>
                    </h1>
                    <a href="<?php echo base_url('Admin/lap_keluar/'); ?>" class="btn btn-success" target="blank"><i
                            class="fa fa-print"></i> Cetak </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>

                                    <th>Nama Barang</th>
                                    <th>Merk Barang</th>
                                    <th>Satuan Barang</th>
                                    <th>Tanggal Barang Keluar</th>
                                    <th>Jumlah Pengurangan</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($transaksi_barang as $transaksi) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>

                                    <td><?= $transaksi['nama_brg']; ?>
                                    <td><?= $transaksi['merk']; ?>
                                    </td>
                                    <td><?= $transaksi['nama_satuan']; ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($transaksi['tanggal_barang_keluar'])); ?>
                                    </td>


                                    <td><?= $transaksi['jumlah_perubahan']; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?= $this->endSection(); ?>