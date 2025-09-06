<?= $this->extend('Admin/Templates/Index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Histori Transaksi Barang</h1>
    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('msg'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
            <h3 class="mb-0">Daftar Mutasi Transaksi Barang</h3>
            <div>
                <a href="<?= base_url('Admin/transaksiBarang') ?>" class="btn btn-sm btn-info mr-2"><i class="fa fa-refresh"></i> Refresh</a>
                <a href="<?= base_url('Admin/exportTransaksiBarang') ?>" class="btn btn-sm btn-success"><i class="fa fa-file-excel"></i> Export Excel</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height:65vh; overflow:auto;">
                <table class="table table-hover table-bordered align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>SN / Merk</th>
                            <th>Qty</th>
                            <th>User</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($transaksis): ?>
                          <?php foreach ($transaksis as $i => $trx): ?>
                            <tr<?= $trx['jenis_transaksi']=='rusak' ? ' class="table-warning"' : '' ?>>
                                <td class="text-center"><?= $i+1 ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($trx['tanggal_transaksi'])) ?></td>
                                <td>
                                    <span class="badge badge-pill
                                        <?= $trx['jenis_transaksi']=='masuk' ? 'badge-success'
                                            : ($trx['jenis_transaksi']=='keluar' ? 'badge-danger'
                                            : ($trx['jenis_transaksi']=='pinjam' ? 'badge-info'
                                            : ($trx['jenis_transaksi']=='kembali' ? 'badge-primary' : 'badge-secondary'))) ?>
                                    ">
                                        <?= ucfirst($trx['jenis_transaksi']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span data-toggle="tooltip" title="Lokasi: <?= $trx['lokasi'] ?? '-' ?>">
                                        <?= $trx['kode_barang'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span data-toggle="tooltip" title="Spesifikasi: <?= htmlspecialchars($trx['spek_master'] ?? ($trx['spek_real'] ?? '-')) ?>">
                                        <?= $trx['nama_brg'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span data-toggle="tooltip" title="Merk: <?= $trx['merk'] ?? '-' ?>">
                                        <?= $trx['sn'] ?? $trx['merk'] ?? '-' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="font-weight-bold <?= $trx['jenis_transaksi']=='keluar'?'text-danger':'text-success' ?>">
                                        <?= $trx['jumlah_perubahan'] ?>
                                    </span>
                                </td>
                                <td><?= $trx['user_name'] ?? '-' ?></td>
                                <td><?= $trx['informasi_tambahan'] ?></td>
                            </tr>
                          <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">Data transaksi tidak ditemukan.</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="text-muted small mt-2">* Hover/click nama/kode barang untuk info spesifikasi/lokasi</div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('additional-js'); ?>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    // Optional: Auto-fade flash messages
    setTimeout(() => $('.alert').fadeOut(500), 3500);
});
</script>
<?= $this->endSection(); ?>
