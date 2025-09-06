<style>
    /* FINISHING TOUCH PROFILE DROPDOWN */
    .nav-link.dropdown-toggle:hover,
    .nav-link.dropdown-toggle:focus {
        background: #fafafc;
        border-radius: 999px;
        transition: background 0.14s;
    }

    .img-profile.rounded-circle {
        box-shadow: 0 2px 10px #ffc10733, 0 0.5px 2px #222a3520;
    }

    .custom-dropdown-menu {
        border-radius: 16px !important;
        min-width: 210px;
        padding-top: 0 !important;
        padding-bottom: 8px !important;
        margin-top: 12px !important;
        box-shadow: 0 8px 32px #0002, 0 2px 12px #ffc10722 !important;
        background: #232931 !important;
        border: none !important;
        animation: fadeInDown 0.25s;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-18px);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .dropdown-profile-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 22px 12px 12px 12px;
        background: #222a35;
        border-radius: 16px 16px 0 0;
        margin-bottom: 8px;
        border-bottom: 1px solid #FFC10722;
    }

    .dropdown-profile-header img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 50%;
        border: 2.5px solid #FFC107bb;
        box-shadow: 0 2px 12px #ffc10722;
        background: #fff;
    }

    .dropdown-profile-header .profile-name {
        font-weight: 700;
        color: #FFC107;
        font-size: 1.08rem;
        margin-top: 8px;
        text-align: center;
        letter-spacing: 0.1px;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropdown-profile-header .profile-email {
        color: #e0e0e0;
        font-size: 0.95rem;
        margin-top: 2px;
        margin-bottom: -2px;
        text-align: center;
        opacity: 0.75;
        font-weight: 400;
        letter-spacing: 0.02em;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .custom-dropdown-menu .dropdown-divider {
        border-top: 1px solid #ffc10733 !important;
        margin: 8px 0 !important;
    }

    .custom-dropdown-menu .dropdown-item {
        color: #e0e0e0 !important;
        font-weight: 500;
        font-size: 1.01rem;
        border-radius: 6px;
        margin: 0 6px;
        padding: 8px 16px 8px 12px;
        transition: background 0.15s, color 0.15s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .custom-dropdown-menu .dropdown-item i {
        color: #FFC107 !important;
        font-size: 1.05em !important;
        margin-right: 10px;
        min-width: 22px;
        text-align: center;
    }

    .custom-dropdown-menu .dropdown-item:hover,
    .custom-dropdown-menu .dropdown-item:focus {
        background: #1b222d !important;
        color: #FFC107 !important;
    }

    @media (max-width: 500px) {
        .custom-dropdown-menu {
            min-width: 90vw !important;
            right: 0 !important;
            left: auto !important;
            margin-right: 4vw !important;
        }
    }
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-300 small"><?= user()->fullname; ?></span>
                <img class="img-profile rounded-circle"
                    src="<?= empty(user()->foto) ? '/sbassets/img/undraw_profile.svg' : '/uploads/profile/' . user()->foto; ?>"
                    style="width:32px;height:32px;object-fit:cover;border:2px solid #FFC10788;">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in custom-dropdown-menu" aria-labelledby="userDropdown">
                <!-- Header area -->
                <div class="dropdown-profile-header">
                    <img src="<?= empty(user()->foto) ? '/sbassets/img/undraw_profile.svg' : '/uploads/profile/' . user()->foto; ?>">
                    <div class="profile-name"><?= user()->fullname; ?></div>
                    <?php if (user()->email): ?>
                        <div class="profile-email"><?= user()->email; ?></div>
                    <?php endif; ?>
                </div>
                <!-- Menu -->
                <a class="dropdown-item" href="<?= base_url('admin/profil'); ?>">
                    <i class="fas fa-user fa-fw"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                </a>
            </div>
        </li>

    </ul>

</nav>