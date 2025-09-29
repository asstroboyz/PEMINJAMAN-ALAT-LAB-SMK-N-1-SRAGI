<?php echo $this->extend('admin/templates/index'); ?>
<?php echo $this->section('page-content'); ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 font-weight-bold text-gray-800">Detail Peminjaman Barang</h1>

    <?php if (session()->has('success')): ?>
        <div class="alert alert-success"><?php echo session('success') ?></div>
    <?php endif ?>
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger"><?php echo session('error') ?></div>
    <?php endif ?>

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <a href="/admin/peminjaman" class="btn btn-link text-primary font-weight-bold">
                <i class="fas fa-chevron-left"></i> Kembali ke daftar peminjaman
            </a>
            <div>
                <span class="badge badge-<?php
                                            echo $header['status'] == 'approved' || $header['status'] == 'dipinjam' ? 'success'
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

                <?php elseif ($header['status'] == 'menunggu_kembali'): ?>
                    <!-- Tombol verifikasi pengembalian -->
                    <button type="button" class="btn btn-info btn-sm ml-2" onclick="showVerifikasiSwal()">
                        <i class="fas fa-undo"></i> Verifikasi Pengembalian
                    </button>

                    <!-- FORM HIDDEN UNTUK VERIFIKASI -->
                    <form id="formVerifikasi" action="/admin/approvePengembalian/<?php echo $header['peminjaman_id'] ?>" method="post" style="display:none;">
                        <?php echo csrf_field() ?>
                    </form>
                <?php endif ?>
            </div>




        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4"><b>Kode Transaksi</b></div>
                <div class="col-md-8"><?php echo esc($header['kode_transaksi']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Peminjam</b></div>
                <div class="col-md-8"><?php echo esc($header['fullname_peminjam'] ?? $header['username_peminjam']) ?></div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Pinjam</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_pinjam']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Kembali Rencana</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_kembali_rencana']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Tanggal Kembali Real</b></div>
                <div class="col-md-8"><?php echo esc($header['tanggal_kembali_real'] ?? '-') ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Ruangan Tujuan</b></div>
                <div class="col-md-8"><?php echo esc($header['ruangan_pinjam']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4"><b>Ruangan Sebelum</b></div>
                <div class="col-md-8"><?php echo esc($header['ruangan_sebelum'] ?? '-') ?></div>
            </div>
            <?php if (! empty($header['catatan'])): ?>
                <div class="row mb-2">
                    <div class="col-md-4"><b>Catatan</b></div>
                    <div class="col-md-8"><?php echo esc($header['catatan']) ?></div>
                </div>
            <?php endif ?>

            <?php if ($header['status'] == 'rejected' && ! empty($header['alasan_reject'])): ?>
                <div class="alert alert-danger mt-3">
                    <b>Alasan Ditolak:</b> <?php echo esc($header['alasan_reject']) ?>
                </div>
            <?php endif ?>

            <?php if ($header['status'] == 'dikembalikan' && ! empty($header['username_penerima_kembali'])): ?>
                <div class="alert alert-info mt-3">
                    <b>Diterima oleh :</b> <?php echo esc($header['username_penerima_kembali']) ?>
                </div>
            <?php endif ?>
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
                            <td><?php echo esc($det['kode_brg']) ?></td>
                            <td><?php echo esc($det['nama_brg']) ?></td>
                            <td><?php echo esc($det['merk']) ?></td>
                            <td><?php echo esc($det['spesifikasi']) ?></td>
                            <td><?php echo esc($det['nama_ruangan']) ?></td>
                            <td><?php echo esc($det['jumlah']) ?></td>
                            <td><?php echo esc($det['jumlah_kembali']) ?></td>
                            <td>
                                <?php if ($det['kondisi_kembali'] == 'Rusak'): ?>
                                    <span class="badge badge-danger"><?php echo esc($det['kondisi_kembali']) ?></span>
                                <?php elseif ($det['kondisi_kembali'] == 'Hilang'): ?>
                                    <span class="badge badge-warning"><?php echo esc($det['kondisi_kembali']) ?></span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?php echo esc($det['kondisi_kembali']) ?></span>
                                <?php endif ?>
                            </td>
                            <td><?php echo esc($det['detail']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="accordion" id="accordionTimeline">
        <div class="card">
            <div class="card-body">
                <button class="btn btn-primary float-right ml-2 mb-3" type="button"
                    data-toggle="collapse" data-target="#collapseTimeline"
                    aria-expanded="false" aria-controls="collapseTimeline">
                    <i class="fa fa-eye"></i> Timeline
                </button>

                <div id="collapseTimeline" class="collapse mt-3" data-parent="#accordionTimeline">
                    <h5 class="mb-4">Tracking Peminjaman Barang</h5>

                    <div class="timeline">
                        <!-- Step 1 -->
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <div class="text-muted small"><?= esc($header['tanggal_pinjam']) ?></div>
                                <div class="font-weight-bold text-primary">Peminjaman Diajukan</div>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <?php if (! empty($header['approved_at'])): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-warning"></div>
                                <div class="timeline-content">
                                    <div class="text-muted small"><?= esc($header['approved_at']) ?></div>
                                    <div class="font-weight-bold text-warning">Peminjaman Disetujui</div>
                                </div>
                            </div>
                        <?php endif ?>

                        <!-- Step 3 -->
                        <?php if (! empty($header['tanggal_kembali_real'])): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <div class="text-muted small"><?= esc($header['tanggal_kembali_real']) ?></div>
                                    <div class="font-weight-bold text-success">Peminjaman Dikembalikan</div>
                                    <div><b>Status:</b> <?= strtoupper($header['status']) ?></div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
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
                                <td><?php echo esc($row['kode_barang']) ?></td>
                                <td><?php echo esc($row['tanggal_transaksi']) ?></td>
                                <td><?php echo esc($row['jumlah_perubahan']) ?></td>
                                <td><?php echo esc($row['user_id']) ?></td>
                                <td><?php echo esc($row['informasi_tambahan']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif ?>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="modalRejectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="/admin/peminjaman/reject/<?php echo $header['peminjaman_id'] ?>">
            <?php echo csrf_field() ?>
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
    /* Timeline wrapper */
    .timeline {
        position: relative;
        margin-left: 20px;
        padding-left: 20px;
        border-left: 2px solid #dee2e6;
        /* garis vertikal */
    }

    /* Item */
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    /* Marker bulat */
    .timeline-marker {
        position: absolute;
        left: -31px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #dee2e6;
    }

    /* Konten */
    .timeline-content {
        margin-left: 10px;
    }
</style>

<?php echo $this->endSection(); ?>
<?php echo $this->section('additional-js'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showVerifikasiSwal() {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin memverifikasi pengembalian ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, verifikasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formVerifikasi').submit();
            }
        });
    }

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
            inputAttributes: {
                required: true
            },
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


<?php echo $this->endSection(); ?>