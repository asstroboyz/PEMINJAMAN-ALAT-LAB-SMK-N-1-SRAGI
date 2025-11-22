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

        <!-- Card Tanggal -->
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

    <!-- BAR + PIE CHART -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-success">
                        Top 5 Barang yang Sering Dipinjam - <?= $bulanSekarang ?>
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="barChartTopBarang" height="90"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Persentase Peminjaman Barang - <?= $bulanSekarang ?>
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="pieChartTopBarang" height="90"></canvas>
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
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>

<?= $this->endSection(); ?>

<?= $this->section('additional-js'); ?>
<script src="<?= base_url('assets/js/chart.umd.js') ?>"></script>

<script>
    const topBarang = <?= json_encode($topBarang) ?>;
    const labelsBarang = topBarang.map(item => item.nama_brg);
    const dataBarang = topBarang.map(item => parseInt(item.total));

    // ===================== BAR CHART =======================
    const ctxBar = document.getElementById('barChartTopBarang').getContext('2d');

    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labelsBarang,
            datasets: [{
                label: 'Jumlah Dipinjam',
                data: dataBarang,
                backgroundColor: ['#060771', '#FFE08F', '#FF6C0C', '#BF1A1A', '#8CA9FF'],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: context => context.parsed.y + ' kali dipinjam'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });

    // ===================== PIE CHART =======================
    const ctxPie = document.getElementById('pieChartTopBarang').getContext('2d');
    const totalAll = dataBarang.reduce((a, b) => a + b, 0);

    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labelsBarang,
            datasets: [{
                data: dataBarang,
                backgroundColor: ['#313647', '#4A70A9', '#0046FF', '#A3B087', '#FE6244'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: context => {
                            const value = context.parsed;
                            const percent = ((value / totalAll) * 100).toFixed(1);
                            return `${value} kali (${percent}%)`;
                        }
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection(); ?>
