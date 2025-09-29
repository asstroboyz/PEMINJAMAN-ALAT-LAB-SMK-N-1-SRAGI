<tr>
    <td><?= $no ?></td>
    <td><?php echo $row->username; ?></td>
    <!-- <td><?php echo empty($group) ? '' : $group[0]['name']; ?></td> -->
    <td><?php echo $row->email; ?></td>
    <td align="center">
        <a href="#" class="btn btn-warning btn-circle btn-change-password"
            title="Ubah Password"
            data-id="<?php echo $row->id; ?>"
            data-toggle="modal"
            data-target="#ubah_password">
            <i class="fas fa-key"></i>
        </a>
        <a href="#" class="btn btn-success btn-circle btn-change-group"
            data-id="<?php echo $row->id;?>"
            data-group="<?php echo (! empty($group) && isset($group[0]['group_id'])) ? $group[0]['group_id'] : '';?>"
            title="Ubah Grup"
            data-toggle="modal"
            data-target="#changeGroupModal">
            <i class="fas fa-tasks"></i>
        </a>
     <a href="#"
   class="btn btn-info btn-circle btn-detail"
   data-id="<?= $row->id ?>"
   data-url="/admin/detailAjax/<?= $row->id ?>">
   <i class="fa fa-info-circle"></i>
</a>


    </td>
</tr>


<script>
document.addEventListener("DOMContentLoaded", function () {
    // Tangkap klik tombol detail
    document.querySelectorAll(".btn-detail").forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            let id       = this.dataset.id;
            let username = this.dataset.username;
            let email    = this.dataset.email;
            let role     = this.dataset.role;

            Swal.fire({
                title: 'Detail User',
                html: `
                    <table class="table table-bordered text-left">
                        <tr><th>ID</th><td>${id}</td></tr>
                        <tr><th>Username</th><td>${username}</td></tr>
                        <tr><th>Email</th><td>${email}</td></tr>
                        <tr><th>Role</th><td>${role}</td></tr>
                    </table>
                `,
                icon: 'info',
                confirmButtonText: 'Tutup'
            });
        });
    });
});
</script>
