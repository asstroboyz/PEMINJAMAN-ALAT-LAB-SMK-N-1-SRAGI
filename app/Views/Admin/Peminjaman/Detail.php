<?php echo $this->extend('admin/templates/index');?>
<?php echo $this->section('page-content');?>

<div class="container-fluid">
    <h1 class="h3 mb-4 font-weight-bold text-gray-800">Detail Peminjaman Barang</h1>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success"><?php echo session('success')?></div>
    <?php endif?>
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?php echo session('error')?></div>
    <?php endif?>

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <a href="/admin/peminjaman" class="btn btn-link text-primary font-weight-bold">
                <i class="fas fa-chevron-left"></i> Kembali ke daftar peminjaman
            </a>
          <div>
    <span class="badge badge-<?php
        echo $header['status'] == 'approved' ? 'success'
            : ($header['status'] == 'rejected' ? 'danger'
            : ($header['status'] == 'dikembalikan' ? 'info' : 'warning'));
    ?> p-2">
        <?php echo strtoupper($header['status']) ?>
    </span>
    <?php if ($header['status'] == 'pengajuan'): ?>
        <div class="dropdown d-inline ml-2">
            <button class="btn btn-warning btn-sm dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                Pilih Aksi
            </button>
            <ul class="dropdown-menu">
                <li>
                    <button type="button" class="dropdown-item" onclick="showApproveSwal()">
                        <i class="fas fa-check text-success"></i> Approve
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item text-danger" onclick="showRejectSwal()">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </li>
            </ul>
        </div>
        <!-- FORM HIDDEN UNTUK APPROVE -->
        <form id="formApprove" action="/admin/approve/<?php echo $header['peminjaman_id'] ?>" method="post" style="display:none;">
            <?php echo csrf_field() ?>
        </form>
        <!-- FORM HIDDEN UNTUK REJECT -->
        <form id="formReject" action="/admin/reject/<?php echo $header['peminjaman_id'] ?>" method="post" style="display:none;">
            <?php echo csrf_field() ?>
            <input type="hidden" name="alasan_reject" id="alasanRejectInput">
        </form>
    <?php endif ?>
