<?php echo $this->extend('Admin/Templates/Index') ?>
<?php echo $this->section('page-content'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"></h1>


    <?php if (session()->has('PesanBerhasil')): ?>
    <div class="alert alert-success" role="alert">
        <?php echo session('PesanBerhasil') ?>
    </div>
    <?php elseif (session()->has('PesanGagal')): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo session('PesanGagal') ?>
    </div>
    <?php endif; ?>


    <div class="row">
        <div class="col-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="/Admin/addBarang" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Barang</a>

                </div>
          <div class="card-body">
    <div class="table-responsive">
        <table class="table align-middle text-center" id="dataTable" width="100%" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                  
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($master_brg) {?>
<?php foreach ($master_brg as $num => $data) {?>
                        <tr>
                            <td><?php echo $num + 1; ?></td>
                            <td><span class="fw-bold"><?php echo $data['kode_brg']; ?></span></td>
                            <td class="text-start">
                                <i class="fa fa-box text-primary me-2"></i>
                                <?php echo $data['nama_brg']; ?>
                                <small class="text-muted">(<?php echo $data['nama_merk']; ?>)</small>
                            </td>
                       
                            <td>
                                <a href="<?php echo site_url('/Admin/detail_master_brg/' . $data['kode_brg']) ?>"
                                   class="btn btn-sm btn-primary" title="Lihat Detail">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="/Admin/ubah_master/<?php echo $data['kode_brg'] ?>"
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                              
                            </td>
                        </tr>
                    <?php }?>
<?php } else {?>
                    <tr>
                        <td colspan="5">
                            <h5 class="text-muted text-center">Belum ada data barang.</h5>
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

<div class="modal fade" id="modalKonfirmasiDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus barang ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $($this).remove();
    })

}, 3000);
$('.btn-delete').on('click', function(e) {
    e.preventDefault();
    var deleteUrl = $(this).data('delete-url');
    $('#deleteLink').attr('href', deleteUrl);
    $('#modalKonfirmasiDelete').modal('show');
});
</script>
<?php echo $this->endSection(); ?>