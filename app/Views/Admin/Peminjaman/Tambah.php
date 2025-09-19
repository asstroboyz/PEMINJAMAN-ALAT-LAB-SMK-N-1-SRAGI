<?php echo $this->extend('Admin/Templates/Index');?>
<?php echo $this->section('page-content');?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Tambah Peminjaman Alat</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?php echo session()->getFlashdata('error')?></div>
            <?php endif?>
            <form action="<?php echo base_url('/Admin/savePeminjaman')?>" method="post" enctype="multipart/form-data" id="form-peminjaman">
                <?php echo csrf_field()?>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="select-barang">Pilih Barang</label>
                        <?php
                            $mapRuangan = [];
                            foreach ($ruangan as $r) {
                                $mapRuangan[$r['id']] = $r['nama_ruangan'];
                            }
                        ?>
                        <select class="form-control" id="select-barang">
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($barangs as $b): ?>
                                <option
                                    value="<?php echo $b['kode_barang']?>"
                                    data-nama="<?php echo $b['nama_brg']?>"
                                    data-merk="<?php echo $b['merk']?>"
                                    data-kondisi="<?php echo $b['kondisi']?>"
                                    data-lokasi="<?php echo $b['ruangan_id']?>"
                                    data-nama-ruangan="<?php echo $mapRuangan[$b['ruangan_id']] ?? ''?>"
                                >
                                    <?php echo $b['kode_barang']?> - <?php echo $b['nama_brg']?> (<?php echo $b['merk']?>), <?php echo $b['kondisi']?>, Ruangan: <?php echo $mapRuangan[$b['ruangan_id']] ?? $b['ruangan_id']?>
                                </option>
                            <?php endforeach?>
                        </select>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="button" class="btn btn-primary" id="add-barang">
                            <i class="fa fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Daftar Barang Dipinjam</label>
                    <table class="table table-bordered" id="table-barang">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="input-barangs"></div>
                <div class="col-12 mb-3">
                    <label for="catatan">Catatan (opsional)</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
                <div class="mt-4">
                    <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo base_url('admin/peminjaman')?>" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>
<?php echo $this->section('additional-js');?>
<script>
$(function() {
    // GANTI INI (PASTIKAN PAKE window)
    window.barangDipilih = window.barangDipilih || [];
    let barangDipilih = window.barangDipilih;

    function showAlert(msg) {
        let $alert = $('<div class="alert alert-warning">'+msg+'</div>');
        $('.card-body').prepend($alert);
        setTimeout(() => $alert.fadeOut(400,()=>{$alert.remove()}), 2000);
    }

    $('#add-barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        let data = select.find(':selected').data();
        console.log('VAL:', val, 'DATA:', data);

        if (!val) {
            showAlert("Pilih barang dulu!");
            return;
        }
        if (barangDipilih.some(item => item.kode === val)) {
            showAlert("Barang sudah ada di daftar!");
            select.val('');
            return;
        }
        let nama = data.nama;
        let merk = data.merk;
        let kondisi = data.kondisi;
        let namaRuangan = data.namaRuangan !== undefined ? data.namaRuangan : data['nama-ruangan'];

        barangDipilih.push({
            kode: val,
            nama: nama,
            merk: merk,
            kondisi: kondisi,
            lokasi: namaRuangan
        });
        console.log('barangDipilih after push:', barangDipilih);
        updateTable();
        select.val('');
        updateInputBarangs();
        $('html, body').animate({
            scrollTop: $("#table-barang").offset().top-60
        }, 400);
    });

    function updateTable() {
        let tbody = $('#table-barang tbody');
        tbody.html('');
        if (barangDipilih.length === 0) {
            tbody.append('<tr><td colspan="7" class="text-center text-muted">Belum ada barang dipilih.</td></tr>');
        } else {
            barangDipilih.forEach((item, idx) => {
                console.log('Render Row:', idx, item);
                tbody.append(`
                    <tr>
                        <td>${idx+1}</td>
                        <td>${item.kode}</td>
                        <td>${item.nama}</td>
                        <td>${item.merk}</td>
                        <td>${item.kondisi}</td>
                        <td>${item.lokasi}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus-barang" data-kode="${item.kode}">Hapus</button>
                        </td>
                    </tr>
                `);
            });
        }
        console.log('Tbody html after update:', tbody.html());
    }

    $('#table-barang').on('click', '.btn-hapus-barang', function() {
        let kode = $(this).data('kode');
        barangDipilih = barangDipilih.filter(item => item.kode !== kode);
        window.barangDipilih = barangDipilih; // sync global
        updateTable();
        updateInputBarangs();
    });

    function updateInputBarangs() {
        let div = $('#input-barangs');
        div.html('');
        barangDipilih.forEach(item => {
            div.append(`<input type="hidden" name="barang[]" value="${item.kode}"/>`);
        });
    }

    $('#form-peminjaman').on('submit', function(e) {
        if (barangDipilih.length === 0) {
            showAlert("Minimal pilih satu barang!");
            e.preventDefault();
        }
    });

    updateTable();
});
</script>

<?php echo $this->endSection();?>
