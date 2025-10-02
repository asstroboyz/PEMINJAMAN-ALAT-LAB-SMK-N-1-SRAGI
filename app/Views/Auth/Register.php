<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 my-5 rounded-3">
                <div class="card-body px-5 py-4">
                    <div class="text-center mb-4">
                        <!-- LOGO -->
                        <img src="<?= base_url('assets/media/qrcode/tkj.png') ?>" 
                             alt="Logo TKJ" 
                             style="width: 80px; height: 80px; object-fit:contain; border-radius:16px; box-shadow:0 2px 8px #e0e0e0;">
                        <h1 class="h4 text-primary fw-bold mt-3 mb-1"><?= lang('Auth.register') ?></h1>
                        <div class="text-muted" style="font-size:14px;">SMK N 1 SRAGI - TKJ</div>
                    </div>

                    <?= view('Myth\Auth\Views\_message_block') ?>

                    <form class="user" action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- USERNAME -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   name="username" 
                                   placeholder="Masukkan username"
                                   value="<?= old('username') ?>" 
                                   required>
                        </div>

                        <!-- EMAIL OPSIONAL -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email <small class="text-muted">(opsional)</small></label>
                            <input type="email" 
                                   class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                                   name="email" 
                                   placeholder="Masukkan email (opsional)"
                                   value="<?= old('email') ?>">
                        </div>

                        <!-- FOTO -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto Profil</label>
                            <input type="file" 
                                   class="form-control <?= session('errors.foto') ? 'is-invalid' : '' ?>" 
                                   name="foto" 
                                   accept="image/*">
                            <small class="text-muted">Format: JPG, PNG. Max 2MB.</small>
                        </div>

                        <!-- ROLE -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipe User <span class="text-danger">*</span></label>
                            <select name="is_siswa" id="is_siswa" class="form-control" required>
                                <option value="0" <?= old('is_siswa') == '0' ? 'selected' : '' ?>>Guru / Admin</option>
                                <option value="1" <?= old('is_siswa') == '1' ? 'selected' : '' ?>>Siswa</option>
                            </select>
                        </div>

                        <!-- SISWA FIELDS -->
                        <div class="siswa-field" style="display:none;">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" 
                                       name="fullname" 
                                       class="form-control <?= session('errors.fullname') ? 'is-invalid' : '' ?>" 
                                       placeholder="Masukkan nama lengkap"
                                       value="<?= old('fullname') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NISN</label>
                                <input type="text"
                                       name="nisn"
                                       class="form-control <?= session('errors.nisn') ? 'is-invalid' : '' ?>"
                                       placeholder="Masukkan NISN (10 digit)"
                                       value="<?= old('nisn') ?>"
                                       maxlength="10"
                                       pattern="\d{10}"
                                       title="NISN harus 10 digit angka">
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                                       placeholder="Password (6 digit angka)"
                                       maxlength="6"
                                       pattern="\d{6}"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- PASSWORD CONFIRM -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ulangi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password"
                                       name="pass_confirm"
                                       id="pass_confirm"
                                       class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>"
                                       placeholder="Ulangi password"
                                       maxlength="6"
                                       pattern="\d{6}"
                                       required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassConfirm">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- SUBMIT -->
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="fa fa-user-plus me-2"></i> Daftar
                        </button>

                        <hr class="my-3">
                    </form>

                    <div class="text-center">
                        <a class="small" href="<?= url_to('login') ?>">
                            <?= lang('Auth.alreadyRegistered') ?> <?= lang('Auth.signIn') ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center text-muted mt-2" style="font-size:13px;">
                &copy; <?= date('Y') ?> | <span class="text-primary fw-bold">SMK N 1 SRAGI - TKJ</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const roleSelect = document.getElementById('is_siswa');
        const siswaFields = document.querySelector('.siswa-field');

        function toggleFields() {
            siswaFields.style.display = roleSelect.value === "1" ? "block" : "none";
        }

        roleSelect.addEventListener('change', toggleFields);
        toggleFields();

        // Toggle password
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", function() {
            const type = password.type === "password" ? "text" : "password";
            password.type = type;
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });

        const togglePassConfirm = document.querySelector("#togglePassConfirm");
        const passConfirm = document.querySelector("#pass_confirm");
        togglePassConfirm.addEventListener("click", function() {
            const type = passConfirm.type === "password" ? "text" : "password";
            passConfirm.type = type;
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });
    });
</script>

<?= $this->endSection(); ?>
