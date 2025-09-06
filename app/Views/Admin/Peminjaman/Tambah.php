<?php echo $this->extend('Admin/Templates/Index'); ?>
<?php echo $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Tambah Peminjaman Alat</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?php echo session()->getFlashdata('error') ?></div>
            <?php endif?>
             <form action="<?php echo base_url('/Admin/savePeminjaman') ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field() ?>
                <!-- Input utama ... -->
                <!-- ... sama seperti sebelumnya ... -->

                <!-- PILIH BARANG DENGAN TAMBAH PER SATUAN -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="select-barang">Pilih Barang</label>
                      <!-- Asumsi $ruangan adalah array indexed by ID -->
<?php
    // Buat map biar akses cepat id -> nama
    $mapRuangan = [];
    foreach ($ruangan as $r) {
        $mapRuangan[$r['id']] = $r['nama_ruangan'];
    }
?>

<select class="form-control" id="select-barang">
    <option value="">-- Pilih Barang --</option>
    <?php foreach ($barangs as $b): ?>
        <option
            value="<?php echo $b['kode_barang'] ?>"
            data-nama="<?php echo $b['nama_brg'] ?>"
            data-merk="<?php echo $b['merk'] ?>"
            data-kondisi="<?php echo $b['kondisi'] ?>"
            data-lokasi="<?php echo $b['ruangan_id'] ?>"
            data-nama-ruangan="<?php echo htmlspecialchars($mapRuangan[$b['ruangan_id']] ?? ''); ?>"
        >
            <?php echo $b['kode_barang'] ?> -<?php echo $b['nama_brg'] ?> (<?php echo $b['merk'] ?>),<?php echo $b['kondisi'] ?>, Ruangan:<?php echo $mapRuangan[$b['ruangan_id']] ?? $b['ruangan_id']; ?>
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

                <!-- TABEL LIST BARANG YANG DIPILIH -->
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
                        <!-- Akan diisi js -->
                        </tbody>
                    </table>
                </div>
                <!-- Input hidden barang[] untuk submit -->
                <div id="input-barangs"></div>

                <!-- Catatan & submit -->
                <div class="col-12 mb-3">
                    <label for="catatan">Catatan (opsional)</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
                <div class="mt-4">
                    <button class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo base_url('admin/peminjaman') ?>" class="btn btn-secondary ml-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('additional-js'); ?>

<script>
$(function() {
    let barangDipilih = [];

    $('#add-barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        if (!val || barangDipilih.some(item => item.kode === val)) return;

        let nama = select.find(':selected').data('nama');
        let merk = select.find(':selected').data('merk');
        let kondisi = select.find(':selected').data('kondisi');
        let namaRuangan = select.find(':selected').data('nama-ruangan')

        barangDipilih.push({
            kode: val,
            nama: nama,
            merk: merk,
            kondisi: kondisi,
            lokasi: namaRuangan
        });
        updateTable();
        select.val('');
        updateInputBarangs();
    });

    function updateTable() {
        let tbody = $('#table-barang tbody');
        tbody.html('');
        barangDipilih.forEach((item, idx) => {
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

    $('#table-barang').on('click', '.btn-hapus-barang', function() {
        let kode = $(this).data('kode');
        barangDipilih = barangDipilih.filter(item => item.kode !== kode);
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
});
</script>

<?php echo $this->endSection(); ?>




