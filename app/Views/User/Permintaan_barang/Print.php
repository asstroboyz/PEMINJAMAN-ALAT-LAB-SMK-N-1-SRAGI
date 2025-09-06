<html>

<body>
    <center>
        <h2 style="margin-top:50px;">
            Data Permintaan Barang
        </h2>

    </center>
    <table border="1" width="100%">
        <thead>
            <tr>

                <th scope="col">Kode Barang </th>
                <th scope="col">Nama Pengaju</th>
                <th scope="col">Perihal</th>
                <th scope="col">Tanggal Pengajuan</th>
                <th scope="col">Tanggal Di proses</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($permintaan_barang as $dt): ?>
                <tr>

                    <td style="text-align: left;"><?=$dt->kode_barang?></td>
                    <td style="text-align: left;"><?=$dt->nama_pengaju?></td>
                    <td style="text-align: left;"><?=$dt->perihal?></td>
                    <td style="text-align: left;"><?=$dt->tanggal_pengajuan?></td>
                    <td style="text-align: left;"><?=$dt->tanggal_selesai?></td>
                    <td style="text-align: left;"><?=$dt->status_akhir?></td>


                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</body>

</html>