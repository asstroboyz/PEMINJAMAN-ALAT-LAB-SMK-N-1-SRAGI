<?= $this->extend('User/Templates/Index'); ?>
<?= $this->section('page-content'); ?>
<style>
.header-actions {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
  justify-content: flex-end; /* tombol rata kanan */
  width: 100%;
}

.header-actions .btn-add {
  background-color: #6f42c1;
  border: none;
  color: #fff;
  font-weight: 600;
  transition: all 0.25s ease;
}
.header-actions .btn-add:hover {
  background-color: #5a32a3;
  transform: translateY(-1px);
  box-shadow: 0 2px 6px rgba(111, 66, 193, 0.3);
}

.btn-status-group .btn {
  border: 1.5px solid #ccc;
  color: #555;
  background: #fff;
  transition: all 0.25s ease;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 5px 10px;
}

.btn-status-group .btn i {
  font-size: 13px;
}

.btn-status-group .btn:hover {
  color: #6f42c1;
  border-color: #6f42c1;
  background: #f9f5ff;
  transform: translateY(-1px);
}

/* Warna aktif */
.btn-status-group .btn.active {
  background: #6f42c1 !important;
  border-color: #6f42c1 !important;
  color: #fff !important;
  box-shadow: 0 2px 5px rgba(111, 66, 193, 0.4);
}
</style>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Peminjaman Alat</h1>

    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
            <span class="h5 mb-0">Custom Utilities: Peminjaman Alat</span>
            <div class="d-flex align-items-center">
                <a href="<?= base_url('User/tambahPeminjaman') ?>" class="btn btn-sm btn-primary mr-2">
                    <i class="fa fa-plus"></i> Tambah Peminjaman
                </a>
                <div class="btn-group">
                    <a href="<?= base_url('User/peminjaman?status=all') ?>" class="btn btn-sm <?= $status == 'all' ? 'btn-info' : 'btn-outline-secondary' ?>">Semua</a>
                    <a href="<?= base_url('User/peminjaman?status=diproses') ?>" class="btn btn-sm <?= $status == 'diproses' ? 'btn-info' : 'btn-outline-secondary' ?>">Diproses</a>
                    <a href="<?= base_url('User/peminjaman?status=selesai') ?>" class="btn btn-sm <?= $status == 'selesai' ? 'btn-info' : 'btn-outline-secondary' ?>">Selesai</a>
                    <a href="<?= base_url('User/peminjaman?status=rejected') ?>" class="btn btn-sm <?= $status == 'rejected' ? 'btn-info' : 'btn-outline-secondary' ?>">Rejected</a>
                </div>
            </div>
        </div> -->
           <div class="card-header py-3">
            <div class="header-actions">
                <a href="<?= base_url('User/tambahPeminjaman') ?>" class="btn btn-sm btn-add me-2">
                    <i class="fa fa-plus"></i> Tambah Peminjaman
                </a>

                <div class="btn-group btn-status-group flex-wrap">
                    <a href="<?= base_url('User/peminjaman?status=all') ?>"
                        class="btn btn-sm <?= $status == 'all' ? 'active' : '' ?>">
                        <i class="fas fa-list"></i> Semua
                    </a>

                    <a href="<?= base_url('User/peminjaman?status=pengajuan') ?>"
                        class="btn btn-sm <?= $status == 'pengajuan' ? 'active' : '' ?>">
                        <i class="fas fa-spinner"></i> Pengajuan
                    </a>

                    <a href="<?= base_url('User/peminjaman?status=dipinjam') ?>"
                        class="btn btn-sm <?= $status == 'dipinjam' ? 'active' : '' ?>">
                        <i class="fas fa-box-open"></i> Dipinjam
                    </a>

                    <a href="<?= base_url('User/peminjaman?status=menunggu_kembali') ?>"
                        class="btn btn-sm <?= $status == 'menunggu_kembali' ? 'active' : '' ?>">
                        <i class="fas fa-undo-alt"></i> Menunggu
                    </a>

                    <a href="<?= base_url('User/peminjaman?status=dikembalikan') ?>"
                        class="btn btn-sm <?= $status == 'dikembalikan' ? 'active' : '' ?>">
                        <i class="fas fa-check-double"></i> Dikembalikan
                    </a>

                    <a href="<?= base_url('User/peminjaman?status=rejected') ?>"
                        class="btn btn-sm <?= $status == 'rejected' ? 'active' : '' ?>">
                        <i class="fas fa-ban"></i> Ditolak
                    </a>
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
                            <th style="width:13%;">Akan Di Gunakan di</th>
                            <th style="width:10%;">Status</th>
                            <th style="width:10%;">Catatan</th>
                            <th style="width:24%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($peminjamans): ?>
                            <?php foreach ($peminjamans as $i => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td>
                                        <span class="font-monospace"><?= $row['kode_transaksi'] ?></span>
                                    </td>
                                    <td><?= $row['peminjam'] ?? '-' ?></td>
                                    <td><?= $row['lokasi_pinjam'] ?? '-' ?></td>
                                    <td>
    <?php
        $status   = $row['status'];
        $mapColor = [
            'pengajuan'        => 'badge-warning',
            'dipinjam'         => 'badge-info',
            'menunggu_kembali' => 'badge-primary',
            'dikembalikan'     => 'badge-success',
            'rejected'         => 'badge-danger',
        ];

        // default warna kalau tidak ada di map
        $badgeClass = $mapColor[$status] ?? 'badge-secondary';

        // ubah underscore jadi spasi + kapital awal
        $statusText = ucwords(str_replace('_', ' ', $status));
    ?>
    <span class="badge badge-pill <?php echo $badgeClass?>">
        <?php echo $statusText?>
    </span>
</td>
                                    <td><?= $row['catatan'] ?? '-' ?></td>
                                 <td>
  <a href="<?= base_url('User/detailPeminjaman/' . $row['peminjaman_id']) ?>"
     class="btn btn-outline-primary btn-sm">
    <i class="fa fa-list"></i> Detail
  </a>
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
                * User dapat membuat peminjaman baru secara manual jika diperlukan.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
    $(function() {
        setTimeout(() => $('.alert').fadeOut(500), 3000);
    });
</script>
<?= $this->endSection(); ?>