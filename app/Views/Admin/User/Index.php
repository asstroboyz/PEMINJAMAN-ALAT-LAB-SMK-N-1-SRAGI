<?= $this->extend('Admin/Templates/Index') ?>

<?= $this->section('page-content') ?>

<style>
    /* ====== MODAL TAMBAH USER ====== */
    #tambahUserModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
        font-family: "Inter", system-ui, sans-serif;
    }

    #tambahUserModal .modal-header {
        padding: 14px 20px;
        background: linear-gradient(90deg, #6f42c1, #8b5cf6);
        border-bottom: none;
    }

    #tambahUserModal .modal-title {
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.3px;
        color: #fff;
    }

    #tambahUserModal .modal-body {
        padding: 28px 32px;
        background-color: #fafafa;
    }

    #tambahUserModal .form-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #444;
    }

    #tambahUserModal input.form-control,
    #tambahUserModal input[type="file"] {
        font-size: 0.9rem;
        border-radius: 6px;
        border: 1px solid #ccc;
        transition: all 0.2s ease;
    }

    #tambahUserModal input.form-control:focus {
        border-color: #8b5cf6;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.25);
    }

    #tambahUserModal small.text-muted {
        font-size: 0.8rem;
    }

    /* ====== RADIO TOGGLE (Jenis Akun) ====== */
    #tambahUserModal .btn-group {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    #tambahUserModal .btn-check {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    #tambahUserModal .btn-group label {
        border-radius: 8px !important;
        padding: 6px 18px;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 2px solid #ddd;
        transition: all 0.25s ease;
        cursor: pointer;
    }

    /* Hover effect */
    #tambahUserModal .btn-group label:hover {
        border-color: #8b5cf6;
        color: #8b5cf6;
        background-color: #f6f1ff;
    }

    /* Active state - Guru/Admin */
    #tambahUserModal .btn-check:checked+.btn-outline-primary {
        background-color: #6f42c1;
        color: #fff;
        border-color: #6f42c1;
        box-shadow: 0 2px 5px rgba(111, 66, 193, 0.4);
    }

    /* Active state - Siswa */
    #tambahUserModal .btn-check:checked+.btn-outline-success {
        background-color: #16a34a;
        color: #fff;
        border-color: #16a34a;
        box-shadow: 0 2px 5px rgba(22, 163, 74, 0.3);
    }

    /* ====== BUTTON BAWAH ====== */
    #tambahUserModal .modal-footer,
    #tambahUserModal .text-end {
        padding-top: 20px;
        margin-top: 10px;
        border-top: 1px solid #e5e5e5;
    }

    #tambahUserModal .btn {
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.25s ease;
    }

    #tambahUserModal .btn-secondary {
        background-color: #6c757d;
        border: none;
    }

    #tambahUserModal .btn-secondary:hover {
        background-color: #5c636a;
    }

    #tambahUserModal .btn-primary {
        background-color: #6f42c1;
        border: none;
    }

    #tambahUserModal .btn-primary:hover {
        background-color: #5a32a3;
        box-shadow: 0 3px 6px rgba(111, 66, 193, 0.35);
    }

    /* ====== RESPONSIVE ====== */
    @media (max-width: 576px) {
        #tambahUserModal .modal-body {
            padding: 20px;
        }

        #tambahUserModal .btn-group label {
            font-size: 0.85rem;
            padding: 5px 12px;
        }

        #tambahUserModal input.form-control {
            font-size: 0.85rem;
        }
    }

    #dataTable {
        border-radius: 12px;
        overflow: hidden;
        font-family: "Inter", sans-serif;
    }

    #dataTable th {
        background-color: #f8f9fc;
        font-weight: 600;
        color: #444;
        font-size: 0.9rem;
    }

    #dataTable td {
        font-size: 0.88rem;
        vertical-align: middle !important;
    }

    /* ====== HOVER EFFECT ====== */
    .hover-row:hover {
        background-color: #f5f3ff !important;
        transition: 0.2s;
    }

    /* ====== USER CELL ====== */
    .user-cell {
        padding: 10px 15px !important;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 0 0 2px #fff, 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .user-text {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .user-name {
        font-weight: 600;
        color: #222;
    }

    .user-role-text {
        font-size: 0.8rem;
        color: #888;
    }

    /* ====== ROLE BADGES ====== */
    .badge-role {
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 8px;
    }

    .role-siswa {
        background-color: #16a34a;
        color: #fff;
    }

    .role-guru {
        background-color: #4338ca;
        color: #fff;
    }

    /* ====== ACTION BUTTONS ====== */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 6px 8px;
        color: #fff;
        font-size: 0.85rem;
        transition: all 0.25s ease;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-warning {
        background-color: #fbbf24 !important;
    }

    .btn-success {
        background-color: #10b981 !important;
    }

    .btn-info {
        background-color: #3b82f6 !important;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .user-avatar {
            width: 32px;
            height: 32px;
        }

        .user-name {
            font-size: 0.85rem;
        }
    }
    /* ====== USER CELL STYLING ====== */
.user-cell {
  padding: 12px 18px !important;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  object-fit: cover;
  flex-shrink: 0;
  box-shadow: 0 0 0 2px #fff, 0 0 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.user-avatar:hover {
  transform: scale(1.08);
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
}

.user-text {
  line-height: 1.2;
}

.user-name {
  font-weight: 600;
  color: #222;
  font-size: 0.95rem;
}

.user-subtext {
  font-size: 0.82rem;
  color: #6b7280;
}

/* ====== RESPONSIVE ====== */
@media (max-width: 768px) {
  .user-avatar {
    width: 36px;
    height: 36px;
  }

  .user-name {
    font-size: 0.9rem;
  }

  .user-subtext {
    font-size: 0.78rem;
  }
}

