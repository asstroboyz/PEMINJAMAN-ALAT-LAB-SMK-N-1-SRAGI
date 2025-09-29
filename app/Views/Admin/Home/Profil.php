<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content') ?>

<style>
    .modal-content {
        border-radius: 1rem;
        border: none;
        animation: fadeInScale 0.3s ease-in-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>
<div class="container-fluid py-5">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100">
        <div class="row no-gutters">

      <div class="col-md-3 bg-secondary d-flex flex-column align-items-center justify-content-center p-5 text-white">

                <div class="profile-img mb-3">
                    <img src="<?= empty($user->foto) ? '/sbassets/img/undraw_profile.svg' : '/uploads/profile/' . $user->foto; ?>"
                        alt="Foto Profil"
                        class="img-fluid rounded-circle shadow"
                        style="width:200px;height:200px;object-fit:cover;">
                </div>
                <span class="badge badge-pill badge-primary px-3 py-2 mb-3" style="font-size:14px;">
                    <?= $role; ?>
                </span>
                <h4 class="mb-1 font-weight-bold text-white"><?= $user->username; ?></h4>
                <small class="text-white"><?= $user->email; ?></small>
            </div>

            <!-- Bagian Kanan (Informasi Akun) -->
            <div class="col-md-9 bg-white p-5">
                <h2 class="mb-4 text-dark font-weight-bold">Informasi Akun</h2>

                <p><i class="fas fa-user text-primary mr-2"></i>
                    <strong>Username:</strong> <?= $user->username; ?>
                </p>
                <p><i class="fas fa-envelope text-success mr-2"></i>
                    <strong>Email:</strong> <?= $user->email; ?>
                </p>
                <p><i class="fas fa-calendar-alt text-warning mr-2"></i>
                    <strong>Terdaftar sejak:</strong> <?= date("d F Y H:i:s", strtotime($user->created_at)) ?>
                </p>

                <!-- Tombol dipindah ke bawah -->
                <!-- Tombol yang benar -->
                <div class="mt-4">
                    <button data-toggle="modal" data-target="#modalProfile"
                        class="btn btn-success btn-lg rounded-pill px-4 mr-3">
                        <i class="fas fa-user-edit"></i> Ubah Profil
                    </button>
                    <button data-toggle="modal" data-target="#modalPassword"
                        class="btn btn-primary btn-lg rounded-pill px-4">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </div>

            </div>


        </div>
    </div>
</div>
<div class="modal fade" id="modalProfile" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update Profile</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="/Admin/simpanProfile/<?= $user->id; ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" id="userid">

                    <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control p-1">
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?= $user->username ?>" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $user->email ?>" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Update Password</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="/Admin/updatePassword/<?= user()->id ?>" method="post">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" id="user_id">

                    <div class="form-group">
                        <label for="passwordLama">Password Lama</label>
                        <input type="password" name="passwordLama" id="passwordLama" class="form-control" placeholder="Masukkan password lama">
                    </div>

                    <div class="form-group">
                        <label for="passwordBaru">Password Baru</label>
                        <input type="password" name="passwordBaru" id="passwordBaru" class="form-control" placeholder="Masukkan password baru">
                    </div>

                    <div class="form-group">
                        <label for="konfirm">Konfirmasi Password</label>
                        <input type="password" name="konfirm" id="konfirm" class="form-control" placeholder="Konfirmasi password baru">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>