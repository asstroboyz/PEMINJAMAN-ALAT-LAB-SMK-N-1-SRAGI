<?=$this->extend('admin/templates/index');?>
<?=$this->section('page-content');?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"></h1>

    <?php if (session()->has('pesanBerhasil')): ?>
    <div class="alert alert-success" role="alert">
        <?=session('pesanBerhasil')?>
    </div>
    <?php endif;?>

    <div class="row">
        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-header">
                    <a href="/admin/permintaan" class="btn ml-n3 text-primary font-weight-bold"><i
                            class="fas fa-chevron-left"></i> Kembali ke daftar permintaan barang</a>
                    <button class="btn btn-primary float-right ml-2" type="button" data-toggle="collapse"
                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <i class="fa fa-eye rounded-cyrcle"></i> Timeline
                    </button>
                    <?php if ($detail->status == 'belum diproses') {?>

                    <a href="/admin/prosesPermintaan/<?=$detail->id?>"
                        class="text-light btn btn-warning font-weight-bold float-right"><i class="fa fa-clipboard"></i>
                        Proses Pengajuan</a>
                    <?php } elseif ($detail->status == 'diproses') {?>
                    <div class="btn-group float-right">
                        <a class="btn btn-warning" href="#" data-toggle="modal" data-target="#modalPengaduan">
                            Selesaikan Pengajuan
                        </a>
                    </div>

                    <?php }
                    ;?>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">Nama Pengaju</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?=$detail->nama_pengaju?>
                        </div>
                    </div>
                    <hr>
                    <div class="row  ">
                        <div class="col-md-3">Status Pengajuan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?=$detail->status?>

                        </div>

                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Tanggal Pengajuan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?=$detail->tanggal_pengajuan?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Perihal</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?=$detail->perihal?>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-3">Perihal</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-8">
                            <?=$detail->detail?>
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
                                                <?=$detail->tanggal_pengajuan?>
                                            </div>
                                            <p>Permintaan Diajukan</p>
                                        </li>
                                        <?php if ($detail->tanggal_diproses != '0000-00-00 00:00:00') {?>
                                        <li class="li-diproses">
                                            <div class="time">
                                                <?=$detail->tanggal_diproses?>
                                            </div>
                                            <p>Permintaan Diproses </p>
                                        </li>
                                        <?php }?>
                                        <?php if ($detail->tanggal_selesai != '0000-00-00 00:00:00') {?>
                                        <li class="li-selesai">
                                            <div class="time">09:30 AM</div>
                                            <p>Permintaan Selesai</p>
                                            <p>
                                                Dengan Status:
                                                <?=$detail->status_akhir?>
                                            </p>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($detail->status_akhir == 'ditolak') {?>
    <div class="row   mt-2 ">
        <div class="col-12">

            <div class="card shadow card-detail">


                <div class="card-body">
                    <div class="mb-3">
                        <div class="btn font-weight-bold display-1  text-dark ml-n3 ">Balasan Permintaan Ditolak </div>



                    </div>

                    <div class="row">
                        <div class="col-md-3">Kategori</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <?=$balasan->kategori?>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-3">balasan</div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <?=$balasan->balasan_permintaan?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php }?>
    <div class="row balasan   mt-2 ">
        <div class="col-12">

            <div class="card shadow card-detail">

                <form
                    action="<?=base_url('/admin/simpanBalasan/' . $detail->id)?> "
                    method="post" enctype="multipart/form-data">
                    <?=csrf_field();?>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="btn font-weight-bold display-1  text-dark ml-n3 ">Balasan Permintaan Ditolak
                            </div>


                            <button class="btn btn-primary float-right ml-2 text-white font-weight-bold"><i
                                    class="fa fa-paper-plane rounded-cyrcle"></i> Kirim Balasan</button>

                            <button class="btn btn-danger float-right" onclick="hideBalasan()"><i
                                    class="fas fa-times-circle"></i> Batal</button>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-2"> <label for="kategori">Kategori </label></div>
                            <div class="col-md-1 d-none d-md-block">:</div>
                            <div class="col-md-5">
                                <input type="text" name="kategori" id="kategori"
                                    class="form-control ml-n5  <?=$validation->hasError('kategori') ? 'is-invalid' : '';?>"
                                    value="<?=old('kategori');?>">
                                <div class="invalid-feedback ml-n5">
                                    <?=$validation->getError('kategori');?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2"> <label for="balasan_permintaan">Jelaskan lebih rinci</label></div>
                            <div class="col-md-1 d-none d-md-block">:</div>
                            <div class="col-md-5">
                                <textarea name="balasan_permintaan" id="isi" cols="30" rows="13"
                                    class="form-control ml-n5  <?=$validation->hasError('balasan_permintaan') ? 'is-invalid' : '';?>"><?=old('balasan_permintaan');?></textarea>
                                <div class="invalid-feedback ml-n5">
                                    <?php dd($validation) ?>
                                    <?=$validation->getError('balasan_permintaan');?>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPengaduan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Status Laporan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Tekan "Terima" jika akan mengubah status laporan menjadi diterima</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-success"
                    href="/admin/terimaPermintaan/<?=$detail->id?>">Terima</a>
            </div>
        </div>
    </div>
</div>
<?=$this->endSection();?>
<?=$this->section('additional-js');?>
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
        $("#kategori").focus();
    }

    function hideBalasan() {
        $(".balasan").hide("slow");
    }
</script>
<?=$this->endSection();?>