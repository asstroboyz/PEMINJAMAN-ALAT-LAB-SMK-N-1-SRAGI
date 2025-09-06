<?= $this->extend('Pegawai/Templates/Index') ?>

<?= $this->section('page-content'); ?>
<!-- Index.html file -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>QR Code Scanner / Reader
    </title>
    <style>
        /* style.css file*/

        .section {
            background-color: #ffffff;
            padding: 50px 30px;
            border: 1.5px solid #b2b2b2;
            border-radius: 0.25em;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
        }

        #my-qr-reader {
            padding: 20px !important;
            border: 1.5px solid #b2b2b2 !important;
            border-radius: 8px;
        }

        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }

        #my-qr-reader img[alt="Camera based scan"] {
            width: 100px !important;
            height: 100px !important;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

        #html5-qrcode-anchor-scan-type-change {
            text-decoration: none !important;
            color: #1d9bf0;
        }

        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }
    </style>
</head>

<body>
    <div class="row mx-2">
        <div class="col-6">
            <h1>Scan QR Codes</h1>
            <div class="section">
                <div id="my-qr-reader">
                </div>
            </div>
        </div>
        <div class="col-6">
            <h1>Result</h1>
            <div class="section">
                <div id="qr-result">
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/html5-qrcode">
    </script>
    <script>
        // script.js file
        const result = document.getElementById("qr-result");

        function domReady(fn) {
            if (
                document.readyState === "complete" ||
                document.readyState === "interactive"
            ) {
                setTimeout(fn, 1000);
            } else {
                document.addEventListener("DOMContentLoaded", fn);
            }
        }

        domReady(function() {

            // If found you qr code
            function onScanSuccess(decodeText, decodeResult) {
                textContent = decodeText;
                result.innerHTML = "";
                const p = document.createElement("p");
                p.append(textContent);
                result.append(p);
                // button clear
                const button = document.createElement("button");
                button.innerHTML = "Clear";
                button.onclick = () => {
                    result.innerHTML = "";
                };
                result.append(button);

            }

            let htmlscanner = new Html5QrcodeScanner(
                "my-qr-reader", {
                    fps: 10,
                    qrbos: 250
                }
            );
            htmlscanner.render(onScanSuccess);
        });
    </script>
</body>

</html>

<?= $this->endSection('page-content'); ?>