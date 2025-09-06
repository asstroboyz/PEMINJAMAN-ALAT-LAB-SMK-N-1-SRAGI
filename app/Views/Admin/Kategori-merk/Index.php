<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-900"><?= esc($title) ?></h1>

    <?php if (session()->has('PesanBerhasil')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session('PesanBerhasil') ?>
        </div>
    <?php elseif (session()->has('PesanGagal')) : ?>
        <div class="alert alert-danger" role="alert">
            <?= session('PesanGagal') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3>Daftar Relasi Kategori - Merk</h3>
            <a href="/Admin/tambahMerkKategori" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Relasi
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width:50px; text-align:center;">No</th>
                            <th>Kategori</th>
                            <th>Merk</th>
                            <th style="width:150px; text-align:center;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($KategoriMerk) : ?>
                            <?php foreach ($KategoriMerk as $i => $row) : ?>
                                <tr>
                                    <td style="text-align:center;"><?= $i + 1; ?></td>
                                    <td><?= esc($row['nama_kategori']); ?></td>
                                    <td><?= esc($row['nama_merk']); ?></td>
                                    <td style="text-align:center;">
                                        <a href="/Admin/kategoriMerk_edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm btn-delete"
                                            data-toggle="modal" data-target="#modalDelete"
                                            data-delete-url="<?= site_url('/Admin/KategoriMerk_delete/' . $row['id']) ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-gray-700">
                                    <strong>Belum ada relasi kategori-merk.</strong>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Delete</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus relasi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a id="deleteLink" href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('additional-js'); ?>
<script>
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data('delete-url');
        $('#deleteLink').attr('href', deleteUrl);
        $('#modalDelete').modal('show');
    });
</script>
<?= $this->endSection(); ?>
