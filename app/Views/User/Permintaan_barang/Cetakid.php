<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Detail</title>
</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <table align="center">
            <tr>
                <td width="100">
                </td>
                <td width="400">
                    <center>
                        <font size="3">CETAK DATA PENGADUAN</font><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
        </table>
        <br>
        <center>
            <font size="4"><b>Detail Pengaduan</b></font><br>
        </center>
        <br>
        <table align="center">
            <tr>
                <td width="120">Id</td>
                <td width="180">: <b>
                        <?=$detail['id'];?>
                    </b></td>
                <td rowspan="9" width="200">
                </td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <?=$detail['nama_pengaju'];?></td>
            </tr>
            <tr>
                <td>Status Pengaduan</td>
                <td>: <?=$detail['status_akhir'];?></td>
            </tr>
            <tr>
                <td>Tanggal Pengaduan</td>
                <td>: <?=$detail['tanggal_pengajuan'];?></td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: <?=$detail['perihal'];?></td>
            </tr>
            <tr>
                <td>Rincian</td>
                <td>: <?=$detail['detail'];?></td>
            </tr>
        </table>
        <br>
        <table align="center">
            <tr>
                <td width="500">
                    <hr>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>