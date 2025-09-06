<!-- app/Views/admin/hasil_pdf.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cetak Data PDF</title>
    <!-- Tambahkan stylesheet atau styling sesuai kebutuhan -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Data Permintaan Barang</h2>

    <table>
        <thead>
            <tr>
                <th>ID User</th>
                <th>Kode Barang</th>
                <th>ID Balasan Permintaan</th>
                <th>Nama Pengaju</th>
                <th>Perihal</th>
                <th>Detail</th>
                <th>Tanggal Pengajuan</th>
                <th>Tanggal Diproses</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Status Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($permintaan as $row): ?>
                <tr>
                    <td><?=$row['id_user'];?></td>
                    <td><?=$row['kode_barang'];?></td>
                    <td><?=$row['id_balasan_permintaan'];?></td>
                    <td><?=$row['nama_pengaju'];?></td>
                    <td><?=$row['perihal'];?></td>
                    <td><?=$row['detail'];?></td>
                    <td><?=$row['tanggal_pengajuan'];?></td>
                    <td><?=$row['tanggal_diproses'];?></td>
                    <td><?=$row['tanggal_selesai'];?></td>
                    <td><?=$row['status'];?></td>
                    <td><?=$row['status_akhir'];?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

</body>
</html>
