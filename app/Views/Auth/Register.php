<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="col-md-7 col-lg-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body px-5 py-4">
                    <div class="text-center mb-4">
                        <!-- LOGO TKJ -->
                        <img src="<?= base_url('assets/media/qrcode/tkj.png') ?>" alt="Logo TKJ" style="width: 80px; height: 80px; object-fit:contain; border-radius:16px; box-shadow:0 2px 8px #e0e0e0;">
                        <h1 class="h4 text-primary font-weight-bold mt-3 mb-1"><?= lang('Auth.register') ?></h1>
                        <div class="text-gray-600" style="font-size:14px;">SMK N 1 SRAGI - TKJ</div>
                    </div>
                    <?= view('Myth\Auth\Views\_message_block') ?>
                    <form class="user" action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="form-group mb-3">
                            <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Username</label>
                            <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Email</label>
                            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Password</label>
                                <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label text-gray-700" style="font-weight:600; font-size:15px;">Ulangi Password</label>
                                <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block font-weight-bold" style="letter-spacing: 1px;">
                            <i class="fa fa-user-plus mr-1"></i> <?= lang('Auth.register') ?>
                        </button>
                        <hr class="my-3">
                    </form>
                    <div class="text-center">
                        <a class="small" href="<?= url_to('login') ?>"><?= lang('Auth.alreadyRegistered') ?> <?= lang('Auth.signIn') ?></a>
                    </div>
                </div>
            </div>
            <div class="text-center text-muted mt-2" style="font-size:13px;">
                &copy; <?= date('Y') ?> | <span class="text-primary font-weight-bold">SMK N 1 SRAGI - TKJ</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
