<?php echo $this->extend('Admin/Templates/Index'); ?>
<?php echo $this->section('page-content'); ?>
<style>
    .radio-box-group {
        display: flex;
        gap: 8px;
        justify-content: flex-start;
    }

    .radio-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ccc;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 14px;
        font-weight: 600;
        color: #555;
        background: #fff;
        cursor: pointer;
        transition: all 0.25s ease;
        user-select: none;
    }

    .radio-box input {
        display: none;
    }

    .radio-box:hover {
        border-color: #a855f7;
        color: #9333ea;
    }

    .radio-box.active {
        border-color: #9333ea;
        background-color: #9333ea;
        color: #fff;
        box-shadow: 0 0 5px rgba(147, 51, 234, 0.3);
    }
</style>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Barang</h1>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?php echo session()->getFlashdata('msg'); ?></div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header">
            <a href="/Admin/peminjaman?status=all">&laquo; Kembali ke daftar peminjaman</a>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/Admin/savePeminjaman') ?>" method="post" id="form">
                <?php echo csrf_field(); ?>

                <!-- Pilih Ruangan Tujuan -->
                <div class="mb-3">
                    <label for="select-ruangan-tujuan">Ruangan Tujuan</label>
                    <select id="select-ruangan-tujuan" name="ruangan_id" class="form-control">
                        <option value="">-- Pilih Ruangan --</option>
                        <?php foreach ($ruangan as $r): ?>
                            <option value="<?php echo $r['id'] ?>"><?php echo $r['nama_ruangan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- <div class="form-group mb-3">
            <label for="kelas">Pilih Kelas</label>
            <select id="kelas" name="kelas" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelasList as $k): ?>
                    <option value="<?= esc($k['kelas']); ?>"><?= strtoupper($k['kelas']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="siswa">Pilih Siswa</label>
            <select id="siswa" name="siswa_id" class="form-control" required>
                <option value="">-- Pilih Siswa --</option>
            </select>
        </div> -->
                <div class="form-group mb-3">
                    <label class="fw-bold mb-2 d-block">Jenis Peminjam</label>
                    <div class="radio-box-group" id="jenisPeminjamGroup">
                        <label class="radio-box active">
                            <input type="radio" name="jenis_peminjam" value="siswa" checked>
                            Siswa
                        </label>
                        <label class="radio-box">
                            <input type="radio" name="jenis_peminjam" value="guru_admin">
                            Guru / Admin
                        </label>
                    </div>
                </div>

                <!-- Pilih Kelas & Siswa -->
                <div id="form-siswa">
                    <div class="form-group mb-3">
                        <label for="kelas">Pilih Kelas</label>
                        <select id="kelas" name="kelas" class="form-control">
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($kelasList as $k): ?>
                                <option value="<?= esc($k['kelas']); ?>"><?= strtoupper($k['kelas']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="siswa">Pilih Siswa</label>
                        <select id="siswa" name="siswa_id" class="form-control">
                            <option value="">-- Pilih Siswa --</option>
                        </select>
                    </div>
                </div>

                <!-- Pilih Guru/Admin -->
                <div id="form-guru-admin" style="display:none;">
                    <div class="form-group mb-3">
                        <label for="guru_admin">Pilih Guru / Admin</label>
                        <select id="guru_admin" name="guru_admin_id" class="form-control">
                            <option value="">-- Pilih Guru/Admin --</option>
                            <?php foreach ($guruAdmin as $ga): ?>
                                <option value="<?= esc($ga['id']); ?>"><?= esc($ga['username']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="select-ruangan-tujuan">Pilih Barang</label>
                    <select id="select-barang" class="form-control me-2 flex-grow-1">
                        <option value="">-- Pilih Barang --</option>
                        <?php foreach ($barangs as $b): ?>
                            <option value="<?php echo $b['id'] ?>" data-kode-brg="<?php echo $b['kode_brg'] ?>"
                                data-nama="<?php echo $b['nama_brg'] ?>" data-merk="<?php echo $b['merk'] ?>"
                                data-kondisi="<?php echo $b['kondisi'] ?>" data-ruangan-id="<?php echo $b['ruangan_id'] ?>"
                                data-nama-ruangan="<?php echo $mapRuangan[$b['ruangan_id']] ?? '' ?>"
                                data-stok="<?php echo $b['stok'] ?>">
                                <?php echo $b['nama_brg'] ?> -<?php echo $b['merk'] ?> (<?php echo $b['kondisi'] ?>)
                                -<?php echo $mapRuangan[$b['ruangan_id']] ?? '' ?>
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

<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // document.getElementById('kelas').addEventListener('change', function() {
    //     const kelas = this.value;
    //     const siswaSelect = document.getElementById('siswa');
    //     siswaSelect.innerHTML = '<option value="">Memuat...</option>';

    //     if (kelas) {
    //         fetch('<?= base_url('Admin/getSiswaByKelas'); ?>/' + kelas)
    //             .then(res => res.json())
    //             .then(data => {
    //                 siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
    //                 if (!Array.isArray(data) || data.length === 0) {
    //                     siswaSelect.innerHTML += '<option value="">Tidak ada siswa di kelas ini</option>';
    //                 } else {
    //                     data.forEach(user => {
    //                         siswaSelect.innerHTML += `<option value="${user.id}">${user.username}</option>`;
    //                     });
    //                 }
    //             })
    //             .catch(err => {
    //                 siswaSelect.innerHTML = '<option value="">Gagal memuat siswa</option>';
    //                 console.error('Fetch error:', err);
    //             });
    //     } else {
    //         siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
    //     }
    // });
    document.querySelectorAll('input[name="jenis_peminjam"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'siswa') {
                document.getElementById('form-siswa').style.display = 'block';
                document.getElementById('form-guru-admin').style.display = 'none';
            } else {
                document.getElementById('form-siswa').style.display = 'none';
                document.getElementById('form-guru-admin').style.display = 'block';
            }
        });
    });

    // update URL fetch jadi sesuai route Admin
    document.getElementById('kelas').addEventListener('change', function() {
        const kelas = this.value;
        const siswaSelect = document.getElementById('siswa');
        siswaSelect.innerHTML = '<option value="">Memuat...</option>';

        if (kelas) {
            fetch('<?= base_url('Admin/getSiswaByKelas'); ?>/' + kelas)
                .then(res => res.json())
                .then(data => {
                    siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                    data.forEach(user => {
                        siswaSelect.innerHTML += `<option value="${user.id}">${user.username}</option>`;
                    });
                })
                .catch(err => {
                    siswaSelect.innerHTML = '<option value="">Gagal memuat siswa</option>';
                    console.error(err);
                });
        } else {
            siswaSelect.innerHTML = '<option value="">-- Pilih Siswa --</option>';
        }
    });
