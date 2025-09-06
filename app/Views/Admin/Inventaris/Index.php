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

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                   
                    <a href="/Admin/tambah_inv" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Barang
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="rekapTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ruangan</th>
                                    <th>Nama Barang</th>
                                    <th>Merk</th>
                                    <th>Tipe</th>
                                    <th>Stok</th>
                                    <th>Detail Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($rekap as $row): ?>
                                <?php $key = md5($row['nama_ruangan'].'|'.$row['nama_brg']); ?>
                                <tr class="group-row">
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($row['nama_ruangan']); ?></td>
                                    <td><?= esc($row['nama_brg']); ?></td>
                                    <td><?= esc($row['merk']); ?></td>
                                    <td><?= esc($row['jenis_brg']); ?></td>
                                    <td style="text-align:center;"><?= esc($row['stok']); ?></td>
                                    <td style="text-align:center;">
                                        <button class="btn btn-info btn-sm toggle-detail"
                                            data-key="<?= $key ?>">Show All</button>
                                    </td>
                                </tr>
                                <!-- Expandable: detail SN/unit (initially hidden) -->
                                <tr class="detail-row" style="display:none;" data-key="<?= $key ?>">
                                    <td colspan="7">
                                        <div class="p-2 bg-light rounded shadow-sm">
                                            <b>Unit di <?= esc($row['nama_ruangan']) ?> (<?= esc($row['nama_brg']) ?>):</b>
                                            <table class="table table-sm table-hover mb-0 mt-2">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Barang</th>
                                                        <th>Kondisi</th>
                                                        <th>Tanggal Masuk</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($inventaris as $detail): ?>
                                                        <?php if ($detail['nama_ruangan'] == $row['nama_ruangan'] && $detail['nama_brg'] == $row['nama_brg']): ?>
                                                        <tr>
                                                            <td><?= esc($detail['kode_barang']); ?></td>
                                                            <td>
                                                                <?php if($detail['kondisi']=='rusak'): ?>
                                                                    <span class="badge badge-danger">Rusak</span>
                                                                <?php elseif($detail['kondisi']=='bekas'): ?>
                                                                    <span class="badge badge-warning">Bekas</span>
                                                                <?php else: ?>
                                                                    <span class="badge badge-success">Baru</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= date('d-m-Y', strtotime($detail['created_at'])) ?></td>
                                                            <td>
                                                                <a href="/Admin/detail_inv/<?= $detail['kode_barang'] ?>" class="btn btn-primary btn-xs" title="Lihat"><i class="fa fa-eye"></i></a>
                                                                <!-- <a href="/Admin/ubah/<?= $detail['kode_barang'] ?>" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></a> -->
                                                            </td>
                                                        </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
$(document).ready(function(){
    $('.toggle-detail').on('click', function(){
        var key = $(this).data('key');
        $('tr.detail-row[data-key="'+key+'"]').toggle();
    });
});
</script>
<?= $this->endSection(); ?>
