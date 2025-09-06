<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url('assets/media/qrcode/tkj.png') ?>"
        rel="icon">
    <link
        href="<?php echo base_url() ?>/vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('css/custom.css'); ?>"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>/css/sb-admin-2.min.css"
        rel="stylesheet">
    <link href="<?php echo base_url() ?>/assets/timeline.css"
        rel="stylesheet">
    <link
        href="<?php echo base_url() ?>/assets/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="<?php echo base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.css">
  <!-- Logout Modal-->
<style>
  .custom-logout-modal {
    border-radius: 20px !important;
    box-shadow: 0 8px 32px #0003, 0 2px 12px #ffc10744 !important;
    overflow: hidden;
    border: none !important;
  }
  .logout-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #ffc107cc 70%, #222a35 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
    box-shadow: 0 4px 14px #ffc10711, 0 1px 6px #222a3522;
    margin-top: -32px;
    border: 3px solid #fff;
  }
  .custom-logout-modal .modal-header {
    border: none;
    flex-direction: column;
    align-items: center;
    padding-top: 32px;
    padding-bottom: 0;
  }
  .custom-logout-modal .modal-title {
    color: #222a35;
    font-weight: bold;
    margin-top: 8px;
    font-size: 1.13rem;
    text-align: center;
    letter-spacing: 0.5px;
  }
  .custom-logout-modal .modal-body {
    text-align: center;
    color: #505050;
    font-size: 1.03rem;
    padding-top: 16px;
    padding-bottom: 8px;
  }
  .custom-logout-modal .modal-footer {
    border: none;
    justify-content: center;
    padding-bottom: 24px;
    padding-top: 8px;
  }
  .custom-logout-modal .btn-danger {
    background: #ff3b3f !important;
    border: none !important;
    color: #fff !important;
    box-shadow: 0 2px 6px #ff3b3f28;
    min-width: 100px;
  }
  .custom-logout-modal .btn-danger:hover, .custom-logout-modal .btn-danger:focus {
    background: #c62828 !important;
  }
  .custom-logout-modal .btn-light {
    background: #fff !important;
    color: #222a35 !important;
    min-width: 90px;
    border: 1px solid #ddd !important;
  }
</style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php echo $this->include('Admin/Templates/Sidebar'); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php echo $this->include('Admin/Templates/Topbar'); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?php echo $this->renderSection('page-content'); ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> &copy; Badan Pusat Statistik Kota Pekalongan
                            <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content custom-logout-modal">
      <div class="modal-header">
        <div class="logout-icon mb-2">
          <i class="fas fa-sign-out-alt"></i>
        </div>
        <h5 class="modal-title" id="logoutModalLabel">Yakin ingin keluar?</h5>
      </div>
      <div class="modal-body">
        Pilih <span style="font-weight:bold; color:#ff3b3f;">"Logout"</span> di bawah untuk mengakhiri sesi anda
      </div>
      <div class="modal-footer">
        <button class="btn btn-light border" type="button" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i> Batal
        </button>
        <a class="btn btn-danger text-white ml-2" href="<?php echo base_url('logout'); ?>">
          <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
      </div>
    </div>
  </div>
</div>


    <!-- Bootstrap core JavaScript-->

    <script src="<?php echo base_url(); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js">
    </script>

    <script src="<?php echo base_url() ?>/vendor/bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <script src="<?php echo base_url() ?>/vendor/jquery-easing/jquery.easing.min.js">
    </script>
    <script src="<?php echo base_url(); ?>/vendor/datatables/jquery.dataTables.min.js">
    </script>
    <script
        src="<?php echo base_url(); ?>/vendor/datatables/dataTables.bootstrap4.min.js">
    </script>
    <script src="<?php echo base_url() ?>/js/sb-admin-2.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/bootstrap-datepicker.min.js">
    </script>
    <script src="<?php echo base_url(); ?>/assets/js/demo/datatables-demo.js"></script>
    <!-- <script src="<?php echo base_url(); ?>/assets/js/demo/chart-area-demo.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <?php echo $this->renderSection('additional-js') ?>
    <script>
        $('.btn-change-group').on('click', function() {
            const id = $(this).data('id');

            $('.id').val(id);
            $('#changeGroupModal').modal('show');
        });

        $('.btn-change-password').on('click', function() {

            const id = $(this).data('id');
            // Set nilai pada input fields di modal
            $('#user_id').val(id);
            // Tampilkan modal untuk mengubah password
            $('#ubah_password').modal('show');
        });
        $('.btn-detail').on('click', function(e) {
            e.preventDefault(); // Menghentikan perilaku default tautan

            const id = $(this).data('id');
            const url = $(this).data('url');

            // Lakukan permintaan AJAX
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    id: id
                },
                success: function(response) {
                    // Lakukan sesuatu dengan data yang diterima dari server
                    console.log(response);

                    // Pindahkan pengguna ke halaman detail
                    window.location.href = url;
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });


        $('.btn-active-users').on('click', function() {
            const id = $(this).data('id');
            const isActive = $(this).data('active');

            // Kirim permintaan AJAX untuk mengaktifkan atau menonaktifkan pengguna
            $.ajax({
                url: '/activate-user/' + id + '/' + (isActive == 1 ? 0 : 1),
                method: 'GET',
                success: function(response) {
                    // Tampilkan pesan atau lakukan tindakan lain jika diperlukan
                    console.log(response);

                    // Jika Anda ingin memperbarui tampilan tombol sesuai dengan status pengguna
                    if (isActive == 1) {
                        $(this).data('active', 0);
                        $(this).html('<i class="fas fa-times-circle"></i>');
                    } else {
                        $(this).data('active', 1);
                        $(this).html('<i class="fas fa-check-circle"></i>');
                    }
                },
                error: function(error) {
                    // Tampilkan pesan kesalahan jika diperlukan
                    console.error(error);
                }
            });
        });
    </script>
</body>

</html>