</script>

<script>
    document.querySelectorAll('.radio-box').forEach(box => {
        box.addEventListener('click', function() {
            document.querySelectorAll('.radio-box').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const value = this.querySelector('input').value;
            if (value === 'siswa') {
                document.getElementById('form-siswa').style.display = 'block';
                document.getElementById('form-guru-admin').style.display = 'none';
            } else {
                document.getElementById('form-siswa').style.display = 'none';
                document.getElementById('form-guru-admin').style.display = 'block';
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        // Aktifkan Select2
        $('#id_user').select2({
            placeholder: "-- Pilih User Peminjam --",
            allowClear: true,
            width: '100%'
        });

        $('#kelas').on('change', function() {
            const selectedKelas = ($(this).val() || '').toLowerCase();
            console.log("🔍 kelas dipilih:", selectedKelas);

            // reset pilihan
            $('#id_user').val('').trigger('change');

            // tampil/hide option
            $('#id_user option').each(function() {
                const userKelas = ($(this).data('kelas') || '').toLowerCase();
                if (!selectedKelas || $(this).val() === '') {
                    $(this).show();
                } else if (userKelas === selectedKelas) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // 💥 tambahkan ini supaya Select2 rebuild list dari DOM
            $('#id_user').select2('destroy');
            $('#id_user').html($('#id_user').html());
            $('#id_user').select2({
                placeholder: "-- Pilih User Peminjam --",
                allowClear: true,
                width: '100%'
            });
        });


        // Checkbox "Gunakan Admin (saya sendiri)"
        $('#adminSendiri').on('change', function() {
            if ($(this).is(':checked')) {
                $('#id_user').prop('disabled', true).val('').trigger('change');
            } else {
                $('#id_user').prop('disabled', false);
            }
        });

    });
</script>


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

    //admin
    $('#adminSendiri').on('change', function() {
        if ($(this).is(':checked')) {
            $('#id_user').prop('disabled', true).val(''); // disable & reset value
        } else {
            $('#id_user').prop('disabled', false);
        }
    });


    // Tambah barang
    $('#tambah_barang').on('click', function() {
        let select = $('#select-barang');
        let val = select.val();
        let option = select[0].options[select[0].selectedIndex];

        if (!val) {
            Swal.fire('Oops!', 'Pilih barang dulu!', 'warning');
            return;
        }

        if (dataBarangDipilih.some(i => i.kode == val && i.namaRuangan == option.getAttribute(
                'data-nama-ruangan'))) {
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
        dataBarangDipilih = dataBarangDipilih.filter(i => !(parseInt(i.kode) === kode && i.namaRuangan
            .trim() === namaRuangan));
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
                        $('#form').append(
                            '<input type="hidden" name="catatan" id="catatan-hidden">');
                    $('#catatan-hidden').val(c.isConfirmed ? c.value : '');
                    $('#form')[0].submit(); // submit final
                });
            }
        });
    });



    renderBarangDipilih();
</script>
<?php echo $this->endSection(); ?>