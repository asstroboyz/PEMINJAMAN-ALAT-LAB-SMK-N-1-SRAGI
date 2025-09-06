<?= $this->extend('Admin/Templates/Index') ?>
<?=$this->section('page-content');?>
<!-- Begin Page Content -->

<div class="container-fluid">



    <!-- Second Row -->
    <div class="row">
        <!-- Third Column -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cetak Data Transaksi Barang Masuk</h6>
                </div>
                <div class="card-body">
                    <form
                        action="<?=base_url('Admin/cetakDataMasuk');?>"
                        target="_blank" method="get">
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai:</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" name="tanggal_akhir" class="form-control" required>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Cetak Data</button></center>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<?=$this->endSection();?>
<?=$this->section('additional-js');?>
<script>
    $("#datepicker").datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
        minViewMode: "months"
    });
    $("#datepicker-2").datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
        minViewMode: "months"
    });
    $("#datepicker-3").datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
        minViewMode: "months"
    });
    $("#datepicker-4").datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
        minViewMode: "months"
    });
    $("#datepicker-5").datepicker({
        format: "yyyy-mm-dd",
        startView: "months",
        minViewMode: "months"
    });

    function getLastDate(valuex) {
        var dateform = $("#datepicker-5").datepicker('getDate');
        var selectedMonth = dateform.getMonth();
        var selectedYear = dateform.getFullYear();

        var lastDate = new Date(selectedYear, selectedMonth + 1, 0);

        var year = lastDate.toLocaleString("default", {
            year: "numeric"
        });
        var month = lastDate.toLocaleString("default", {
            month: "2-digit"
        });
        var day = lastDate.toLocaleString("default", {
            day: "2-digit"
        });

        // Generate yyyy-mm-dd date string
        var formattedDate = year + "-" + month + "-" + day;

        document.getElementById('datepicker-5').value = formattedDate;
        document.getElementById('tanggal-multi-akhir').value = formattedDate;
    }
</script>
<?=$this->endSection();?>