</div>



        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4"><b>Kode Transaksi</b></div>
                <div class="col-md-8"><?php echo esc($header['kode_transaksi'])?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Peminjam</b></div>
                <div class="col-md-8"><?php echo esc($header['fullname'] ?? $header['username'])?></div>
            </div>
            
            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Pinjam</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_pinjam'])?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Kembali Rencana</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_kembali_rencana'])?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Kembali Real</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_kembali_real'] ?? '-')?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Ruangan Tujuan</b></div>
                <div class="col-md-8"><?php echo esc($header['ruangan_pinjam'])?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Ruangan Sebelum</b></div>
                <div class="col-md-8"><?php echo esc($header['ruangan_sebelum'] ?? '-')?></div>
            </div>
            <?php if (! empty($header['catatan'])): ?>
                <div class="row mb-2">
                    <div class="col-md-4"><b>Catatan</b></div>
                    <div class="col-md-8"><?php echo esc($header['catatan'])?></div>
                </div>
            <?php endif?>

            <?php if ($header['status'] == 'rejected' && ! empty($header['alasan_reject'])): ?>
                <div class="alert alert-danger mt-3">
                    <b>Alasan Ditolak:</b> <?php echo esc($header['alasan_reject'])?>
                </div>
            <?php endif?>

            <?php if ($header['status'] == 'dikembalikan' && ! empty($header['user_penerima_kembali'])): ?>
                <div class="alert alert-info mt-3">
                    <b>Diterima oleh User ID:</b> <?php echo esc($header['user_penerima_kembali'])?>
                </div>
            <?php endif?>
        </div>
    </div>

    <!-- Detail Barang -->
    <div class="card shadow mb-4">
        <div class="card-header"><b>Daftar Barang yang Dipinjam</b></div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Merk</th>
                        <th>Spesifikasi</th>
                        <th>Ruangan</th>
                        <th>Jumlah Pinjam</th>
                        <th>Jumlah Kembali</th>
                        <th>Kondisi Kembali</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $det): ?>
                        <tr>
                            <td><?php echo esc($det['kode_barang'])?></td>
                            <td><?php echo esc($det['nama_brg'])?></td>
                            <td><?php echo esc($det['merk'])?></td>
                            <td><?php echo esc($det['spesifikasi'])?></td>
                            <td><?php echo esc($det['nama_ruangan'])?></td>
                            <td><?php echo esc($det['jumlah'])?></td>
                            <td><?php echo esc($det['jumlah_kembali'])?></td>
                            <td>
                                <?php if ($det['kondisi_kembali'] == 'Rusak'): ?>
                                    <span class="badge badge-danger"><?php echo esc($det['kondisi_kembali'])?></span>
                                <?php elseif ($det['kondisi_kembali'] == 'Hilang'): ?>
                                    <span class="badge badge-warning"><?php echo esc($det['kondisi_kembali'])?></span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?php echo esc($det['kondisi_kembali'])?></span>
                                <?php endif?>
                            </td>
                            <td><?php echo esc($det['detail'])?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Timeline Button & Accordion -->
    <div class="mb-3">
        <button class="btn btn-primary float-right ml-2 mb-2" type="button" data-toggle="collapse"
            data-target="#collapseTimeline" aria-expanded="false" aria-controls="collapseTimeline">
            <i class="fa fa-eye"></i> Timeline
        </button>
    </div>
    <div class="accordion" id="accordionTimeline">
        <div>
            <div id="collapseTimeline" class="collapse" aria-labelledby="headingTimeline" data-parent="#accordionTimeline">
                <div class="card card-body">
                    <h5 class="mb-3">Tracking Peminjaman Barang</h5>
                    <ul class="timeline">
                        <li>
                            <div class="font-weight-bold text-primary"><?php echo esc($header['tanggal_pinjam'])?></div>
                            <span>Peminjaman Diajukan</span>
                        </li>
                        <?php if (! empty($header['approved_at'])): ?>
                            <li>
                                <div class="font-weight-bold text-warning"><?php echo esc($header['approved_at'])?></div>
                                <span>Peminjaman Disetujui</span>
                            </li>
                        <?php endif?>
                        <?php if (! empty($header['tanggal_kembali_real'])): ?>
                            <li>
                                <div class="font-weight-bold text-success"><?php echo esc($header['tanggal_kembali_real'])?></div>
                                <span>Peminjaman Dikembalikan</span><br>
                                <b>Status:</b> <?php echo strtoupper($header['status'])?>
                            </li>
                        <?php endif?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <!-- Optional: History Mutasi -->
    <?php if (! empty($mutasi)): ?>
        <div class="card shadow mb-4">
            <div class="card-header"><b>History Mutasi Pengembalian</b></div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>User</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mutasi as $row): ?>
                            <tr>
                                <td><?php echo esc($row['kode_barang'])?></td>
                                <td><?php echo esc($row['tanggal_transaksi'])?></td>
                                <td><?php echo esc($row['jumlah_perubahan'])?></td>
                                <td><?php echo esc($row['user_id'])?></td>
                                <td><?php echo esc($row['informasi_tambahan'])?></td>
                            </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif?>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="/admin/peminjaman/reject/<?php echo $header['peminjaman_id']?>">
            <?php echo csrf_field()?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRejectLabel">Alasan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alasan_reject">Alasan</label>
                        <textarea name="alasan_reject" class="form-control" required rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .timeline {
        list-style: none;
        padding-left: 1.2em;
        border-left: 2px solid #c2c2c2;
    }

    .timeline li {
        margin-bottom: 0.7em;
        position: relative;
    }

    .timeline li::before {
        content: '';
        position: absolute;
        left: -14px;
        top: 2px;
        width: 10px;
        height: 10px;
        background: #3b82f6;
        border-radius: 50%;
        border: 2px solid #fff;
    }
</style>

<?php echo $this->endSection();?>
<?php echo $this->section('additional-js');?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showApproveSwal() {
    Swal.fire({
        title: 'Setujui peminjaman?',
        text: "Pastikan data sudah benar.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formApprove').submit();
        }
    });
}

function showRejectSwal() {
    Swal.fire({
        title: 'Tolak Peminjaman',
        input: 'textarea',
        inputLabel: 'Alasan penolakan',
        inputPlaceholder: 'Tulis alasan penolakan...',
        inputAttributes: { required: true },
        showCancelButton: true,
        confirmButtonText: 'Tolak',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value) return 'Alasan wajib diisi!';
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            document.getElementById('alasanRejectInput').value = result.value;
            document.getElementById('formReject').submit();
        }
    });
}
</script>


<?php echo $this->endSection();?>