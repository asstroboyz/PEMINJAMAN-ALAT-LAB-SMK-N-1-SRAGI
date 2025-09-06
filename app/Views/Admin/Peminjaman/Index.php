<?= $this->extend('Admin/Templates/Index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Peminjaman Alat</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
            <span class="h5 mb-0">Custom Utilities: Peminjaman Alat</span>
            <div class="d-flex align-items-center">
                <a href="<?= base_url('admin/tambahPeminjaman') ?>" class="btn btn-sm btn-primary mr-2">
                    <i class="fa fa-plus"></i> Tambah Peminjaman
                </a>
                <div class="btn-group">
                    <a href="<?= base_url('admin/peminjaman?status=all') ?>" class="btn btn-sm <?= $status=='all'?'btn-info':'btn-outline-secondary' ?>">Semua</a>
                    <a href="<?= base_url('admin/peminjaman?status=diproses') ?>" class="btn btn-sm <?= $status=='diproses'?'btn-info':'btn-outline-secondary' ?>">Diproses</a>
                    <a href="<?= base_url('admin/peminjaman?status=selesai') ?>" class="btn btn-sm <?= $status=='selesai'?'btn-info':'btn-outline-secondary' ?>">Selesai</a>
                    <a href="<?= base_url('admin/peminjaman?status=rejected') ?>" class="btn btn-sm <?= $status=='rejected'?'btn-info':'btn-outline-secondary' ?>">Rejected</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height: 70vh; overflow: auto;">
                <table class="table table-striped table-hover align-middle small">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width:3%;">No</th>
                            <th style="width:13%;">Kode Transaksi</th>
                            <th style="width:15%;">Peminjam</th>
                            <th style="width:13%;">Tanggal Pinjam</th>
                            <th style="width:13%;">Lokasi Pinjam</th>
                            <th style="width:10%;">Status</th>
                            <th style="width:10%;">Catatan</th>
                            <th style="width:24%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if($peminjamans): ?>
                        <?php foreach($peminjamans as $i => $row): ?>
                            <tr>
                                <td class="text-center"><?= $i+1 ?></td>
                                <td>
                                    <span class="font-monospace"><?= $row['kode_transaksi'] ?></span>
                                </td>
                                <td><?= $row['peminjam'] ?? '-' ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal_pinjam'] ?? $row['tanggal_permintaan'])) ?></td>
                                <td><?= $row['lokasi_pinjam'] ?? '-' ?></td>
                                <td>
                                    <span class="badge badge-pill
                                        <?= $row['status']=='diproses' ? 'badge-info'
                                        : ($row['status']=='selesai' ? 'badge-success'
                                        : ($row['status']=='rejected' ? 'badge-danger'
                                        : 'badge-secondary')) ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                                <td><?= $row['catatan'] ?? '-' ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/detailPeminjaman/'.$row['peminjaman_id']) ?>"
                                            class="btn btn-outline-primary">
                                            <i class="fa fa-list"></i> Detail
                                        </a>
                                        <?php if($row['status']=='diproses'): ?>
                                            <a href="<?= base_url('admin/approvePeminjaman/'.$row['peminjaman_id']) ?>"
                                                class="btn btn-success">
                                                <i class="fa fa-check"></i> Approve
                                            </a>
                                            <a href="<?= base_url('admin/rejectPeminjaman/'.$row['peminjaman_id']) ?>"
                                                class="btn btn-danger">
                                                <i class="fa fa-times"></i> Reject
                                            </a>
                                        <?php elseif($row['status']=='selesai'): ?>
                                            <span class="text-success"><i class="fa fa-check-circle"></i> Selesai</span>
                                        <?php elseif($row['status']=='rejected'): ?>
                                            <span class="text-danger"><i class="fa fa-times-circle"></i> Ditolak</span>
                                        <?php else: ?>
                                            <span class="text-secondary">-</span>
                                        <?php endif ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <img src="<?= base_url('assets/img/empty-state.svg') ?>" alt="" height="80" class="mb-2 d-block mx-auto opacity-50" />
                                <div>Data peminjaman tidak ditemukan.<br>
                                <small>Silakan klik <b>Tambah Peminjaman</b> untuk membuat transaksi baru.</small>
                                </div>
                            </td>
                        </tr>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="small text-muted mt-2">
                * Gunakan tombol filter status di kanan atas untuk menampilkan daftar sesuai status peminjaman.<br>
                * Admin dapat membuat peminjaman baru secara manual jika diperlukan.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
$(function(){
    setTimeout(() => $('.alert').fadeOut(500), 3000);
});
</script>
<?= $this->endSection(); ?>
