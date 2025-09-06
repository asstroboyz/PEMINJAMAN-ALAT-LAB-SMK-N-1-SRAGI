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
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <select name="nama_barang" id="nama_barang" class="form-control <?php echo ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>">
                                <option value="">Pilih Nama Barang</option>
                                <?php foreach ($master_barang as $barang): ?>
                                    <option value="<?php echo $barang['kode_brg']; ?>">
                                        <?php echo $barang['nama_brg']; ?> (<?php echo ucfirst($barang['jenis_brg']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?php echo $validation->getError('nama_barang'); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="id_satuan">Satuan Barang</label>
                            <select name="id_satuan" class="form-control <?php echo ($validation->hasError('id_satuan')) ? 'is-invalid' : ''; ?>">
                                <option value="">Pilih Satuan Barang</option>
                                <?php foreach ($satuan as $s): ?>
                                    <option value="<?php echo $s['satuan_id']; ?>"><?php echo $s['nama_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?php echo $validation->getError('id_satuan'); ?></div>
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi Barang</label>
                            <textarea name="spesifikasi" class="form-control <?php echo ($validation->hasError('spesifikasi')) ? 'is-invalid' : ''; ?>"
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
                                                <option value="">Pilih Ruangan</option>
                                                <option value="Lab">Lab</option>
                                                <option value="Gudang">Gudang</option>
                                                <option value="Kelas A">Kelas A</option>
                                                <option value="Kelas B">Kelas B</option>
                                                <option value="Server">Server</option>
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
                        <option value="">Pilih Ruangan</option>
                        <option value="Lab">Lab</option>
                        <option value="Gudang">Gudang</option>
                        <option value="Kelas A">Kelas A</option>
                        <option value="Kelas B">Kelas B</option>
                        <option value="Server">Server</option>
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

<?php echo $this->endSection(); ?>
