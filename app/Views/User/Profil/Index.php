<?= $this->extend('User/Templates/Index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <?php if (session()->getFlashdata('error-msg')): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible show fade" role="alert">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">&times;</button>
                        <b><i class="fa fa-check"></i></b>
                        <?= session()->getFlashdata('error-msg'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('msg')): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">&times;</button>
                        <b><i class="fa fa-check"></i></b>
                        <?= session()->getFlashdata('msg'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

   <div class="row">
    <div class="col-lg">
        <div class="card shadow px-5 py-4">
            <div class="row">
                <!-- FOTO PROFIL -->
                <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                    <img class="card-img-top rounded p-2"
                        src="<?= empty($user->foto) ? '/sbassets/img/undraw_profile.svg' : '/uploads/profile/' . $user->foto; ?>"
                        alt="Image profile" height="290">
                </div>

                <!-- DATA PROFIL -->
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item">
                            <span class="badge badge-info text-capitalize">
                                <?= $role ?>
                            </span>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-user mr-2"></i>
                            <?= esc($user->fullname ?? user()->username) ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-envelope mr-2"></i>
                            <?= esc($user->email ?? '-') ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-calendar mr-2"></i>
                            Terdaftar sejak
                            <?= date('d F Y H:i:s', strtotime($user->created_at)) ?>
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-chart-bar mr-2"></i>
                            Jumlah Peminjaman Barang:
                            <strong><?= $peminjaman->total ?? 0 ?></strong> total
                            (<span class="text-success"><?= $peminjaman->aktif ?? 0 ?></span> aktif,
                            <span class="text-secondary"><?= $peminjaman->selesai ?? 0 ?></span> selesai)
                        </li>
                    </ul>

                    <!-- TOMBOL AKSI -->
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button data-toggle="modal" data-target="#edit-profile"
                                class="btn btn-success btn-block">
                                <i class="fas fa-user-edit"></i> Ubah Profil
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button data-toggle="modal" data-target="#edit-password"
                                class="btn btn-primary btn-block">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR PEMINJAMAN TERAKHIR -->
    <?php if (!empty($riwayat)): ?>
    <div class="col-lg-12 mt-4">
        <div class="card shadow-sm p-3">
            <h5 class="mb-3"><i class="fa fa-history mr-2"></i> Riwayat Peminjaman Terbaru</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?= esc($r->kode_peminjaman) ?></td>
                            <td><?= date('d M Y', strtotime($r->tanggal_pinjam)) ?></td>
                            <td>
                                <?php if ($r->status == 'dipinjam'): ?>
                                    <span class="badge badge-success">Dipinjam</span>
                                <?php elseif ($r->status == 'selesai'): ?>
                                    <span class="badge badge-secondary">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-warning"><?= ucfirst($r->status) ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>


    <div class="modal fade" id="edit-profile" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form
                    action="/User/simpanProfile/<?= $user->id; ?>"
                    method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" id="userid">
                        <div class="form-group">
                            <label for="foto">Foto Profil</label>
                            <input type="file" name="foto" id="foto" class="form-control p-1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                value="<?= $user->username ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= $user->email ?>">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-simpan">Simpan data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-password" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white">Update Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form
                    action="/User/updatePassword/<?= user()->id ?>"
                    method="post">
                    <div class="modal-body">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group">
                            <label for="passwordLama">Password Lama no</label>
                            <input type="password" name="passwordLama" id="passwordLama" class="form-control "
                                placeholder="Masukkan password saat ini" autocomplete="false">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="passwordBaru">Password Baru</label>
                            <input type="password" name="passwordBaru" id="passwordBaru" class="form-control"
                                placeholder="Masukkan password baru" autocomplete="false">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="konfirm">Konfirmasi Password</label>
                            <input type="password" name="konfirm" id="konfirm" class="form-control"
                                placeholder="Konfirmasi password baru" autocomplete="false">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-simpan">Simpan data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $.validator.addMethod("metodku", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Username must contain only letters, numbers, or dashes.");

        $.validator.addMethod("valueNotEquals", function(value, element, arg) {
            return arg !== value;
        }, "This field is required.");

        $("#formUser").validate({
            rules: {
                nama: {
                    required: true,
                    minlength: 3,
                    metodku: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    metodku: true
                },
                role: {
                    required: true,
                    valueNotEquals: "default"
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
        });
    });
</script>

<?= $this->endSection(); ?>