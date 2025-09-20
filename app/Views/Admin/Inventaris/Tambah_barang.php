<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Inventaris</h1>
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <div class="card shadow">
        <div class="card-header">
            <a href="/Admin/adm_inventaris">&laquo; Kembali ke daftar barang inventaris</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/Admin/add_data') ?>" method="post">
                <?= csrf_field(); ?>
                <!-- Nama Barang (ambil dari master) -->
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <select name="nama_barang" class="form-control <?= $validation->hasError('nama_barang') ? 'is-invalid' : '' ?>">
                        <option value="">Pilih Nama Barang</option>
                        <?php foreach ($master_barang as $b): ?>
                            <option value="<?= $b['kode_brg'] ?>" <?= old('nama_barang') == $b['kode_brg'] ? 'selected' : '' ?>>
                                <?= $b['nama_brg'] ?> (<?= $b['kode_brg'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= $validation->getError('nama_barang') ?></div>
                </div>
                <!-- Satuan -->
                <div class="form-group">
                    <label for="id_satuan">Satuan</label>
                    <select name="id_satuan" class="form-control <?= $validation->hasError('id_satuan') ? 'is-invalid' : '' ?>">
                        <option value="">Pilih Satuan</option>
                        <?php foreach ($satuan as $s): ?>
                            <option value="<?= $s['satuan_id'] ?>" <?= old('id_satuan') == $s['satuan_id'] ? 'selected' : '' ?>>
                                <?= $s['nama_satuan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?= $validation->getError('id_satuan') ?></div>
                </div>
                <!-- Spesifikasi -->
                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi</label>
                    <input type="text" name="spesifikasi" class="form-control <?= $validation->hasError('spesifikasi') ? 'is-invalid' : '' ?>" value="<?= old('spesifikasi') ?>" />
                    <div class="invalid-feedback"><?= $validation->getError('spesifikasi') ?></div>
                </div>

                <!-- Dynamic Row: lokasi, kondisi, jumlah -->
                <div class="form-group">
                    <label>Unit Inventaris (lokasi, kondisi, jumlah)</label>
                    <button type="button" id="addRowBtn" class="btn btn-success btn-sm ml-2">+ Tambah Row</button>
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
                                        <option value="">Pilih Ruangan</option>
                                        <?php foreach ($daftarRuangan as $r): ?>
                                            <option value="<?= $r['id'] ?>"><?= $r['nama_ruangan'] ?></option>
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
                <button type="submit" class="btn btn-block btn-primary mt-4">Tambah Data</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('additional-js'); ?>
<script>
$(document).ready(function() {
    $("#addRowBtn").click(function() {
        var row = `<tr>
            <td>
                <select name="lokasi[]" class="form-control">
                    <option value="">Pilih Ruangan</option>
                    <?php foreach ($daftarRuangan as $r): ?>
                        <option value="<?= $r['id'] ?>"><?= $r['nama_ruangan'] ?></option>
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
<?= $this->endSection(); ?>
