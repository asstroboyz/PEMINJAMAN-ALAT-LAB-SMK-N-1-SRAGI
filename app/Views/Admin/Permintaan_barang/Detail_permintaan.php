<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Detail Permintaan Barang</h1>




    <?php if (session()->has('pesanBerhasil')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session('pesanBerhasil') ?>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-header">
                    <a href="/Admin/permintaan_masuk" class="btn ml-n3 text-primary font-weight-bold"><i
                            class="fas fa-chevron-left"></i> Kembali ke daftar permintaan </a>
                    <button class="btn btn-primary float-right ml-2" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa fa-eye rounded-cyrcle"></i> Timeline
                    </button>
                    <?php if ($detail['status'] == 'belum diproses') { ?>

                    <a href="/Admin/prosesPermintaan/<?= $detail['id'] ?>"
                        class="text-light btn btn-warning font-weight-bold float-right"><i class="fa fa-clipboard"></i>
                        Proses Permintaan</a>
                    <?php } elseif ($detail['status'] == 'diproses') { ?>
                    <div class="btn-group float-right">
                        <a class="btn btn-success" href="#" data-toggle="modal" data-target="#modalPengaduan"><i
                                class="fa fa-check"></i>
                            Selesaikan Permintaan
                        </a>
                    </div>

                    <?php }; ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">Nama Barang Yang diajukan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['nama_brg'] ?>
                            (<?= $detail['tipe_barang']; ?>)
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">Jumlah Barang Yang diajukan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['jumlah'] ?>
                            <?= $detail['nama_satuan'] ?>
                        </div>
                    </div>

                    <hr>
                    <div class="row  ">
                        <div class="col-md-3">Status Pengajuan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['status'] ?>

                        </div>

                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Tanggal Pengajuan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?php

                            $formattedDate = date('d-m-Y', strtotime($detail['tanggal_pengajuan']));
echo $formattedDate;
?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Perihal</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['perihal'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Detail Permintaan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['detail'] ?>
                        </div>
                    </div>
                    <hr>

                    <div class="accordion" id="accordionExample">
                        <div class="">
                            <div class="" id="headingOne">
                                <h5 class="mb-0">

                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse " aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <h1> Tracking Permintaan Barang</h1>
                                    <ul class="sessions">
                                        <li class="li-diajukan">
                                            <div class="time">
                                                <?= $detail['tanggal_pengajuan'] ?>
                                            </div>
                                            <p>Permintaan Diajukan</p>
                                        </li>
                                        <?php if ($detail['tanggal_diproses'] != '0000-00-00 00:00:00') { ?>
                                        <li class="li-diproses">
                                            <div class="time">
                                                <?= $detail['tanggal_diproses'] ?>
                                            </div>
                                            <p>Permintaan Diproses </p>
                                        </li>
                                        <?php } ?>
                                        <?php if ($detail['tanggal_selesai'] != '0000-00-00 00:00:00') { ?>
                                        <li class="li-selesai">
                                            <div class="time">09:30 AM</div>
                                            <p>Permintaan Selesai</p>
                                            <p>
                                                Dengan Status:
                                                <?= $detail['status_akhir'] ?>
                                            </p>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Status Pengajuan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Tekan "Selesai" jika akan mengubah status pengajuan menjadi selesai</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-success"
                        href="/Admin/terimaPermintaan/<?= $detail['id'] ?>">Selesai</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page-content'); ?>