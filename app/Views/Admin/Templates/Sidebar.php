<style>
    body {
        background: #232931;
    }

    .sidebar {
        background: linear-gradient(180deg, #232931 70%, #0d7377 100%) !important;
        border-right: 2px solid #14ffec;
        min-height: 100vh;
    }

    .sidebar .sidebar-brand {
        background: #14ffec11;
        border-bottom: 1px solid #14ffec33;
        padding: 10px 0;
    }

    .sidebar .sidebar-brand-text {
        color: #14ffec;
        font-weight: bold;
        letter-spacing: 2px;
        font-size: 1.25rem;
        text-shadow: 0 1px 5px #000a;
    }

    .sidebar .nav-item .nav-link {
        color: #ffffffcc !important;
        font-weight: 500;
        border-radius: 7px;
        transition: background 0.2s, color 0.2s;
        margin-bottom: 3px;
    }

    .sidebar .nav-item .nav-link.active,
    .sidebar .nav-item .nav-link:hover {
        background: #14ffec44;
        color: #14ffec !important;
    }

    .sidebar .sidebar-divider {
        border-top: 2px dashed #14ffec44;
        margin: 1.3rem 0;
    }

    .sidebar .sidebar-heading {
        color: #14ffec;
        font-size: 0.85rem;
        margin-left: 10px;
        margin-bottom: 7px;
        letter-spacing: 1px;
        font-weight: bold;
    }

    .collapse-inner {
        background: #393e46 !important;
        border-radius: 0.5rem;
    }

    .collapse-header {
        color: #14ffec;
        font-size: 0.95rem;
        letter-spacing: 1px;
    }

    .collapse-item {
        color: #fff !important;
        border-radius: 6px;
        font-size: 0.96rem;
        padding-left: 22px !important;
        font-weight: 500;
    }

    .collapse-item:hover,
    .collapse-item:focus {
        background: #14ffec33 !important;
        color: #14ffec !important;
    }

    .fa-wrench,
    .fa-cogs,
    .fa-home {
        color: #14ffec !important;
        text-shadow: 0 0 5px #393e46;
    }

    /* Logo bulat */
    .sidebar-brand img {
        border-radius: 90%;
        border: 1px solid #14ffec99;
        box-shadow: 0 2px 10px #14ffec22;
    }

    /* Button sidebar toggle */
    #sidebarToggle {
        background: #14ffec !important;
        color: #393e46 !important;
    }

    @media (max-width: 900px) {
        .sidebar {
            min-width: 70px;
        }
    }
</style>
<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?php echo base_url(); ?>">
        <img src="<?php echo base_url() ?>/assets/img/11.png">
        <div class="sidebar-brand-text mx-3">LAB ESAE</div>
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
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Component Data :</h6>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/masterBarang'); ?>"><i class="fas fa-box"></i> Master Barang </a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/satuan'); ?>"><i class="fas fa-ruler"></i> Master Satuan</a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/merk'); ?>"><i class="fas fa-ruler"></i> Master Merk</a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/kategori'); ?>"><i class="fas fa-ruler"></i> Master Kategori</a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/kategori-merk'); ?>"><i class="fas fa-ruler"></i> Master Kategori-merk</a>
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
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/permintaan_masuk'); ?>"><i class="fas fa-arrow-right-arrow-left"></i> Peminjaman alat</a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/permintaan_proses'); ?>"><i class="fas fa-spinner"></i> Diproses</a>
                <a class="collapse-item"
                    href="<?php echo base_url('Admin/permintaan_selesai'); ?>"><i class="fas fa-check-double"></i> Selesai</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>