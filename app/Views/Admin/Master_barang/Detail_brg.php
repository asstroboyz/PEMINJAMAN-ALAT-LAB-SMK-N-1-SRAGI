<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800">Detail Barang Inventaris</h1>

  <div class="card shadow p-4 mb-4">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Kode Barang</label>
        <input type="text" class="form-control" value="<?= esc($master_brg['kode_brg']); ?>" readonly>
      </div>
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Nama Barang</label>
        <input type="text" class="form-control" value="<?= esc($master_brg['nama_brg']); ?>" readonly>
      </div>
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Kategori</label>
        <input type="text" class="form-control" value="<?= $master_brg['nama_kategori'] ?: '-'; ?>" readonly>
      </div>
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Jenis Barang</label>
        <input type="text" class="form-control"
          value="<?php
            echo ($master_brg['jenis_brg'] == 'sfw') ? 'Software' :
                 (($master_brg['jenis_brg'] == 'hrd') ? 'Hardware' :
                 (($master_brg['jenis_brg'] == 'tools') ? 'Tools' : '-'));
          ?>"
          readonly>
      </div>
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Tipe / Serie</label>
        <input type="text" class="form-control" value="<?= $master_brg['tipe_serie'] ?: '-'; ?>" readonly>
      </div>
      <div class="col-md-4 mb-3">
        <label class="font-weight-bold">Status</label>
        <input type="text" class="form-control"
          value="<?= ($master_brg['is_active'] == '1') ? 'Aktif' : 'Tidak Aktif'; ?>" readonly>
      </div>
    </div>
  </div>

  <div class="card shadow p-4">
    <h5 class="font-weight-bold text-primary mb-3">Daftar Inventaris per Ruangan</h5>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="bg-gradient-primary text-white text-center">
          <tr>
            <th>No</th>
            <th>Kode Inventaris</th>
            <th>Kondisi</th>
            <th>Ruangan</th>
            <th>Status</th>
            <th>QR Code</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($inventaris && count($inventaris) > 0): ?>
            <?php foreach ($inventaris as $index => $inv): ?>
              <tr class="text-center">
                <td><?= $index + 1; ?></td>
                <td><?= esc($inv['kode_barang']); ?></td>
                <td><?= ucfirst($inv['kondisi']); ?></td>
                <td><?= $inv['nama_ruangan'] ?: '-'; ?></td>
                <td>
                  <?php if ($inv['status'] == 'tersedia'): ?>
                    <span class="badge badge-success px-3 py-2">Tersedia</span>
                  <?php else: ?>
                    <span class="badge badge-secondary px-3 py-2">Dipinjam</span>
                  <?php endif; ?>
                </td>
                <td><?= $inv['qrcode'] ?: '-'; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada data inventaris untuk barang ini</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-right mt-3">
      <a href="<?= base_url('/Admin/master_barang'); ?>" class="btn btn-secondary">
        &laquo; Kembali ke Daftar Barang
      </a>
    </div>
  </div>
</div>

<?= $this->endSection('page-content'); ?>
