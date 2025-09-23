<tr>
    <td><?php echo $row->id; ?></td>
    <td><?php echo $row->username; ?></td>
    <td><?php echo empty($group) ? '' : $group[0]['name']; ?></td>
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
            data-id="<?= $row->id; ?>"
            data-group="<?= (!empty($group) && isset($group[0]['group_id'])) ? $group[0]['group_id'] : ''; ?>"
            title="Ubah Grup"
            data-toggle="modal"
            data-target="#changeGroupModal">
            <i class="fas fa-tasks"></i>
        </a>
        <a href="#" class="btn btn-info btn-circle btn-detail" title="Detail"
            data-id="<?php echo $row->id; ?>"
            data-url="/Admin/detail/<?php echo $row->id; ?>">
            <i class="fa fa-info-circle"></i>
        </a>
    </td>
</tr>