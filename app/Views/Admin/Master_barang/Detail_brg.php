<?php echo $this->extend('Admin/Templates/Index') ?>

<?php echo $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Detail Barang Inventaris</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow p-3">
                <div class="row col-lg-12 mx-2">
                    <div class="col-lg-4">
                        <label for="nama_barang">Kode Barang</label>
                        <input name="nama_barang" type="text" class="form-control form-control-user"
                            id="input-nama_barang"
                            value="<?php echo $master_brg['kode_brg']; ?>"
                            readonly />
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input name="nama_barang" type="text" class="form-control form-control-user"
                                id="input-nama_barang"
                                value="<?php echo $master_brg['nama_brg']; ?>"
                                readonly />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="nama_barang">Merk Barang</label>
                            <input name="nama_barang" type="text" class="form-control form-control-user"
                                id="input-nama_barang"
                                value="<?php echo $master_brg['merk']; ?>"
                                readonly />
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label for="jenis_brg">Jenis Barang</label>
                      <input name="jenis_brg" type="text" class="form-control form-control-user"
       id="input-jenis_brg"
       value="<?php
                  echo($master_brg['jenis_brg'] == 'sfw') ? 'Software' :
                  (($master_brg['jenis_brg'] == 'hrd') ? 'Hardware' :
                  (($master_brg['jenis_brg'] == 'tools') ? 'Tools' : '-'));
              ?>"
       readonly />

                    </div>

                </div>
              <div class="row col-lg-12 mx-2 table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
             
            </tr>
        </thead>
        <tbody>
            <?php if ($inventaris): ?>
<?php $jumlah_awal = 0;
$jumlah_tersedia   = 0; ?>
<?php foreach ($inventaris as $num => $inv): ?>

                    <tr>
                        <td><?php echo $num + 1; ?></td>
                        <td><?php echo $inv['lokasi']; ?></td>
                        <td><?php echo $inv['kondisi']; ?></td>
                
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: center;">Total</td>
                    <td class="text-center"><?php echo $jumlah_awal; ?></td>
                    <td class="text-center"><?php echo $jumlah_tersedia; ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Data tidak ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

                <br>
                <a href="/Admin/master_barang" class="btn btn-secondary">&laquo; Kembali ke daftar barang
                </a>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection('page-content'); ?>