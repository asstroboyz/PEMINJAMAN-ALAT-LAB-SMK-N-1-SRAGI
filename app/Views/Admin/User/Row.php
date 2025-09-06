<tr>
    <td><?=$row->id;?></td>
    <td><?=$row->username;?></td>
    <td><?=empty($group) ? '' : $group[0]['name'];?>
    </td>
    <td><?=$row->email;?></td>

    <!-- <a href="<?=base_url('Admin/activateUser/' . $row->id . '/' . ($row->active == 1 ? 0 : 1));?>"
    class="btn btn-lg btn-circle btn-active-users" title="Klik untuk Mengaktifkan atau Menonaktifkan">
    <?=$row->active == 1 ? '<i class="fas fa-check-circle text-success fa-lg"></i>' : '<i class="fas fa-times text-danger fa-lg"></i>';?>
    </a> -->

    <td align="center">
        <a href="#" class="btn btn-warning btn-circle   btn-change-password" title="Ubah Password"
            data-id="<?=$row->id;?>" data-toggle="modal"
            data-target="#ubah_password" data-id="<?=$row->id;?>">

            <i class="fas fa-key"></i>
        </a>
        <a href="#" class="btn btn-success btn-circle  btn-change-group"
            data-id="<?=$row->id;?>" title="Ubah Grup">
            <i class="fas fa-tasks"></i>
        </a>
        <a href="#" class="btn btn-info btn-circle btn-detail" title="Detail"
            data-id="<?=$row->id;?>"
            data-url="/Admin/detail/<?=$row->id;?>">
            <i class="fa fa-info-circle"></i>
        </a>



    </td>
</tr>