</style>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        <h3>Daftar Pengguna</h3>
                        <a href="#" class="btn btn-primary"
                            data-id="<?= $row->id; ?>"
                            data-toggle="modal" data-target="#tambahUserModal">
                            <i class="fas fa-plus"> Tambah</i>
                        </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="5%">No</th>
                                    <th class="text-start">Nama Lengkap</th>
                                    <th width="15%">Role</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>

                            <tfoot class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                foreach ($users as $rw) {
                                    $row = "row" . $rw->id;
                                    echo $$row;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>




            </div>
        </div>

    </div>

</section>

<!-- <div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="tambahUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user"
                    action="<?= url_to('register') ?>"
                    method="post"
                    enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <div class="form-group">
                        <input type="text" class="form-control form-control-user"
                            name="fullname"
                            placeholder="Nama Lengkap"
                            value="<?= old('fullname') ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control form-control-user"
                            name="username"
                            placeholder="Username"
                            value="<?= old('username') ?>">
                    </div>

                  
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user"
                            name="email"
                            placeholder="Email"
                            value="<?= old('email') ?>">
                    </div>

                 
                    <div class="form-group">
                        <label for="foto" class="small">Foto Profil</label>
                        <input type="file" class="form-control-file"
                            name="foto" id="foto">
                    </div>

               
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user"
                                name="password"
                                placeholder="Password"
                                autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="pass_confirm"
                                class="form-control form-control-user"
                                placeholder="Repeat Password"
                                autocomplete="off">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark btn-user btn-block">
                        Tambah User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-gradient text-white" style="background: linear-gradient(90deg,#6f42c1,#8b5cf6);">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-plus me-2"></i> Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data" id="formTambahUser">
                    <?= csrf_field() ?>

                    <!-- PILIH JENIS USER -->
                    <div class="mb-3 text-center">
                        <label class="fw-semibold d-block mb-2">Jenis Akun</label>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="is_siswa" id="userGuru" value="0" checked>
                            <label class="btn btn-outline-primary" for="userGuru"><i class="fa fa-user-tie me-1"></i> Guru / Admin</label>

                            <input type="radio" class="btn-check" name="is_siswa" id="userSiswa" value="1">
                            <label class="btn btn-outline-success" for="userSiswa"><i class="fa fa-user-graduate me-1"></i> Siswa</label>
                        </div>
                    </div>

                    <hr>

                    <!-- USERNAME -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <small class="text-muted">(opsional)</small></label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                        </div>

                        <!-- NAMA LENGKAP -->
                        <div class="col-md-6 siswa-only" style="display:none;">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap">
                        </div>

                        <!-- NISN (khusus siswa) -->
                        <div class="col-md-6 siswa-only" style="display:none;">
                            <label class="form-label fw-semibold">NIS</label>
                            <input type="text" name="nisn" maxlength="6" pattern="\d{6}" class="form-control" placeholder="6 digit NIS">
                        </div>

                        <!-- FOTO PROFIL -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="form-control">
                            <small class="text-muted">JPG/PNG max 2MB</small>
                        </div>

                        <!-- PASSWORD -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" maxlength="6" pattern="\d{6}" class="form-control" placeholder="6 digit angka" required>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ulangi Password</label>
                            <input type="password" name="pass_confirm" maxlength="6" pattern="\d{6}" class="form-control" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i> Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Ubah Grup -->
<form action="<?= base_url(); ?>/Admin/changeGroup" method="post">
    <?= csrf_field() ?>
    <div class="modal fade" id="changeGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Grup</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group-item p-3">
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-8pt mb-md-0">
                                <div class="media align-items-left">
                                    <div class="d-flex flex-column media-body media-middle">
                                        <span class="card-title">Grup</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">

                                <select name="group" class="form-control" data-toggle="select">
                                    <?php foreach ($groups as $row) { ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                                    <?php } ?>
                                </select>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>


<form action="<?= site_url('Admin/changePassword') ?>" method="post">

    <?= csrf_field() ?>
    <div class="modal fade" id="ubah_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group-item p-3">
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-8pt mb-md-0">
                                <div class="media align-items-left">
                                    <div class="d-flex flex-column media-body media-middle">
                                        <span class="card-title">username</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">
                                <input type="text" class="form-control" id="username" name="username" readonly>
                                <input hidden type="text" class="form-control" value="" id="user_id" name="user_id">
                            </div>
                        </div>
                        <br>
                        <div class="row align-items-start">
                            <div class="col-md-4 mb-8pt mb-md-0">
                                <div class="media align-items-left">
                                    <div class="d-flex flex-column media-body media-middle">
                                        <span class="card-title">Password Baru</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-8pt mb-md-0">
                                <input type="password" class="form-control" name="password_baru">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php if (session()->getFlashdata('message')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('message'); ?>',
            showConfirmButton: false,
            timer: 2500
        })
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error'); ?>',
            showConfirmButton: true
        })
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Validasi Gagal',
            html: `
            <ul style="text-align:left;">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach ?>
            </ul>
        `,
        })
    </script>
<?php endif; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const radioGuru = document.getElementById('userGuru');
        const radioSiswa = document.getElementById('userSiswa');
        const siswaFields = document.querySelectorAll('.siswa-only');

        function toggleFields() {
            const isSiswa = radioSiswa.checked;
            siswaFields.forEach(f => f.style.display = isSiswa ? 'block' : 'none');
        }

        radioGuru.addEventListener('change', toggleFields);
        radioSiswa.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
<?= $this->endSection() ?>