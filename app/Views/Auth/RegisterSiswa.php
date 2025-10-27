<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 600px; width:100%;">
        <div class="card-body p-5">

         
            <div class="text-center mb-4">
                <img src="<?= base_url('assets/media/qrcode/tkj.png') ?>" alt="Logo TKJ"
                    class="rounded-3 " style="width: 80px; height: 80px; object-fit: contain;">
                <h1 class="h4 text-primary fw-bold mt-3"><?= lang('Auth.registerSiswa') ?></h1>
                <p class="text-muted mb-0">SMK N 1 SRAGI - TKJ</p>
            </div>

            <?= view('Myth\Auth\Views\_message_block') ?>

    
            <form action="<?= url_to('register') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="is_siswa" value="1">
                <input type="hidden" id="croppedData" name="croppedData">

           
                <div class="text-center mb-4">
                    <div id="avatar-crop" style="width:200px; height:200px; margin:0 auto;"></div>
                    <input type="file" id="foto" name="foto" class="d-none" accept="image/*">

                  
                    <button type="button" id="applyAvatar" class="btn btn-sm btn-success mt-2" style="display:none;">
                        Apply Avatar
                    </button>

                    <small class="text-muted d-block mt-2">
                        Klik avatar untuk upload (JPG/PNG, Max 2MB)
                    </small>
                </div>

                <div class="row g-3">
                    <!-- USERNAME -->
                    <div class="col-md-6">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                            value="<?= old('username') ?>" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6">
                        <label class="form-label">Email <small class="text-muted">(opsional)</small></label>
                        <input type="email" name="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                            value="<?= old('email') ?>">
                    </div>

                    <!-- FULLNAME -->
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control <?= session('errors.fullname') ? 'is-invalid' : '' ?>"
                            value="<?= old('fullname') ?>">
                    </div>

                    <!-- NISN -->
                    <div class="col-md-6">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" maxlength="6" pattern="\d{6}"
                            class="form-control <?= session('errors.nisn') ? 'is-invalid' : '' ?>"
                            value="<?= old('nisn') ?>">
                    </div>

                    <!-- PASSWORD -->
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                maxlength="6" pattern="\d{6}" required
                                class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="col-md-6">
                        <label class="form-label">Ulangi Password</label>
                        <div class="input-group">
                            <input type="password" id="pass_confirm" name="pass_confirm"
                                maxlength="6" pattern="\d{6}" required
                                class="form-control <?= session('errors.pass_confirm') ? 'is-invalid' : '' ?>">
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="pass_confirm">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fa fa-user-plus me-2"></i> Daftar
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="<?= url_to('login') ?>">Sudah punya akun? Masuk</a>
            </div>
        </div>
    </div>
</div>

<!-- Croppie -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    let croppieInstance = null;
    let isCroppieActive = false;

    function setPreview(url) {
        // isi ulang avatar-crop dengan img statis
        document.getElementById('avatar-crop').innerHTML =
            `<img src="${url}" 
              class="rounded-circle shadow-sm" 
              style="width:120px; height:120px; object-fit:cover;">`;
        croppieInstance = null;
        isCroppieActive = false;
        document.getElementById('applyAvatar').style.display = 'none';
    }

    // awal load → pakai profil.svg
    document.addEventListener("DOMContentLoaded", function() {
        setPreview("<?= base_url('uploads/profil.svg') ?>");
    });

    // klik avatar → cuma buka file explorer kalau lagi preview
    document.getElementById('avatar-crop').addEventListener('click', () => {
        if (!isCroppieActive) {
            document.getElementById('foto').click();
        }
    });

    // kalau pilih foto baru
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(ev) {
            // isi avatar-crop dengan div kosong untuk croppie
            document.getElementById('avatar-crop').innerHTML =
                `<div id="crop-container" style="width:120px; height:120px;"></div>`;

            croppieInstance = new Croppie(document.getElementById('crop-container'), {
                viewport: {
                    width: 120,
                    height: 120,
                    type: 'circle'
                },
                boundary: {
                    width: 120,
                    height: 120
                },
                enableZoom: true,
                showZoomer: true
            });

            croppieInstance.bind({
                url: ev.target.result
            });

            document.getElementById('applyAvatar').style.display = 'inline-block';
            isCroppieActive = true;
        };
        reader.readAsDataURL(file);
    });

    // apply avatar
    document.getElementById('applyAvatar').addEventListener('click', async () => {
        if (!croppieInstance) return;

        const dataUrl = await croppieInstance.result({
            type: 'base64',
            size: {
                width: 300,
                height: 300
            },
            format: 'png',
            circle: true
        });

        setPreview(dataUrl); 
        document.getElementById('croppedData').value = dataUrl;
    });

    // toggle password
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('i');
            if (target.type === "password") {
                target.type = "text";
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                target.type = "password";
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
</script>

<?= $this->endSection(); ?>