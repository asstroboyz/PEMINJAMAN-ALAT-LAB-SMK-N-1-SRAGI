<?= $this->extend('Admin/Templates/Index'); ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Barang</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg'); ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <a href="/Admin/peminjaman?status=all">&laquo; Kembali ke daftar peminjaman</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/Admin/savePeminjaman') ?>" method="post" id="form">
                <?= csrf_field(); ?>

                <!-- Pilih Ruangan Tujuan -->
                <div class="mb-3">
                    <label for="select-ruangan-tujuan">Ruangan Tujuan</label>
                    <select id="select-ruangan-tujuan" name="ruangan_id" class="form-control">
                        <option value="">-- Pilih Ruangan --</option>
                        <?php foreach ($ruangan as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= $r['nama_ruangan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="select-ruangan-tujuan">Pilih Barang</label>
                     <select id="select-barang" class="form-control me-2 flex-grow-1">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach ($barangs as $b): ?>
                            <option value="<?= $b['id'] ?>"
                                data-kode-brg="<?= $b['kode_brg'] ?>"
                                data-nama="<?= $b['nama_brg'] ?>"
                                data-merk="<?= $b['merk'] ?>"
                                data-kondisi="<?= $b['kondisi'] ?>"
                                data-ruangan-id="<?= $b['ruangan_id'] ?>"
                                data-nama-ruangan="<?= $mapRuangan[$b['ruangan_id']] ?? '' ?>"
                                data-stok="<?= $b['stok'] ?>">
                                <?= $b['nama_brg'] ?> - <?= $b['merk'] ?> (<?= $b['kondisi'] ?>) - <?= $mapRuangan[$b['ruangan_id']] ?? '' ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <button type="button" class="btn btn-primary mt-3" id="tambah_barang">Tambah</button>

                </div>

               
                <!-- Table Barang -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="table-barang">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Merk</th>
                                <th>Kondisi</th>
                                <th>Ruangan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="list-barang" class="text-center">
                            <tr id="belum_barang">
                                <td colspan="7">Belum ada barang dipilih</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Hidden Inputs -->
                <div id="input-barang-hidden"></div>
                <input type="hidden" name="catatan" id="catatan-hidden">

                <button type="submit" class="btn btn-success mt-3">Simpan</button>
            </form>
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
            tbody.append('<tr class="text-center"><td colspan="7">Belum ada barang dipilih</td></tr>');
            return;
        }

        dataBarangDipilih.forEach((item, idx) => {
            tbody.append(`
            <tr>
                <td>${idx+1}</td>
                <td>${item.nama}</td>
                <td>${item.merk}</td>
                <td>${item.kondisi}</td>
                <td>${item.namaRuangan}</td>
                <td><span class="badge bg-info">${item.jumlah}</span></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm hapus-barang"
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

    // Tambah barang
    $('#tambah_barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        let option = select[0].options[select[0].selectedIndex];

        if (!val) {
            Swal.fire('Oops!', 'Pilih barang dulu!', 'warning');
            return;
        }

        if (dataBarangDipilih.some(i => i.kode == val && i.namaRuangan == option.getAttribute('data-nama-ruangan'))) {
            Swal.fire('Info', 'Barang sudah ada di ruangan ini', 'info');
            return;
        }

        let stok = parseInt(option.getAttribute('data-stok')) || 0;

        Swal.fire({
            title: 'Masukkan jumlah',
            input: 'number',
            inputAttributes: {
                min: 1,
                step: 1,
                max: stok
            },
            inputValue: 1,
            showCancelButton: true,
            confirmButtonText: 'Tambah',
            cancelButtonText: 'Batal',
            inputValidator: (v) => {
                v = parseInt(v);
                if (!v || v < 1) return 'Jumlah harus >0';
                if (v > stok) return `Maksimal ${stok}`;
            }
        }).then(res => {
            if (res.isConfirmed) {
                dataBarangDipilih.push({
                    kode: val,
                    kodeBrg: option.getAttribute('data-kode-brg'),
                    nama: option.getAttribute('data-nama'),
                    merk: option.getAttribute('data-merk'),
                    kondisi: option.getAttribute('data-kondisi'),
                    ruanganId: option.getAttribute('data-ruangan-id'),
                    namaRuangan: option.getAttribute('data-nama-ruangan'),
                    jumlah: parseInt(res.value)
                });
                renderBarangDipilih();
                select.val('');
            }
        });
    });

    // Hapus barang
    $(document).on('click', '.hapus-barang', function() {
        let kode = parseInt($(this).data('kode'));
        let namaRuangan = $(this).data('nama-ruangan').trim();
        dataBarangDipilih = dataBarangDipilih.filter(i => !(parseInt(i.kode) === kode && i.namaRuangan.trim() === namaRuangan));
        renderBarangDipilih();
    });

    // Submit form dengan konfirmasi + catatan
    $('#form').on('submit', function(e) {
        e.preventDefault();
        if (dataBarangDipilih.length === 0) {
            Swal.fire('Oops!', 'Minimal pilih satu barang', 'warning');
            return;
        }

        Swal.fire({
            title: 'Yakin simpan peminjaman?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                // Catatan sekali saja
                Swal.fire({
                    title: 'Catatan (opsional)',
                    input: 'textarea',
                    inputPlaceholder: 'Tulis catatan jika ada...',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Lewati'
                }).then(c => {
                    if ($('#catatan-hidden').length === 0)
                        $('#form').append('<input type="hidden" name="catatan" id="catatan-hidden">');
                    $('#catatan-hidden').val(c.isConfirmed ? c.value : '');
                    $('#form')[0].submit(); // submit final
                });
            }
        });
    });

    renderBarangDipilih();
</script>
<?= $this->endSection(); ?>