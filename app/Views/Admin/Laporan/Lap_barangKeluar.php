<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Inventaris</title>
    <style>
        body {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .custom-table th,
        .custom-table td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            /* Adjust the padding as needed */
        }

        .custom-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        .hr-custom {
            height: 2px;
            background-color: #000;
            width: 100%;
            margin: 10px 0;
        }

        footer {
            text-align: right;
            margin-top: 10px;
        }

        footer p {
            text-align: right;
            margin-bottom: 5px;
        }

        footer div {
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <table style="width: 100%;">
            <tr>
                <td class="logo-container">
                    <img src="img/logo.png" width="10%" height="10%" alt="Logo BPS Kota A">
                </td>
                <td style="text-align: center;">
                    <div class="header-content">
                        <h3 class="kop" style="font-size: 25px; font-weight: bold; margin: 0; width: fit-content;">
                            Badan Pusat Statistik <br> Kota Pekalongan
                        </h3>
                        <br>
                        <p class="kop" style="font-size: 16px; margin: 0;">
                            Jl. Singosari, Podosugih, Kec. Pekalongan Barat, Kota Pekalongan, Jawa Tengah 51111

                        </p>
                        <p class="kop" style="font-size: 16px; margin: 0;">

                        </p>
                    </div>

                </td>
            </tr>
        </table>




        <!-- Horizontal line with adjusted width -->
        <hr class="hr-custom">

        <!-- Content Section -->
        <br>
        <div style="text-align: left;">
            <p>
                <span style="width: 200px; display: inline-block;">JENIS LAPORAN :</span>
                DAFTAR BARANG ATK KELUAR BADAN PUSAT STATISTIK KOTA PEKALONGAN
            </p>

            <p style="margin-bottom: 20px;">
                <span style="width: 200px; display: inline-block;">Periode :</span>
                <?= strftime('%d-%m-%Y', strtotime($tanggalMulai)); ?>
                Sampai Dengan
                <?= strftime('%d-%m-%Y', strtotime($tanggalAkhir)); ?>
            </p>
        </div>

        <!-- Table with dynamic content -->
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>

                    <th>Nama Barang</th>
                    <th>Merk Barang</th>
                    <th>Jumlah Barang Keluar</th>
                    <th>Satuan Barang Keluar</th>
                    <th>Tanggal Barang Keluar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atkKeluar as $num => $row) : ?>
                    <tr>
                        <td><?= $num + 1; ?></td>

                        <td><?= $row['nama_brg']; ?>(<?= $row['tipe_barang']; ?>)
                        </td>
                        <td><?= $row['merk']; ?>
                        </td>
                        <td><?= $row['jumlah_perubahan']; ?>
                        </td>
                        <td><?= $row['nama_satuan']; ?>
                        </td>
                        <td><?= date("d-m-Y", strtotime($row['tanggal_barang_keluar'])); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- End of Table -->

        <!-- Horizontal line for separation -->

        <!-- Footer -->
        <footer style="position: fixed; bottom: 0; width: 100%;">
            <div style="text-align: center;">
                <br><br>
                <p>Dibuat oleh: &nbsp; &nbsp; </p>
                <br>
                <!-- Adjust the margin-left property -->
                <p style="margin-bottom: 10;">
                    &nbsp; &nbsp; <?= user()->fullname; ?>
                </p>
            </div>
        </footer>



    </div>
</body>

</html>