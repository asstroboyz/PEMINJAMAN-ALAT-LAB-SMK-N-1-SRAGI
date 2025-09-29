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
    <div class="row mt-4">
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
    const ctx = document.getElementById('lineChart').getContext('2d');

    // gradient area biru
    const gradient = ctx.createLinearGradient(0, 0, 0, 200);
    gradient.addColorStop(0, 'rgba(0,123,255,0.5)');
    gradient.addColorStop(1, 'rgba(0,123,255,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($grafik, 'tgl')) ?>, // tanggal harian bulan ini
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: <?= json_encode(array_column($grafik, 'total')) ?>,
                borderColor: '#007bff',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#007bff',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' transaksi';
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi'
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection(); ?>