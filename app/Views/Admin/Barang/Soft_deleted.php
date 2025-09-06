<?=$this->extend('Admin/Templates/Index');?>

<?=$this->section('page-content');?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"></h1>

    <?php if (session()->getFlashdata('error-msg')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <?=session()->getFlashdata('error-msg');?>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible show fade" role="alert">

                <div class="alert-body">
                    <button class="close" data-dismiss>x</button>
                    <b><i class="fa fa-check"></i></b>
                    <?=session()->getFlashdata('msg');?>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>

    <div class="row">
        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h3>Daftar Arsip Barang </h3>
                    <a href="/Admin/atk" class="btn btn-secondary">&laquo; Kembali ke daftar barang
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 35%;">Nama Barang</th>
                                    <th style="width: 15%;">Stok</th>
                                    <th style="width: 10%;">Satuan</th>
                                    <th style="width: 15%;">Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 35%;">Nama Barang</th>
                                    <th style="width: 15%;">Stok</th>
                                    <th style="width: 10%;">Satuan</th>
                                    <th style="width: 15%;">Opsi</th>
                                </tr>
                            </tfoot>

                            <tbody>

                                <?php if ($barangs) {?>
                                <?php foreach ($barangs as $num => $data) {?>


                                <tr>
                                    <td><?=$num + 1;?></td>
                                    <td><?=$data['nama_brg'];?>

                                        <?php if ($data['stok'] < 10): ?>
                                    <td>
                                        <span
                                            class="btn btn-danger text-white d-flex justify-content-center align-items-center">
                                            <?=$data['stok'];?>
                                        </span>
                                    </td>
                                    <?php else: ?>
                                    <td>
                                        <?=$data['stok'];?>
                                    </td>
                                    <?php endif;?>
                                    </td>
                                    <td><?=$data['nama_satuan'];?>
                                    </td>
                                    <td>



                                        <a href="<?=base_url("/Admin/restore/{$data['kode_barang']}")?>"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-undo"></i> Restore
                                        </a>


                                </tr>
                                <?php }?>
                                <!-- end of foreach                -->
                                <?php } else {?>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="text-gray-900 text-center">Data Tidak ada.</h3>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?=$this->endSection();?>
<?=$this->section('additional-js');?>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $($this).remove();
        })

    }, 3000);
</script>
<?=$this->endSection();?>