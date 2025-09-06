<?= $this->extend('Admin/Templates/Index') ?>
<?=$this->section('page-content');?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cetak Data Inventaris Barang</h6>
                </div>
                <div class="card-body">
                    <form
                        action="<?=base_url('Admin/cetak_ruangan');?>"
                        target="_blank" method="get">
                        <div class="form-group">
                            <label for="lokasi">Ruangan:</label>
                            <select name="lokasi" class="form-control" required>
                                <option value="">Pilih Ruangan</option>
                                <option value="Staf Umum">Staf Umum</option>
                                <option value="LPDSS">LPDSS</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Kepela">Kepela</option>
                                <option value="PST">PST</option>
                                <option value="Lobby">Lobby</option>
                                <option value="Gudang">Gudang</option>
                                <option value="Dapur">Dapur</option>
                                <option value="Mushola">Mushola</option>
                            </select>
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

        var formattedDate = year + "-" + month + "-" + day;

        document.getElementById('datepicker-5').value = formattedDate;
        document.getElementById('tanggal-multi-akhir').value = formattedDate;
    }
</script>
<?=$this->endSection();?>