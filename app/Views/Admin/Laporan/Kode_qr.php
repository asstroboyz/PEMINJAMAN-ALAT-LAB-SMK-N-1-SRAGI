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
        max-width: 100px;
        max-height: 100px;
        position: absolute;
        top: 0;
        left: 0;
    }

    header div {
        text-align: center;
        margin-left: 120px;
        /* Adjust left margin to prevent overlap with the logo */
    }

    .items-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        /* Set to flex-start to align items to the start of the container */
    }

    .item {
        width: 30%;
        /* Set to 30% to allow for some margin between items */
        margin: 0 2% 20px 0;
        box-sizing: border-box;
    }

    .item img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
        margin-bottom: 10px;
    }

    footer {
        text-align: right;
        margin-top: 50px;
    }

    footer p {
        text-align: right;
        margin-bottom: 10px;
    }

    footer div {
        text-align: right;
        border-top: 1px solid #000;
        padding-top: 10px;
        margin-top: 10px;
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

    <div class="items-container" style="display: flex;">

        <div class="item" style="text-align: center; outline: 2px solid #000; padding: 10px;">
            <p><?= $inventaris['kode_barang']; ?></p>
            <img src="<?= $inventaris['file']; ?>" alt="Image">
        </div>

    </div>



    <footer>
        <div>
            <p>Pekalongan,
                <?php echo date("d/m/Y"); ?>
            </p>
            <br> <br>
            <p>Avia Dwi Susanti</p>
        </div>
    </footer>

</body>

</html>