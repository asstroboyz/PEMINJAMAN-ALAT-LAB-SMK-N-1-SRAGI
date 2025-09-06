<?=$this->extend('Pegawai/Templates/Index');?>

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
                <div class="card-header py-3">
                    <h3>Daftar Permintaan Barang </h3>
                    <a href="/Pegawai/tambah_permintaan" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah
                        Permintaan</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>



                                    <th>Perihal</th>
                                    <th>Jumlah</th>

                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>No</th>


                                    <th>Perihal</th>
                                    <th>Jumlah</th>

                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php if ($permintaan) {?>
                                <?php foreach ($permintaan as $num => $data) {?>


                                <tr>
                                    <td style="width: 70px;">
                                        <?=$num + 1;?>
                                    </td>


                                    <td
                                        style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: normal;">
                                        <?=$data['perihal'];?>
                                    </td>


                                    <td style=" width: 120px;">
                                        <?=$data['jumlah'];?>
                                    </td>


                                    <td style=" width: 120px;">
                                        <?php $date = date_create($data['tanggal_pengajuan']);?>
                                        <?=date_format($date, "d-m-Y");?>
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
                                        <a href="/Pegawai/detailpermin/<?=$data['id']?>"
                                            class="  btn btn-primary"><i class="fas fa-eye"></i></a>




                                        <?php if ($data['status'] == 'belum diproses') {?>


                                        <a href="/Pegawai/ubah/<?=$data['id']?>"
                                            class=" btn btn-warning"><i class="fas fa-edit"></i></a>
                                        <!-- <a href="/Pegawai/delete/<?=$data['id']?>"
                                        class=" btn btn-danger"><i class="fas fa-trash"></i></a> -->
                                        <a href="/Pegawai/delete/<?=$data['id']?>"
                                            class="btn btn-danger delete-btn" data-toggle="modal"
                                            data-target="#deleteConfirmationModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <?php } else {?>


                                        <button class="  btn btn-secondary"><i class="fa fa-edit"></i> </button>
                                        <button class="  btn btn-secondary"><i class="fa fa-trash"></i> </button>
                                        <?php }?>

                                        <!-- </div> -->
                                        <!-- </div> -->

                                    </td>
                                </tr>
                                <?php }?>
                                <!-- end of foreach                -->
                                <?php } else {?>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="text-gray-900 text-center">Data belum ada.</h3>
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
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus permintaan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteConfirmationButton" href="#" class="btn btn-danger">Hapus</a>
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

    function setDeleteConfirmationUrl(url) {
        $("#deleteConfirmationButton").attr("href", url);
    }

    // Show delete confirmation modal
    $(".delete-btn").on("click", function() {
        var deleteUrl = $(this).attr("href");
        setDeleteConfirmationUrl(deleteUrl);
        $("#deleteConfirmationModal").modal("show");
        return false;
    });

    // Close delete confirmation modal on cancel
    $('#deleteConfirmationModal').on('hide.bs.modal', function(e) {
        setDeleteConfirmationUrl("#"); // Reset the href when the modal is closed
    });

    // Hide alert messages after 3 seconds
</script>
<?=$this->endSection();?>