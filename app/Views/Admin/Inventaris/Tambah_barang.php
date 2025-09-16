<?php echo $this->extend('Admin/Templates/Index') ?>

<?php echo $this->section('page-content'); ?>
<!-- Begin Page Content -->
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
                    <a href="/Admin/adm_inventaris">&laquo; Kembali ke daftar barang inventaris</a>
                </div>
                <div class="card-body">
                    <form action="<?php echo base_url('/Admin/add_data') ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <!-- Kategori Dropdown -->
                        <div class="form-group">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="form-control                                                                                                                                                                                                                                                                                                                                              <?php echo($validation->hasError('kategori_id')) ? 'is-invalid' : ''; ?>">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_barang as $k): ?>
                                    <option value="<?php echo $k['id'] ?>"<?php echo old('kategori_id') == $k['id'] ? 'selected' : '' ?>>
                                        <?php echo $k['nama_kategori'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?php echo $validation->getError('kategori_id'); ?></div>
                        </div>

                        <!-- Nama Barang (filtered by kategori) -->
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <select name="nama_barang" id="nama_barang"
                                class="form-control                                                                                                                                                                                                                                                                                                                                              <?php echo($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>">
                                <option value="">Pilih Nama Barang</option>
                                <!-- Akan diisi JS -->
                            </select>
                            <div class="invalid-feedback"><?php echo $validation->getError('nama_barang'); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="id_satuan">Satuan Barang</label>
                            <select name="id_satuan" class="form-control                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo($validation->hasError('id_satuan')) ? 'is-invalid' : ''; ?>">
                                <option value="">Pilih Satuan Barang</option>
                                <?php foreach ($satuan as $s): ?>
                                    <option value="<?php echo $s['satuan_id']; ?>"><?php echo $s['nama_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?php echo $validation->getError('id_satuan'); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi Barang</label>
                            <textarea name="spesifikasi" class="form-control                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo($validation->hasError('spesifikasi')) ? 'is-invalid' : ''; ?>"
                                placeholder="Masukkan spesifikasi Barang"><?php echo old('spesifikasi'); ?></textarea>
                            <div class="invalid-feedback"><?php echo $validation->getError('spesifikasi'); ?></div>
                        </div>

                        <!-- TABEL INPUT DYNAMIC ROW: LOKASI, KONDISI, JUMLAH -->
                        <div class="form-group">
                            <label>Daftar Unit (Lokasi, Kondisi, Jumlah per Ruang)</label>
                            <button type="button" id="addRowBtn" class="btn btn-success btn-sm">+ Tambah Unit/Row</button>
                            <table class="table table-bordered" id="snLokasiTable">
                                <thead>
                                    <tr>
                                        <th>Lokasi</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="lokasi[]" class="form-control">
        <option value="">Pilih Ruanganaa</option>
        <?php foreach ($daftarRuangan as $r): ?>
            <option value="<?php echo $r['id']; ?>"><?php echo $r['nama_ruangan']; ?></option>
        <?php endforeach; ?>
    </select>
                                        </td>
                                        <td>
                                            <select name="kondisi[]" class="form-control">
                                                <option value="baru">Baru</option>
                                                <option value="bekas">Bekas</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="jumlah[]" class="form-control" min="1" value="1" style="width:80px;" />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <!-- TOMBOL SIMPAN ADA DI SINI! -->
                        <button type="submit" class="btn btn-block btn-primary mt-4">Tambah Data</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>
    <script>
        $(document).ready(function() {
            $("#addRowBtn").click(function() {
                var row = `<tr>
                    <td>
                    <select name="lokasi[]" class="form-control">
        <option value="">Pilih Ruanganaa</option>
        <?php foreach ($daftarRuangan as $r): ?>
            <option value="<?php echo $r['id']; ?>"><?php echo $r['nama_ruangan']; ?></option>
        <?php endforeach; ?>
    </select>

                    </td>
                    <td>
                        <select name="kondisi[]" class="form-control">
                            <option value="baru">Baru</option>
                            <option value="bekas">Bekas</option>
                            <option value="rusak">Rusak</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="jumlah[]" class="form-control" min="1" value="1" style="width:80px;" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">-</button>
                    </td>
                </tr>`;
                $("#snLokasiTable tbody").append(row);
            });
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    <script>
        // Inject data dari PHP ke JS
        var masterBarang =                                                                                                                   <?php echo json_encode($master_barang); ?>;
        // masterBarang: [{kode_brg, nama_brg, kategori_id, nama_merk, tipe_serie, spesifikasi, jenis_brg, ...}, ...]

        function updateBarangDropdown(kategoriId) {
            let $dropdown = $('#nama_barang');
            $dropdown.html('<option value="">Pilih Nama Barang</option>');
            if (!kategoriId) return;

            // Filter barang sesuai kategori
            let filtered = masterBarang.filter(b => b.kategori_id == kategoriId);

            filtered.forEach(b => {
                let label = b.nama_brg;
                if (b.nama_merk) label += ' - ' + b.nama_merk;
                if (b.tipe_serie) label += ' / ' + b.tipe_serie;
                if (b.spesifikasi) label += ' — ' + b.spesifikasi;
                label += ' (' + (b.jenis_brg ? b.jenis_brg.toUpperCase() : '-') + ')';
                $dropdown.append(`<option value="${b.kode_brg}">${label}</option>`);
            });
        }

        $(document).ready(function() {
            $('#kategori_id').on('change', function() {
                updateBarangDropdown($(this).val());
            });

            // Restore on reload/validation fail
            <?php if (old('kategori_id')): ?>
                updateBarangDropdown('<?php echo old('kategori_id') ?>');
                <?php if (old('nama_barang')): ?>
                    $('#nama_barang').val('<?php echo old('nama_barang') ?>');
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>
    <?php echo $this->endSection(); ?>