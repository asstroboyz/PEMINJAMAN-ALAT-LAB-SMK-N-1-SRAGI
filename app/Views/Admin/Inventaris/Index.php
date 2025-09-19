<?php echo $this->extend('Admin/Templates/Index') ?>
<?php echo $this->section('page-content'); ?>

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-900"><?php echo esc($title) ?></h1>

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
                    <a href="/Admin/tambah_inv" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Barang
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="rekapTable" class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Tipe</th>
            <th>Jenis</th>
            <th></th> <!-- Expand/collapse -->
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($grouped_rekap as $kode_barang => $g): ?>
            <tr data-kode="<?php echo $kode_barang ?>">
                <td><?php echo $no++; ?></td>
                <td><b><?php echo esc($kode_barang) ?></b></td>
                <td><?php echo esc($g['nama_brg']) ?></td>
                <td><?php echo esc($g['merk']) ?></td>
                <td><?php echo esc($g['tipe_serie']) ?></td>
                <td>
                    <?php
                        $jenis = $g['jenis_brg'];
                        if ($jenis === 'hrd') {
                            echo 'Hardware';
                        } elseif ($jenis === 'sfw') {
                            echo 'Software';
                        } else {
                            echo 'Tools';
                        }
                    ?>
                </td>
                <td class="details-control" style="text-align:center;cursor:pointer;">
                    <i class="fa fa-plus"></i>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>
<script>
    $(document).ready(function() {
        var groupedData =                                                                            <?php echo json_encode($grouped_rekap) ?>;

        var table = $('#rekapTable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": 0
            }]
        });


        function format(kode_barang) {
            var detail = groupedData[kode_barang]['detail'];
            var html = '<table class="table table-sm mb-0"><thead><tr><th>Ruangan</th><th>Stok</th></tr></thead><tbody>';
            for (var i = 0; i < detail.length; i++) {
                html += '<tr><td>' + detail[i].ruangan + '</td><td>' + detail[i].stok + '</td></tr>';
            }
            html += '</tbody></table>';
            return html;
        }


        $('#rekapTable tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var kode = tr.data('kode');
            if (row.child.isShown()) {
                row.child.hide();
                $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
            } else {
                row.child(format(kode)).show();
                $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>