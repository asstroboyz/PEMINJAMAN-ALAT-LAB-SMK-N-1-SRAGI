<html>

<body>
    <center>
        <h2 style="margin-top:50px;">
            Data Pengadaan Barang BPS
        </h2>
        <!-- <p style="margin-top:-10px;">
            Polda Jawa TEngah
        </p> -->
    </center>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Barang </th>
                <th scope="col">Jumlah</th>
                <th scope="col">Tahun Periode Pengadaan</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;?>
            <?php foreach ($pengadaan as $dt): ?>
                <tr>
                    <td scope="row" style="text-align: left;"><?=$i++;?></td>

                    <td style="text-align: left;"><?=$dt->nama_barang?></td>
                    <td style="text-align: left;"><?=$dt->jumlah?></td>
                    <td style="text-align: left;"><?=$dt->tahun_periode?></td>
                    <td style="text-align: left;"><?=$dt->status?></td>



                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</body>

</html>