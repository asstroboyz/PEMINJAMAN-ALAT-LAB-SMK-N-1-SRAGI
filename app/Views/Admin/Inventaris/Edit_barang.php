<?php echo $this->extend('Admin/Templates/Index')?>


<?php echo $this->section('page-content');?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Form Edit Data Barang Inventaris</h1>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <?php echo session()->getFlashdata('msg');?>
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
                    <form
                        action="/Admin/update/<?php echo $inventaris['kode_barang'];?>  "
                        method="post" enctype="multipart/form-data">
                        <?php echo csrf_field();?>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group ">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input name="kode_barang" type="text"
                                        class="form-control form-control-user <?php echo ($validation->hasError('kode_barang')) ? 'is-invalid' : '';?>"
                                        id="input-kode_barang"
                                        value="<?php echo $inventaris['kode_barang'];?>"
                                        readonly />
                                    <div id="kode_barangFeedback" class="invalid-feedback">
                                        <?php echo $validation->getError('kode_barang');?>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label for="nama_barang">Nama Barang</label>
                                   <select name="nama_barang"
    class="form-control form-control-user <?php echo ($validation->hasError('nama_barang')) ? 'is-invalid' : '';?>"
    id="input-nama_barang">
    <option value="">Pilih Nama Barang</option>
    <?php foreach ($master_barang as $b): ?>
        <option
            value="<?php echo $b['kode_brg'];?>"
            <?php echo ($b['kode_brg'] == $inventaris['id_master_barang']) ? 'selected' : '';?>>
            <?php echo $b['nama_brg'];?> (<?php echo $b['jenis_brg'];?>)
        </option>
    <?php endforeach; ?>
</select>

                                    <div id="nama_barangFeedback" class="invalid-feedback">
                                        <?php echo $validation->getError('nama_barang');?>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label for="id_satuan">satuan Barang</label>
                                    <select name="id_satuan"
                                        class="form-control form-control-user <?php echo ($validation->hasError('id_satuan')) ? 'is-invalid' : '';?>"
                                        id="input-id_satuan">
                                        <option value="">Pilih Satuan Barang</option>
                                        <?php
                                        foreach ($satuan as $s): ?>
                                        <option
                                            value="<?php echo $s['satuan_id'];?>"
                                            <?php echo ($s['satuan_id'] == $inventaris['id_satuan']) ? 'selected' : '';?>>
                                            <?php echo $s['nama_satuan'];?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="id_satuanFeedback" class="invalid-feedback">
                                        <?php echo $validation->getError('id_satuan');?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">

                                <div class="form-group ">
                                    <label for="spesifikasi">Spesifikasi Barang</label>
                                    <textarea name="spesifikasi" type="text"
                                        class="form-control form-control-user <?php echo ($validation->hasError('spesifikasi')) ? 'is-invalid' : '';?>"
                                        id="input-spesifikasi"><?php echo $inventaris['spesifikasi'];?></textarea>
                                    <div id="spesifikasiFeedback" class="invalid-feedback">
                                        <?php echo $validation->getError('spesifikasi');?>
                                    </div>
                                </div>


                           
                            <div class="form-group ">
                                <label for="kondisi">Kondisi Barang</label>
                                <input name="kondisi" type="text"
                                    class="form-control form-control-user <?php echo ($validation->hasError('kondisi')) ? 'is-invalid' : '';?>"
                                    id="input-kondisi"
                                    value="<?php echo $inventaris['kondisi'];?>" />
                                <div id="kondisiFeedback" class="invalid-feedback">
                                    <?php echo $validation->getError('kondisi');?>
                                </div>
                            </div>
                           

                            <div class="form-group ">
                                <label for="tgl_perolehan">Ruangan</label>
                                <select name="lokasi"
                                    class="form-control form-control-user <?php echo ($validation->hasError('lokasi')) ? 'is-invalid' : '';?>"
                                    id="input-lokasi">
                                    <option value="">Pilih Ruangan</option>
                                    <option value="Staf Umum" <?php echo ($inventaris['lokasi'] == 'Staf Umum') ? 'selected' : '';?>>Staf
                                        Umum
                                    </option>
                                    <option value="LPDSS" <?php echo ($inventaris['lokasi'] == 'LPDSS') ? 'selected' : '';?>>LPDSS
                                    </option>
                                    <option value="Produksi" <?php echo ($inventaris['lokasi'] == 'Produksi') ? 'selected' : '';?>>Produksi
                                    </option>
                                    <option value="Kepela" <?php echo ($inventaris['lokasi'] == 'Kepela') ? 'selected' : '';?>>Kepela
                                    </option>
                                    <option value="PST" <?php echo ($inventaris['lokasi'] == 'PST') ? 'selected' : '';?>>
                                        PST</option>
                                    <option value="Lobby" <?php echo ($inventaris['lokasi'] == 'Lobby') ? 'selected' : '';?>>Lobby
                                    </option>
                                    <option value="Gudang" <?php echo ($inventaris['lokasi'] == 'Gudang') ? 'selected' : '';?>>Gudang
                                    </option>
                                    <option value="Dapur" <?php echo ($inventaris['lokasi'] == 'Dapur') ? 'selected' : '';?>>Dapur
                                    </option>
                                    <option value="Mushola" <?php echo ($inventaris['lokasi'] == 'Mushola') ? 'selected' : '';?>>Mushola
                                    </option>
                                </select>
                                <div id="lokasiFeedback" class="invalid-feedback">
                                    <?php echo $validation->getError('lokasi');?>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-block btn-warning">Update Data</button>
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>

<?php echo $this->endSection('page-content');?>
<?php echo $this->section('additional-js');?>
<script>
    $(document).ready(function() {

        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    });
</script>

<?php echo $this->endSection();?>