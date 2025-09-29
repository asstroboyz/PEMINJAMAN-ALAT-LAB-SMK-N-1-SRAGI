<?= $this->extend('User/Templates/Index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Peminjaman Alat</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap">
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