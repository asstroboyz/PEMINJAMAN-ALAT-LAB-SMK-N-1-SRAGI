<?= $this->extend('admin/templates/index') ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <?php if (session()->getFlashdata('msg')) : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <div class="alert-body">
                        <button class="close" data-dismiss>x</button>
                        <b><i class="fa fa-check"></i></b>
                        <?= session()->getFlashdata('msg'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card shadow card-detail">
                <div class="card-header">
                    <a href="/admin/detailPengadaan/<?= $detail['id_pengadaan_barang']; ?>" class="btn ml-n3 text-primary font-weight-bold"><i class="fas fa-chevron-left"></i> Kembali ke
                        daftar pengadaan</a>
                    <button class="btn btn-primary float-right ml-2" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa fa-eye rounded-cyrcle"></i> Timeline
                    </button>

                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">Kode Barang</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['id_pengadaan_barang'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">Nama Pengaju</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['nama_pengaju'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">Nama Barang</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['nama_barang'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">Jumlah Barang</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['jumlah'] ?>
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
                            <?= $detail['tgl_pengajuan'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Spesifikasi</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['spesifikasi'] ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Alasan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?= $detail['alasan_pengadaan'] ?>
                        </div>
                    </div>
                    <hr>


                    <div class="accordion" id="accordionExample">
                        <div class="">
                            <div class="" id="headingOne">
                                <h5 class="mb-0">

                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <h1> Tracking Permintaan Barang</h1>
                                    <ul class="sessions">
                                        <li class="li-diajukan">
                                            <div class="time">
                                                <?= $detail['tgl_pengajuan'] ?>
                                            </div>
                                            <p>Permintaan Diajukan</p>
                                        </li>
                                        <?php if ($detail['tgl_proses'] != '0000-00-00 00:00:00') { ?>
                                            <li class="li-diproses">
                                                <div class="time">
                                                    <?= $detail['tgl_proses'] ?>
                                                </div>
                                                <p>Permintaan Diproses </p>
                                            </li>
                                        <?php } ?>
                                        <?php if ($detail['tgl_selesai'] != '0000-00-00 00:00:00') { ?>
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
            <?php if ($detail['status_akhir'] == 'ditolak') : ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card shadow card-detail">
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="btn font-weight-bold display-1 text-dark ml-n3 ">Balasan Permintaan Ditolak
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Kategori</div>
                                    <div class="col-md-1 d-none d-md-block">:</div>
                                    <div class="col-md-8 ml-n5">
                                        <?= $balasan->kategori ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-3">Balasan</div>
                                    <div class="col-md-1 d-none d-md-block">:</div>
                                    <div class="col-md-8 ml-n5">
                                        <?= $balasan->balasan_pengadaan; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="row balasan mt-2">
                    <div class="col-12">
                        <div class="card shadow card-detail">
                            <form action="<?= base_url('/petugas_pengadaan/balasPengadaan/' . $detail['id']) ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="btn font-weight-bold display-1 text-dark ml-n3 ">Balasan Permintaan
                                            Ditolak
                                        </div>
                                        <button class="btn btn-primary float-right ml-2 text-white font-weight-bold"><i class="fa fa-paper-plane rounded-cyrcle"></i> Kirim Balasan</button>
                                        <button class="btn btn-danger float-right" onclick="hideBalasan()"><i class="fas fa-times-circle"></i> Batal</button>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-2"> <label for="kategori">Kategori </label></div>
                                        <div class="col-md-1 d-none d-md-block">:</div>
                                        <div class="col-md-5">
                                            <input type="text" name="kategori" id="kategori" class="form-control ml-n5 <?= $validation->hasError('kategori') ? 'is-invalid' : ''; ?>" value="<?= old('kategori'); ?>">
                                            <div class="invalid-feedback ml-n5">
                                                <?= $validation->getError('kategori'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2"> <label for="balasan_pengadaan">Jelaskan lebih
                                                rinci</label>
                                        </div>
                                        <div class="col-md-1 d-none d-md-block">:</div>
                                        <div class="col-md-5">
                                            <textarea name="balasan_pengadaan" id="isi" cols="30" rows="13" class="form-control ml-n5 <?= $validation->hasError('balasan_pengadaan') ? 'is-invalid' : ''; ?>"><?= old('balasan_pengadaan'); ?></textarea>
                                            <div class="invalid-feedback ml-n5">
                                                <?= $validation->getError('balasan_pengadaan'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Status Laporan</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Tekan "Terima" jika akan mengubah status laporan menjadi diterima
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-success" href="/petugas_pengadaan/accPengadaan/<?= $detail['id'] ?>">Terima</a>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
        </div>



        <?= $this->endSection(); ?>

        <?= $this->section('additional-js'); ?>
        <script>
            window.setTimeout(function() {
                $(".alert")
                    .fadeTo(500, 0)
                    .slideUp(500, function() {
                        $(this).remove();
                    });
            }, 3000);

            $(".balasan").hide();

            function tampilkanBalasan() {
                $(".balasan").show("slow");
                $('html,body').animate({
                    scrollTop: document.body.scrollHeight
                }, "slow");
                document.getElementById("kategori").focus();
            };

            function hideBalasan() {
                $(".balasan").hide("slow");
            };
        </script>
        <?= $this->endSection(); ?>