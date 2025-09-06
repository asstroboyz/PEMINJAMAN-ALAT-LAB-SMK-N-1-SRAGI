<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Inventaris Barang</title>
    <style>
        header {
            margin-bottom: 20px;
            position: relative;
        }

        header img {
            max-width: 80px;
            /* Adjusted max-width */
            max-height: 80px;
            /* Adjusted max-height */
            position: absolute;
            top: 0;
            left: 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-left: 15px;
            /* Adjusted margin */
        }

        .col-md-4 {
            width: 30%;
            float: left;
            padding: 0 5px;
        }

        .item {
            width: 100%;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 2px solid #000;
            padding: 10px;
            font-size: smaller;
            /* Adjusted font size */
        }

        header div {
            text-align: center;
            margin-left: 100px;
            /* Adjusted left margin */
        }

        footer {
            text-align: right;
            margin-top: 50px;
            font-size: smaller;
            /* Adjusted font size */
        }

        footer p {
            text-align: right;
            margin-bottom: 5px;
            /* Adjusted margin */
        }

        footer div {
            text-align: right;
            border-top: 1px solid #000;
            padding-top: 5px;
            /* Adjusted padding */
            margin-top: 5px;
            /* Adjusted margin */
            font-size: smaller;
            /* Adjusted font size */
        }

        img {
            max-width: 100%;
            /* Ensures images don't overflow their containers */
            height: auto;
            /* Maintains aspect ratio */
        }
    </style>
</head>

<body>

    <header>
        <img src="img/logo.png" width="10%" height="10%" alt="Logo BPS Kota A">
        <div>
            <h2>BPS Kota Pekalongan</h2>
            <p>Laporan QR CODE Barang Inventaris</p>
        </div>
    </header>
    <hr style="color: black;">

    <div class="row text-center">
        <?php foreach ($inventaris as $row) : ?>
        <div class="col-md-4 mx-auto">
            <div class="item">
                <p><?= $row['kode_barang']; ?>
                    &nbsp;&nbsp;

                    <?= $row['merk']; ?> -
                    <?= $row['tipe_barang']; ?>
                </p>

                <img src="<?= $row['file']; ?>"
                    alt="Image">
            </div>
        </div>
        <?php endforeach; ?>
    </div>



    <footer>
        <div>
            <p>Pekalongan,
                <?php echo date("d/m/Y"); ?>
            </p>
            <br> <br>
            <p>Avia Dwi Susanti</p>
            <br>
            <br>
        </div>
    </footer>

</body>

</html>