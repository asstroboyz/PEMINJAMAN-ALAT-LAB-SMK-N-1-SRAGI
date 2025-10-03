<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-8 col-lg-6">

   
            <div class="card shadow-lg border-0 my-5 rounded-3">
                <div class="card-body px-5 py-4">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('assets/media/qrcode/tkj.png') ?>" 
                             alt="Logo TKJ" 
                             style="width: 80px; height: 80px; object-fit:contain; border-radius:16px; box-shadow:0 2px 8px #e0e0e0;">
                        <h1 class="h4 text-primary fw-bold mt-3 mb-1"><?= lang('Auth.registerGuru') ?></h1>
                        <div class="text-muted" style="font-size:14px;">SMK N 1 SRAGI - TKJ</div>
                    </div>

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="is_siswa" value="0">

                        <!-- USERNAME -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   name="username" value="<?= old('username') ?>" required>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email (opsional)</label>
                            <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                   name="email" value="<?= old('email') ?>">
                        </div>

                        <!-- FOTO -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                                   name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" maxlength="6" pattern="\d{6}" 
                                   class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" required>
                        </div>

                        <!-- PASSWORD CONFIRM -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ulangi Password</label>
                            <input type="password" name="pass_confirm" maxlength="6" pattern="\d{6}" 
                                   class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="fa fa-user-plus me-2"></i> Daftar
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="<?= url_to('login') ?>">Sudah punya akun? Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
