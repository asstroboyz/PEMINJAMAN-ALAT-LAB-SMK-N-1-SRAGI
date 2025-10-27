<?= $this->extend('User/Templates/Index') ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">

        <!-- Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-black shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-black text-uppercase mb-1">
                                Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-black">
                                <?= $tanggalEcho = format_tanggal(date('Y-m-d')); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-black"></i>
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
                                <li>1.Bangun pagi</li>
                                <li>2.Beribadah</li>
                                <li>3.Berolaharaga</li>
                                <li>4.Makan makanan sehat & bergizi</li>
                                <li>5.Gemar Belajar</li>
                                <li>6.Bermasyarakat</li>
                                <li>7.Tidur lebih awal</li>
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
</div>

<?php
date_default_timezone_set("Asia/Jakarta");

function format_tanggal($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<?= $this->endSection(); ?>
