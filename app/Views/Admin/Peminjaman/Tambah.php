<?= $this->extend('Admin/Templates/Index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Barang</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success" role="alert">
                    <?php echo session()->getFlashdata('msg'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">

            <div class="card shadow">
                <div class="card-header">
                    <a href="/Admin/peminjaman?status=all">&laquo; Kembali ke daftar peminjaman</a>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/Admin/savePeminjaman') ?> " method="post" enctype="multipart/form-data" id="form">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="select-barang" class="form-label">Pilih Barang</label>
                            <select id="select-barang" class="form-control form-control-user ">
                                <option value="">-- Pilih Barang --</option>
                                <?php foreach ($barangs as $b): ?>
                                    <!-- <option
                                        value="<?= esc($b['kode_brg']) ?>"
                                        data-nama="<?= esc($b['nama_brg']) ?>"
                                        data-merk="<?= esc($b['merk']) ?>"
                                        data-kondisi="<?= esc($b['kondisi']) ?>"
                                        data-lokasi="<?= esc($b['ruangan_id']) ?>"
                                        data-nama-ruangan="<?= esc($mapRuangan[$b['ruangan_id']] ?? '') ?>">
                                        <?= esc($b['kode_brg']) ?> - <?= esc($b['nama_brg']) ?> (<?= esc($b['merk']) ?>), <?= esc($b['kondisi']) ?>, Ruangan: <?= esc($mapRuangan[$b['ruangan_id']] ?? $b['ruangan_id']) ?>
                                    </option> -->
                                    <option value="<?= $b['id'] ?>"
                                        data-kode-brg="<?= $b['kode_brg'] ?>"
                                        data-nama="<?= $b['nama_brg'] ?>"
                                        data-merk="<?= $b['merk'] ?>"
                                        data-kondisi="<?= $b['kondisi'] ?>"
                                        data-nama-ruangan="<?= $mapRuangan[$b['ruangan_id']] ?? '' ?>"
                                        data-ruangan-id="<?= $b['ruangan_id'] ?>">
                                        <?= $b['nama_brg'] ?> - <?= $b['merk'] ?> (<?= $b['kondisi'] ?>) - <?= $mapRuangan[$b['ruangan_id']] ?? '' ?>
                                    </option>


                                <?php endforeach ?>
                            </select>
                            <button type="button" class="btn btn-primary mt-2" id="tambah_barang">Tambah Barang</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-barang">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Merk</th>
                                        <th>Kondisi</th>
                                        <th>Ruangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="list-barang">
                                    <tr class="text-center" id="belum_barang">
                                        <td colspan="7">Belum ada barang dipilih</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="input-barang-hidden"></div>
                        <button class="btn btn-success mt-3" type="submit">Simpan</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    let dataBarangDipilih = [];

    function renderBarangDipilih() {
        let tbody = $('#list-barang');
        tbody.empty();
        $('#input-barang-hidden').empty();
        if (dataBarangDipilih.length === 0) {
            tbody.append(`<tr class="text-center" id="belum_barang">
            <td colspan="7">Belum ada barang dipilih</td>
        </tr>`);
            return;
        }
        dataBarangDipilih.forEach((item, idx) => {
            tbody.append(`
            <tr>
                <td>${idx + 1}</td>
                <td>${item.kode}</td>
                <td>${item.nama}</td>
                <td>${item.merk}</td>
                <td>${item.kondisi}</td>
                <td>${item.namaRuangan}</td>
               <td>
    <button type="button" 
        class="btn btn-danger btn-sm hapus-barang" 
        data-kode="${item.kode}" 
        data-nama-ruangan="${item.namaRuangan}">
        Hapus
    </button>
</td>

            </tr>
        `);
            $('#input-barang-hidden').append(`
    <input type="hidden" name="barang[${idx}][kode]" value="${item.kode}">
    <input type="hidden" name="barang[${idx}][ruangan_id]" value="${item.ruanganId}">
`);

        });
    }
    // $('#tambah_barang').on('click', function() {
    //     let select = $('#select-barang');
    //     let val = select.val();
    //     let option = select[0].options[select[0].selectedIndex];
    //     console.log('VAL:', val);
    //     console.log('OPTION:', option);
    //     console.log('data-nama:', option.getAttribute('data-nama'));
    //     console.log('data-merk:', option.getAttribute('data-merk'));
    //     console.log('data-kondisi:', option.getAttribute('data-kondisi'));
    //     console.log('data-lokasi:', option.getAttribute('data-lokasi'));
    //     console.log('data-nama-ruangan:', option.getAttribute('data-nama-ruangan'));
    //     if (!val) {
    //         alert('Pilih barang!');
    //         return;
    //     }
    //     if (dataBarangDipilih.some(item => item.kode === val)) {
    //         alert('Barang sudah ada!');
    //         return;
    //     }
    //     dataBarangDipilih.push({
    //         kode: val, // ini ID inventaris
    //         kodeBrg: option.getAttribute('data-kode-brg'),
    //         nama: option.getAttribute('data-nama'),
    //         merk: option.getAttribute('data-merk'),
    //         kondisi: option.getAttribute('data-kondisi'),
    //         lokasi: option.getAttribute('data-lokasi'),
    //         namaRuangan: option.getAttribute('data-nama-ruangan')
    //     });

    //     console.log('dataBarangDipilih:', dataBarangDipilih);
    //     renderBarangDipilih();
    //     select.val('');
    // });
    $('#tambah_barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        let option = select[0].options[select[0].selectedIndex];
        if (!val) {
            alert('Pilih barang!');
            return;
        }
        // Pengecekan duplicate: kode + namaRuangan
        if (dataBarangDipilih.some(item => item.kode === val && item.namaRuangan === option.getAttribute('data-nama-ruangan'))) {
            alert('Barang sudah ada di ruangan ini!');
            return;
        }
        dataBarangDipilih.push({
            kode: val, // id inventaris
            kodeBrg: option.getAttribute('data-kode-brg'),
            nama: option.getAttribute('data-nama'),
            merk: option.getAttribute('data-merk'),
            kondisi: option.getAttribute('data-kondisi'),
            ruanganId: option.getAttribute('data-ruangan-id'),

            namaRuangan: option.getAttribute('data-nama-ruangan')
        });

        renderBarangDipilih();
        select.val('');
    });

    $(document).on('click', '.hapus-barang', function() {
        let kode = $(this).data('kode');
        let namaRuangan = $(this).data('nama-ruangan');
        dataBarangDipilih = dataBarangDipilih.filter(item => !(item.kode === kode && item.namaRuangan === namaRuangan));
        renderBarangDipilih();
    });

    $('#form-barang').on('submit', function(e) {
        if (dataBarangDipilih.length === 0) {
            alert('Minimal pilih satu barang!');
            e.preventDefault();
        }
    });
    renderBarangDipilih();
</script>
<?= $this->endSection(); ?>