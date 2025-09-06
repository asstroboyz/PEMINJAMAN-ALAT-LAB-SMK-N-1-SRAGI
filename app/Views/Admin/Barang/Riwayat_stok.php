<?=$this->extend('Admin/Templates/Index');?>

<?= $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Riwayat Stok Barang</h1>

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
                <div class="card-body">
                    <h5 class="card-title">Detail Barang</h5>
                    <ul>
                        <li><strong>Kode Barang:</strong> <?= $barang['kode_barang']; ?></li>
                        <li><strong>Nama Barang:</strong> <?= $barang['nama_barang']; ?></li>
                        <li><strong>Jenis Barang:</strong> <?= $barang['jenis_barang']; ?></li>
                        <li><strong>Stok Saat Ini:</strong> <?= $barang['stok']; ?></li>
                    </ul>
                </div>
            </div>

            <div class="card mt-4 shadow">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Stok</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah Penambahan</th>
                                <th>Jumlah Pengurangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($riwayatStok as $riwayat) : ?>
                                <tr>
                                    <td><?= $riwayat['tanggal']; ?></td>
                                    <td><?= $riwayat['jumlah_penambahan']; ?></td>
                                    <td><?= $riwayat['jumlah_pengurangan']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>