<?= $this->extend('Admin/Templates/Index') ?>


<?=$this->section('page-content');?>

<div class="container-fluid">
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/permintaan">
                <div class="card border-left-primary shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Permintaan Barang
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                  
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cube fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Barang ATK Stok Dibawah 10 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/atk">
                <div class="card border-left-primary shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Barang ATK Stok Dibawah 10
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-primary">
                                    <span
                                        class="text-danger">
                                        
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/permintaan_proses">
                <div class="card border-left-warning shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Permintaan Di-Proses
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-success">
                                 
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-hourglass-half fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/permintaan_selesai">
                <div class="card border-left-warning shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Permintaan Barang Selesai
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-success">
                                   
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pengadaan Barang Proses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/pengadaan/">
                <div class="card border-left-success shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pengadaan Barang Proses
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-success">
                                   
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cogs fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>


        <!-- Pengadaan Barang Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/Admin/pengadaan/">
                <div class="card border-left-success shadow h-100 py-2" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pengadaan Barang Selesai
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-success">
                                   
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

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


    </div>


</div>

<?php
date_default_timezone_set("Asia/Jakarta");
$tanggalEcho = format_tanggal(date('Y-m-d'));

function format_tanggal($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
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
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<?=$this->endSection();?>