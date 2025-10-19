<tr class="align-middle text-center">
    <td><?= $no ?></td>
  <td class="text-start fw-semibold user-cell">
  <div class="d-flex align-items-center gap-2 user-info">
    <?php if (!empty($row->foto)): ?>
      <img src="<?= base_url('uploads/profile/' . esc($row->foto)) ?>"
           alt="<?= esc($row->username) ?>"
           class="user-avatar">
    <?php else: ?>
      <img src="<?= base_url('uploads/profil.svg') ?>"
           alt="default"
           class="user-avatar">
    <?php endif; ?>

    <div class="user-text">
      <div class="user-name"><?= esc($row->fullname ?: $row->username) ?></div> 
    </div>
  </div>
</td>


    <td>
        <span class="badge <?= $row->is_siswa ? 'bg-success' : 'bg-primary' ?>">
            <?= $row->is_siswa ? 'Siswa' : 'Guru/Admin' ?>
        </span>
    </td>

    <td>
        <div class="btn-group" role="group">
            <!-- Ubah Password -->
            <a href="#" class="btn btn-sm btn-warning"
               title="Ubah Password"
               data-id="<?= $row->id; ?>"
               data-toggle="modal"
               data-target="#ubah_password">
                <i class="fas fa-key"></i>
            </a>

     
            <a href="#" class="btn btn-sm btn-success"
               title="Ubah Grup"
               data-id="<?= $row->id; ?>"
               data-group="<?= (!empty($group) && isset($group[0]['group_id'])) ? $group[0]['group_id'] : ''; ?>"
               data-toggle="modal"
               data-target="#changeGroupModal">
                <i class="fas fa-tasks"></i>
            </a>

            <!-- Detail -->
            <a href="#" class="btn btn-sm btn-info btn-detail"
               data-id="<?= $row->id ?>"
               data-username="<?= esc($row->username) ?>"
               data-fullname="<?= esc($row->fullname ?: '-') ?>"
               data-role="<?= $row->is_siswa ? 'Siswa' : 'Guru/Admin' ?>">
               <i class="fa fa-info-circle"></i>
            </a>
        </div>
    </td>
</tr>

<script>
document.querySelectorAll(".btn-detail").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Detail User',
            html: `
                <table class="table table-bordered text-start">
                    <tr><th>ID</th><td>${this.dataset.id}</td></tr>
                    <tr><th>Username</th><td>${this.dataset.username}</td></tr>
                    <tr><th>Nama Lengkap</th><td>${this.dataset.fullname}</td></tr>
                    <tr><th>Role</th><td>${this.dataset.role}</td></tr>
                </table>
            `,
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    });
});
</script>
