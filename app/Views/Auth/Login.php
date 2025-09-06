<?= $this->extend('Auth/Templates/Index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg my-5">
                <div class="card-body px-5 py-4">
                    <div class="text-center mb-4">
                        <!-- LOGO TKJ -->
                        <img src="<?= base_url('assets/media/qrcode/tkj.png') ?>" alt="Logo TKJ" style="width: 85px; height: 85px; object-fit:contain; border-radius:18px; box-shadow:0 2px 8px #e0e0e0;">
                        <h1 class="h4 text-primary font-weight-bold mt-3 mb-0">PEMINJAMAN ALAT LAB</h1>
                        <div class="text-gray-600 mb-2" style="font-size:14px;">SMK N 1 SRAGI - TKJ</div>
                    </div>
                    
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    
                    <form action="<?= url_to('login') ?>" method="post" class="user">
                        <?= csrf_field() ?>
                        <?php if ($config->validFields === ['email']) : ?>
                        <div class="form-group mb-3">
                            <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Email</label>
                            <input type="email"
                                class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                name="login"
                                placeholder="<?= lang('Auth.email') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="form-group mb-3">
                            <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Email / Username</label>
                            <input type="text"
                                class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                name="login"
                                placeholder="<?= lang('Auth.emailOrUsername') ?>">
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group mb-3">
                            <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Password</label>
                            <input type="password"
                                class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                name="password"
                                placeholder="<?= lang('Auth.password') ?>">
                        </div>
                        <?php if ($config->allowRemembering) : ?>
                        <div class="form-group form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="remembering" id="rememberme"
                                <?php if (old('remember')) : ?> checked <?php endif ?>>
                            <label class="form-check-label text-gray-700" for="rememberme" style="font-size:14px;">
                                <?= lang('Auth.rememberMe') ?>
                            </label>
                        </div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="letter-spacing: 1px;">
                            <i class="fa fa-sign-in-alt mr-1"></i> <?= lang('Auth.loginAction') ?>
                        </button>
                        <hr class="my-3">
                    </form>
                    <div class="d-flex justify-content-between">
                        <?php if ($config->activeResetter) : ?>
                            <a class="small" href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                        <?php endif; ?>
                        <?php if ($config->allowRegistration) : ?>
                            <a class="small" href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-center text-muted mt-2" style="font-size:13px; letter-spacing:1px;">
                &copy; <?= date('Y') ?> | <span class="text-primary font-weight-bold">SMK N 1 SRAGI - TKJ</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
