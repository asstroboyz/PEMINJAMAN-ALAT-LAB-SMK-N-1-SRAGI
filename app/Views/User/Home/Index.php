<?= $this->extend('User/Templates/Index') ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">

        <!-- Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="text-xs font-weight-bold text-black text-uppercase mb-2">
                        Hari Ini
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-black">
                        <?= $tanggalEcho = format_tanggal(date('Y-m-d')); ?>
                    </div>
                    <div class="mt-3">
                        <!-- JAM ANALOG -->
                        <div class="clock">
                            <div class="hour"></div>
                            <div class="minute"></div>
                            <div class="second"></div>
                            <div class="center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7 Kebiasaan Anak Indonesia Hebat -->
        <div class="col-xl-9 col-md-12 mb-4">
            <div class="card border-left-black shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-start">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-black text-uppercase mb-2">
                                7 Kebiasaan Anak Indonesia Hebat
                            </div>
                            <ol class="mb-0 text-black" style="line-height: 1.8;">
                                <li>Bangun pagi</li>
                                <li>Beribadah</li>
                                <li>Berolahraga</li>
                                <li>Makan makanan sehat & bergizi</li>
                                <li>Gemar belajar</li>
                                <li>Bermasyarakat</li>
                                <li>Tidur lebih awal</li>
                            </ol>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tentang Jurusan TKJ -->
    <div class="row mt-4">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-primary text-uppercase mb-2">
                                Tentang Jurusan TKJ
                            </h6>
                            <p class="text-gray-800 mb-0">
                                Teknik Komputer dan Jaringan (TKJ) adalah jurusan yang mempelajari cara merakit, menginstal,
                                dan mengelola jaringan komputer. Siswa TKJ dibekali keterampilan jaringan, sistem operasi,
                                keamanan komputer, hingga server dan cloud computing.
                            </p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-network-wired fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Motivasi -->
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <h6 class="font-weight-bold text-success text-uppercase mb-2">
                                Motivasi Hari Ini 💻
                            </h6>
                            <blockquote class="blockquote text-gray-800 mb-0" style="font-size: 0.95rem;">
                                “Belajar jaringan memang rumit, tapi tanpa jaringan, dunia tidak akan terkoneksi.”
                            </blockquote>
                            <footer class="blockquote-footer mt-1">Atmin</footer>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-lightbulb fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Tentang SMK N 1 SRAGI -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-lg border-left-warning">
            <div class="card-body text-center">
                <h4 class="font-weight-bold text-warning text-uppercase mb-4">Tentang SMK Negeri 1 Sragi</h4>

                <img src="<?= base_url('assets/img/sekolah.jpeg'); ?>" 
                     class="img-fluid rounded shadow mb-4" 
                     style="max-height: 300px; object-fit: cover;">

                <p class="text-gray-800 mb-4" style="font-size: 1.05rem; text-align: justify; line-height: 1.8;">
                    <strong>SMK Negeri 1 Sragi</strong> adalah salah satu <em>Sekolah Menengah Kejuruan (SMK)</em> 
                    negeri yang berlokasi di <strong>Kabupaten Pekalongan, Provinsi Jawa Tengah</strong>. 
                    Sekolah ini berfokus pada pengembangan keterampilan dan keahlian praktis yang relevan 
                    dengan kebutuhan <strong>dunia kerja dan industri (DUDI)</strong>. 
                    Lulusan SMK Negeri 1 Sragi dipersiapkan untuk siap kerja, berwirausaha, atau melanjutkan pendidikan.
                    Sekolah ini juga telah <strong>terakreditasi A</strong> dan menjadi salah satu 
                    <strong>SMK Pusat Keunggulan</strong> di wilayahnya.
                </p>

                <div class="row text-left justify-content-center">
                    <!-- Kolom kiri: Program Keahlian -->
                    <div class="col-md-6 mb-4">
                        <h5 class="text-warning font-weight-bold mb-3">Program Keahlian (Jurusan)</h5>
                        <ul class="list-unstyled text-gray-800" style="font-size: 1rem; line-height: 1.8;">
                            <li>1️⃣ Teknik Otomotif Kendaraan Ringan (TOKR)</li>
                            <li>2️⃣ Teknik Otomotif Sepeda Motor (TOSM) / <em>Teknik dan Bisnis Sepeda Motor (TBSM)</em></li>
                            <li>3️⃣ Teknik Kimia Industri</li>
                            <li>4️⃣ Teknik Jaringan Komputer dan Telekomunikasi(TJKT)</li>
                            <li>5️⃣ Akuntansi dan Keuangan Lembaga</li>
                        </ul>
                    </div>

                    <!-- Kolom kanan: Alamat Sekolah -->
                    <div class="col-md-6 mb-4">
                        <h5 class="text-warning font-weight-bold mb-3">Alamat Sekolah</h5>
                        <p class="text-gray-800" style="font-size: 1rem; line-height: 1.8;">
                            📍 <strong>Jl. Raya Sragi No. 139 B, Gentongwungu</strong><br>
                            Desa/Kelurahan: Sragi, Kecamatan: Sragi<br>
                            Kabupaten: Pekalongan, Provinsi: Jawa Tengah
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS tambahan -->
<style>
.card-body h5 {
    border-bottom: 2px solid #ffc107;
    display: inline-block;
    padding-bottom: 4px;
    margin-bottom: 15px;
}
.card-body ul li {
    transition: 0.3s;
}
.card-body ul li:hover {
    transform: translateX(6px);
    color: #ffb300;
}
@media (max-width: 768px) {
    .card-body .row {
        text-align: center !important;
    }
}
</style>



<!-- STYLE JAM ANALOG -->
<style>
.clock {
    position: relative;
    width: 100px;
    height: 100px;
    border: 5px solid #333;
    border-radius: 50%;
    margin: 0 auto;
    background: #fdfdfd;
    box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
}
.clock .center {
    position: absolute;
    top: 50%; left: 50%;
    width: 10px; height: 10px;
    background: #000;
    border-radius: 50%;
    transform: translate(-50%, -50%);
}
.clock .hour, .clock .minute, .clock .second {
    position: absolute;
    top: 50%; left: 50%;
    transform-origin: bottom center;
    background: #000;
    border-radius: 4px;
}
.clock .hour {
    width: 5px; height: 25px;
    background: #222;
}
.clock .minute {
    width: 3px; height: 35px;
    background: #555;
}
.clock .second {
    width: 2px; height: 40px;
    background: #e74c3c;
}
</style>

<!-- SCRIPT JAM -->
<script>
function setClock() {
    const now = new Date();
    const hour = now.getHours() % 12;
    const minute = now.getMinutes();
    const second = now.getSeconds();

    const hourDeg = (hour * 30) + (minute * 0.5);
    const minuteDeg = (minute * 6);
    const secondDeg = (second * 6);

    document.querySelector('.hour').style.transform = `translate(-50%, -100%) rotate(${hourDeg}deg)`;
    document.querySelector('.minute').style.transform = `translate(-50%, -100%) rotate(${minuteDeg}deg)`;
    document.querySelector('.second').style.transform = `translate(-50%, -100%) rotate(${secondDeg}deg)`;
}
setInterval(setClock, 1000);
setClock();
</script>

<?php
date_default_timezone_set("Asia/Jakarta");

function format_tanggal($tanggal)
{
    $bulan = [
        1 => 'Januari','Februari','Maret','April','Mei',
        'Juni','Juli','Agustus','September','Oktober','November','Desember'
    ];
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<?= $this->endSection(); ?>