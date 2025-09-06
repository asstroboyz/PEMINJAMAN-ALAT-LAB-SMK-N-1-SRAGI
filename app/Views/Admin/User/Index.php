<?= $this->extend('Admin/Templates/Index') ?>

<?=$this->section('page-content')?>

<?=view('Myth\Auth\Views\_message_block')?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <a href="/admin/tambah_user" class="btn btn-primary " data-id="<?=$row->id;?>"
                        title="tambah data">
                        <i class="fas fa-plus"> Tambah</i>
                        </a> -->
                        <h3>Daftar Pengguna</h3>
                        <a href="#" class="btn btn-primary"
                            data-id="<?=$row->id;?>"
                            data-toggle="modal" data-target="#tambahUserModal">
                            <i class="fas fa-plus"> Tambah</i>
                        </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr style="text-align:center;">
                                    <th>Id User66666666666666</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <!-- activasi user berfungsi hanya saja di nonaktifkan -->
                                    <!-- <th>Active User</th> -->
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <!-- <th>Active User</th> -->
                                    <th>Opsi</th>
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

<div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="tambahUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi modal (formulir tambah user) -->
                <form class="user"
                    action="<?=url_to('register')?>"
                    method="post">
                    <?=csrf_field()?>
                    <!-- Isian formulir tambah user -->
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" name="username" placeholder="Username"
                            value="<?=old('username')?>">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" name="email" placeholder="Email"
                            value="<?=old('email')?>">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" name="password"
                                placeholder="Password" autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="pass_confirm" class="form-control form-control-user"
                                placeholder="Repeat Password" autocomplete="off">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark btn-user btn-block">
                        Tambah User
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Ubah Grup -->
<form action="<?=base_url();?>/Admin/changeGroup" method="post">
    <?=csrf_field()?>
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
                                    <?php
foreach ($groups as $key => $row) {
    ?>
                                    <option value="<?=$row->id;?>">
                                        <?=$row->name;?>
                                    </option>
                                    <?php
}
?>
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


<form action="<?=base_url();?>Admin/changePassword" method="post">
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

<?=$this->endSection()?>