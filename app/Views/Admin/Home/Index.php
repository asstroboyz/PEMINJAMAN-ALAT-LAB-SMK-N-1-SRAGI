<?= $this->extend('Admin/Templates/Index') ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">
    <div class="row">

        <!-- Card Sedang Dipinjam -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Sedang Dipinjam
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $totalDipinjam ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cube fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Dikembalikan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Sudah Dikembalikan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-success">
                                <?= $totalDikembalikan ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Rusak / Hilang -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Rusak / Hilang
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-danger">
                                <?= $totalRusak + $totalHilang ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    <!-- Grafik Line -->
    <!-- <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Trend Peminjaman Bulan <?= $bulanSekarang ?>
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="lineChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">
                        Top 5 Barang yang Sering Dipinjam - <?= $bulanSekarang ?>
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="barChartTopBarang" height="100"></canvas>
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
<?= $this->endSection(); ?>

<?= $this->section('additional-js'); ?>
<script src="<?= base_url('assets/js/chart.umd.js') ?>"></script>
<script>
    
    const ctxBar = document.getElementById('barChartTopBarang').getContext('2d');

    const topBarang = <?= json_encode($topBarang) ?>;
    const labelsBarang = topBarang.map(item => item.nama_brg);
    const dataBarang = topBarang.map(item => parseInt(item.total));

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labelsBarang,
            datasets: [{
                label: 'Jumlah Dipinjam',
                data: dataBarang,
                backgroundColor: [
                    '#207c5c', '#17a364', '#65cc9e', '#95dcbc', '#0e623d'
                ],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: (context) => context.parsed.y + ' kali dipinjam'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection(); ?>