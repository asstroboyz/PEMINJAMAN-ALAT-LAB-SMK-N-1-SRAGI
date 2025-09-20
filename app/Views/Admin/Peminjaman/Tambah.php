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
                                    <option value="<?= $b['id'] ?>"
                                        data-kode-brg="<?= $b['kode_brg'] ?>"
                                        data-nama="<?= $b['nama_brg'] ?>"
                                        data-merk="<?= $b['merk'] ?>"
                                        data-kondisi="<?= $b['kondisi'] ?>"
                                        data-nama-ruangan="<?= $mapRuangan[$b['ruangan_id']] ?? '' ?>"
                                        data-nama-ruangan="<?= $mapRuangan[$b['ruangan_id']] ?? '' ?>"
                                        data-ruangan-id="<?= $b['ruangan_id'] ?>"
                                        data-stok="<?= $b['stok'] ?>">
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
                                        <th>Jumlah</th>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5/bootstrap-4.min.css" rel="stylesheet">

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
                 <td>${item.jumlah}</td>
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
     <input type="hidden" name="barang[${idx}][jumlah]" value="${item.jumlah}"> 
`);

        });
    }

    // $('#tambah_barang').on('click', function() {
    //     let select = $('#select-barang');
    //     let val = select.val();
    //     let option = select[0].options[select[0].selectedIndex];
    //     if (!val) {
    //         alert('Pilih barang!');
    //         return;
    //     }
    //     // Pengecekan duplicate: kode + namaRuangan
    //     if (dataBarangDipilih.some(item => item.kode === val && item.namaRuangan === option.getAttribute('data-nama-ruangan'))) {
    //         alert('Barang sudah ada di ruangan ini!');
    //         return;
    //     }
    //     let jumlah = prompt('Masukkan jumlah yang akan dipinjam:', 1);
    //     jumlah = parseInt(jumlah);
    //     if (isNaN(jumlah) || jumlah < 1) {
    //         alert('Jumlah harus angka > 0!');
    //         return;
    //     }
    //     dataBarangDipilih.push({
    //         kode: val, // id inventaris
    //         kodeBrg: option.getAttribute('data-kode-brg'),
    //         nama: option.getAttribute('data-nama'),
    //         merk: option.getAttribute('data-merk'),
    //         kondisi: option.getAttribute('data-kondisi'),
    //         ruanganId: option.getAttribute('data-ruangan-id'),
    //         namaRuangan: option.getAttribute('data-nama-ruangan'),
    //         jumlah: jumlah
    //     });

    //     renderBarangDipilih();
    //     select.val('');
    // });
    $('#tambah_barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        let option = select[0].options[select[0].selectedIndex];

        if (!val) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Pilih barang dulu!'
            });
            return;
        }

        if (dataBarangDipilih.some(item => item.kode === val && item.namaRuangan === option.getAttribute('data-nama-ruangan'))) {
            Swal.fire({
                icon: 'info',
                title: 'Duplicate!',
                text: 'Barang sudah ada di ruangan ini!'
            });
            return;
        }

        let stokTersedia = parseInt(option.getAttribute('data-stok')) || 0;

        Swal.fire({
            title: 'Masukkan jumlah yang akan dipinjam',
            input: 'number',
            inputAttributes: {
                min: 1,
                step: 1,
                max: stokTersedia
            },
            inputValue: 1,
            showCancelButton: true,
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                value = parseInt(value);
                if (!value || value < 1) return 'Jumlah harus lebih besar dari 0!';
                if (value > stokTersedia) return `Maksimal ${stokTersedia} sesuai stok tersedia!`;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let jumlah = parseInt(result.value);
                dataBarangDipilih.push({
                    kode: val,
                    kodeBrg: option.getAttribute('data-kode-brg'),
                    nama: option.getAttribute('data-nama'),
                    merk: option.getAttribute('data-merk'),
                    kondisi: option.getAttribute('data-kondisi'),
                    ruanganId: option.getAttribute('data-ruangan-id'),
                    namaRuangan: option.getAttribute('data-nama-ruangan'),
                    jumlah: jumlah
                });
                renderBarangDipilih();
                select.val('');
            }
        });
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