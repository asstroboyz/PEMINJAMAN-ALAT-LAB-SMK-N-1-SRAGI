<style>
.sidebar {
  background: #222a35 !important; /* biru tua (dari logo) */
  color: #fff !important;
  border-right: 2px solid #FFC10766;
}

.sidebar .sidebar-brand {
  padding-top:10px !important;
  padding-bottom: 4px !important;
  display: flex !important;
  flex-direction: column !important;
  align-items: center !important;
  gap: 5px;
  background: #222a35 !important;
  border-bottom: 2px solid #FFC10733 !important;
}

.sidebar .sidebar-brand img {
  width: 40px;
  height: 40px;
  object-fit: contain;
  border-radius: 14px;
  border: 2px solid #FFC107bb;
  background: #fff;
  box-shadow: 0 2px 10px #23293122;
  margin-bottom: 0;
}


.sidebar .sidebar-brand-text {
  color: #FFC107 !important;
  font-weight: 600;            /* gak usah bold banget */
  font-size: 0.93rem;          /* kecilkan, biar ga ‘turun’ ke bawah logo */
  letter-spacing: 0.5px;
  text-align: center;
  margin: 2px 0 2px 0 !important; /* rapetin atas bawah */
  padding: 0;
  width: 100%;
  display: block;
  line-height: 1.2;
  white-space: nowrap;         /* text tetap satu baris, nggak pecah ke bawah */
  overflow: hidden;            /* kalau kelamaan, di-cut */
  text-overflow: ellipsis;     /* kasih titik-titik klo kepanjangan */
}


.sidebar .sidebar-brand img {
  border: 2.5px solid #FFC107cc !important;
  background: #fff;
}

.sidebar .nav-item .nav-link,
.sidebar .collapse-inner .collapse-item {
  color: #e0e0e0 !important;
  background: transparent !important;
}

.sidebar .nav-item .nav-link.active,
.sidebar .nav-item .nav-link:hover,
.sidebar .collapse-inner .collapse-item:hover {
  color: #FFC107 !important;
  background: #283044 !important;
}

.sidebar-divider,
hr.sidebar-divider {
  border-top: 1.5px solid #FFC10744 !important;
}

.sidebar-heading {
  color: #FFC107 !important;
}

.collapse-inner {
  background: #1b222d !important;
}
</style>
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?php echo base_url(); ?>">
     <i class="fas fa-network-wired"></i>
         <span class="sidebar-brand-text">LAB ESAE</span>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url(); ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Interface</div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-boxes-stacked"></i>
            <span>Component Master</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="collapse-inner rounded">
                <h6 class="collapse-header">Component Data :</h6>
                <a class="collapse-item" href="<?php echo base_url('Admin/masterBarang'); ?>">
                    <i class="fas fa-box"></i> Master Barang
                </a>
                <a class="collapse-item" href="<?php echo base_url('Admin/satuan'); ?>">
                    <i class="fas fa-ruler"></i> Master Satuan
                </a>
                <a class="collapse-item" href="<?php echo base_url('Admin/kategori'); ?>">
                    <i class="fas fa-ruler"></i> Master Kategori
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('Admin/adm_inventaris'); ?>">
            <i class="fas fa-list-ul"></i>
            <span>List Barang</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Kelola</div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barang" aria-expanded="true"
            aria-controls="barang">
            <i class="fas fa-handshake"></i>
            <span>Peminjaman alat</span>
        </a>
        <div id="barang" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
    <div class="collapse-inner rounded">
        <h6 class="collapse-header">Custom Utilities:</h6>
        <a class="collapse-item" href="<?= base_url('Admin/peminjaman?status=all'); ?>">
            <i class="fas fa-arrow-right-arrow-left"></i> Semua Peminjaman
        </a>
        <a class="collapse-item" href="<?= base_url('Admin/peminjaman?status=pengajuan  '); ?>">
            <i class="fas fa-spinner"></i> Diproses
        </a>
        <a class="collapse-item" href="<?= base_url('Admin/peminjaman?status=selesai'); ?>">
            <i class="fas fa-check-double"></i> Selesai
        </a>
        <a class="collapse-item" href="<?= base_url('Admin/peminjaman?status=rejected'); ?>">
            <i class="fas fa-ban"></i> Ditolak
        </a>
    </div>
</div>

    </li>
    <hr class="sidebar-divider">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
