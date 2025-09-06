<?= $this->extend('pegawai/templates/index'); ?>


<?= $this->section('page-content'); ?>


<div class="container-fluid">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('error-msg')) : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible show fade" role="alert">

                    <div class="alert-body">
                        <button class="close" data-dismiss>x</button>
                        <b><i class="fa fa-check"></i></b>
                        <?= session()->getFlashdata('error-msg'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('msg')) : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible show fade" role="alert">

                    <div class="alert-body">
                        <button class="close" data-dismiss>x</button>
                        <b><i class="fa fa-check"></i></b>
                        <?= session()->getFlashdata('msg'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Page Heading -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow px-5 py-4">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <img class="card-img-top p-2"
                                src="<?= base_url('/img/' . user()->foto); ?>"
                                alt="Image profile" height="290">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span class="badge badge-info">
                                        <?= $role; ?></span></li>
                                <li class="list-group-item "><i
                                        class="fa fa-user mr-2 "></i><?= user()->username; ?>
                                </li>
                                <li class="list-group-item"><i class="fa fa-envelope mr-1"></i>
                                    <?= $user->email ?></li>
                                <li class="list-group-item"><i class="fa fa-calendar mr-1"></i> terdaftar sejak.
                                    <?php $date = date_create($user->created_at);
echo (date_format($date, "d F Y H:i:s")) ?>
                                </li>
                                <li class="list-group-item"><i class="fa fa-chart-bar mr-1"></i> Jumlah Permintaan
                                    Barang : <?= $semua ?> </li>
                            </ul>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button data-toggle="modal" data-target="#edit-profile" type="button"
                                        class="d-inline btn btn-success btn-block edit-password" data-id="<"><i
                                            class="fas fa-key"></i> Ubah Profile</button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <button data-toggle="modal" data-target="#edit-password" type="button"
                                        class="d-inline btn btn-primary btn-block edit-password" data-id="<"><i
                                            class="fas fa-key"></i> Ubah Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  -->
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
                        action="/user/simpanProfile/<?= $user->id; ?>"
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
                            <!-- <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password untuk konfirmasi perubahan" autocomplete="false">
                            <div class="invalid-feedback"></div>
                        </div> -->
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
                        action="/user/updatePassword/<?= user()->id ?>"
                        method="post">
                        <div class="modal-body">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" id="user_id">
                            <div class="form-group">
                                <label for="passwordLama">Password Lama no</label>
                                <input type="password" name="passwordLama" id="passwordLama" class="form-control "
                                    placeholder="Masukkan password saat ini" autocomplete="false">
                                <div class="invalid-feedback">

                                </div>
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