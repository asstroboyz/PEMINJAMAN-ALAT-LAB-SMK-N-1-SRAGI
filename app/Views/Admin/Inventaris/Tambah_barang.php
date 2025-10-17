<?php echo $this->extend('Admin/Templates/Index') ?>
<?php echo $this->section('page-content'); ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-900">Form Tambah Inventaris</h1>
    <?php if (session()->getFlashdata('msg')): ?>
        <div class="alert alert-success"><?php echo session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <div class="card shadow">
        <div class="card-header">
            <a href="/Admin/adm_inventaris">&laquo; Kembali ke daftar barang inventaris</a>
        </div>
        <div class="card-body">
            <form action="<?php echo base_url('/Admin/add_data') ?>" method="post">
                <?php echo csrf_field(); ?>
                <!-- Nama Barang (ambil dari master) -->
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <select name="nama_barang" class="form-control                                                                   <?php echo $validation->hasError('nama_barang') ? 'is-invalid' : '' ?>">
                        <option value="">Pilih Nama Barang</option>
                        <?php foreach ($master_barang as $b): ?>
                            <option value="<?php echo $b['kode_brg'] ?>"<?php echo old('nama_barang') == $b['kode_brg'] ? 'selected' : '' ?>>
                                <?php echo $b['nama_brg'] ?> (<?php echo $b['kode_brg'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo $validation->getError('nama_barang') ?></div>
                </div>
                <!-- Satuan -->
                <div class="form-group">
                    <label for="id_satuan">Satuan</label>
                    <select name="id_satuan" class="form-control                                                                 <?php echo $validation->hasError('id_satuan') ? 'is-invalid' : '' ?>">
                        <option value="">Pilih Satuan</option>
                        <?php foreach ($satuan as $s): ?>
                            <option value="<?php echo $s['satuan_id'] ?>"<?php echo old('id_satuan') == $s['satuan_id'] ? 'selected' : '' ?>>
                                <?php echo $s['nama_satuan'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback"><?php echo $validation->getError('id_satuan') ?></div>
                </div>
                <!-- Spesifikasi -->
                <div class="form-group">
                    <label for="spesifikasi">Spesifikasi</label>
                    <input type="text" name="spesifikasi" class="form-control                                                                              <?php echo $validation->hasError('spesifikasi') ? 'is-invalid' : '' ?>" value="<?php echo old('spesifikasi') ?>" />
                    <div class="invalid-feedback"><?php echo $validation->getError('spesifikasi') ?></div>
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
                                    <select name="lokasi[]" class="form-control" disabled>
                    <option value="1" selected>ICT</option>
                </select>
                <input type="hidden" name="lokasi[]" value="1" />
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
<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>
<script>
$(document).ready(function() {
    $("#addRowBtn").click(function() {
        var row = `<tr>
            <td>
                <select name="lokasi[]" class="form-control" disabled>
                    <option value="1" selected>ICT</option>
                </select>
                <input type="hidden" name="lokasi[]" value="1" />
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
<?php echo $this->endSection(); ?>
