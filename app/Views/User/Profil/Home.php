<?=$this->extend('Pegawai/Templates/Index');?>


<?=$this->section('page-content');?>



<div class="container-fluid">
    <?php if (session()->getFlashdata('error-msg')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible show fade" role="alert">

                <div class="alert-body">
                    <button class="close" data-dismiss>x</button>
                    <b><i class="fa fa-check"></i></b>
                    <?=session()->getFlashdata('error-msg');?>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-success alert-dismissible show fade" role="alert">

                <div class="alert-body">
                    <button class="close" data-dismiss>x</button>
                    <b><i class="fa fa-check"></i></b>
                    <?=session()->getFlashdata('msg');?>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <!-- Page Heading -->

    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Permintaan Barang </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$semua?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Permintaan Barang Di-Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$proses;?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Permintaan Selesai</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?=$selesai;?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?=$tanggalEcho = format_tanggal(date('Y-m-d'));
?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
        'Desember',
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}
?>
<script>
    $(document).ready(function() {
        $.validator.addMethod("metodku", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Username must contain only letters, numbers, or dashes.");

        $.validator.addMethod("valueNotEquals", function(value, element, arg) {
            return arg !== value;
        }, "This field is required.");

        $("#formUser").validate({
            rules: {
                nama: {
                    required: true,
                    minlength: 3,
                    metodku: true
                },
                username: {
                    required: true,
                    minlength: 3,
                    metodku: true
                },
                role: {
                    required: true,
                    valueNotEquals: "default"
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
        });
    });
</script>
<?=$this->endSection();?>