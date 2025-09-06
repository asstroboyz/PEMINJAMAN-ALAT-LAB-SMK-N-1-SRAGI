<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?= base_url(); ?>">
        <img src="<?= base_url() ?>/assets/img/11.png" width="75px"
            height="75px">
        <div class="sidebar-brand-text mx-3">BPS KOTA PEKALONGAN</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai'); ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Interface</div>

    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai/inventaris'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Inventaris</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai/atk'); ?>">
            <i class="fas fa-fw fa-cube"></i>
            <span>Daftar Barang</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai/permintaan'); ?>">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Permintaan Barang</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai/pengadaan'); ?>">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Pengadaan Barang</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="<?= base_url('Pegawai/Scan'); ?>">
            <i class="fas fa-table"></i>
            <span>Scan QR Barang</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>