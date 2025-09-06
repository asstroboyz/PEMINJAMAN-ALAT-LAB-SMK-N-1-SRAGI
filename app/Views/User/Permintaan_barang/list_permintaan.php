<?= $this->extend('Pegawai/Templates/Index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Detail Permintaan Barang </h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow p-3">
                <div class="row col-lg-12 mx-2">
                    <div class="col-lg-6">
                        <label for="kode_permintaan">Kode Permintaan</label>
                        <input name="kode_permintaan" type="text" class="form-control form-control-user"
                            id="input-kode_permintaan"
                            value="<?= $detail['permintaan_barang_id']; ?>"
                            readonly />
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tanggal_permintaan">Tanggal Permintaan</label>
                            <input name="tanggal_permintaan" type="text" class="form-control form-control-user"
                                id="input-tanggal_permintaan"
                                value="<?= $detail['tanggal_permintaan']; ?>"
                                readonly />
                        </div>
                    </div>


                </div>
                <div class="row col-lg-12 mx-2 table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Perihal</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>opsi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if ($permintaan) { ?>
                            <?php foreach ($permintaan as $num => $data) { ?>


                            <tr>
                                <td style="width: 70px;">
                                    <?= $num + 1; ?>
                                </td>

                                <td>
                                    <?= $data['nama_brg']; ?>(<?= $data['tipe_barang']; ?>)
                                </td>
                                <td
                                    style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: normal;">
                                    <?= $data['perihal']; ?>
                                </td>


                                <td style=" width: 120px;">
                                    <?= $data['jumlah']; ?>
                                </td>


                                <td style=" width: 120px;">
                                    <?php $date = date_create($data['tanggal_pengajuan']); ?>
                                    <?= date_format($date, "d-m-Y"); ?>
                                </td>
                                <td style="text-align:center; width: 120px;">
                                    <span
                                        class="btn <?= $data['status'] == 'belum diproses' ? 'btn-danger' : ($data['status'] == 'diproses' ? 'btn-warning' : 'btn-success') ?> text-white">
                                        <?= $data['status']; ?>
                                    </span>
                                </td>

                                <td style="text-align:center; width: 150px;">
                                    <!-- <div class="dropdown show">
                                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </a> -->

                                    <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuLink"> -->
                                    <a href="/Pegawai/detailpermin/<?= $data['id'] ?>"
                                        class="  btn btn-primary"><i class="fas fa-eye"></i></a>




                                    <?php if ($data['status'] == 'belum diproses') { ?>


                                    <a href="/Pegawai/ubah/<?= $data['id'] ?>"
                                        class=" btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <!-- <a href="/Pegawai/delete/<?= $data['id'] ?>"
                                    class=" btn btn-danger"><i class="fas fa-trash"></i></a> -->
                                    <!-- <a href="/Pegawai/delete/<?= $data['id'] ?>"
                                    class="btn btn-danger delete-btn"
                                    data-toggle="modal" data-target="#deleteConfirmationModal">
                                    <i class="fas fa-trash"></i>
                                    </a> -->
                                    <?php } else { ?>


                                    <button class="  btn btn-secondary"><i class="fa fa-edit"></i> </button>
                                    <button class="  btn btn-secondary"><i class="fa fa-trash"></i> </button>
                                    <?php } ?>

                                    <!-- </div> -->
                                    <!-- </div> -->

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
                <br>
                <a href="<?= base_url('Pegawai/Permintaan'); ?>"
                    class="btn btn-secondary">&laquo; Kembali ke
                    daftar permintaan
                    barang
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>