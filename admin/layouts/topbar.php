<header id="page-topbar" class="isvertical-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../assets/image/favicon.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/image/favicon.png" alt="" height="22"> <span class="logo-txt"><?= $_SESSION['site_name'] ?></span>
                    </span>
                </a>

                <a href="index.php" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../assets/image/favicon.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="../assets/image/favicon.png" alt="" height="22"> <span class="logo-txt"><?= $_SESSION['site_name'] ?></span>
                    </span>
                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- Search -->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." id="search">
                    <span class="bx bx-search"></span>
                </div>
            </form>

        </div>

        <div class="d-flex">
            <div class="dropdown d-inline-block d-lg-none">
                <button type="button" class="btn header-item" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-sm" data-feather="search"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                    <form class="p-2">
                        <div class="search-box">
                            <div class="position-relative">
                                <input type="text" class="form-control rounded bg-light border-0" placeholder="Search...">
                                <i class="mdi mdi-magnify search-icon"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item light-dark" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-sm layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-sm layout-mode-light"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item user text-start d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <?php
                    $imageDirectory = "../assets/image/profile_admin/";
                    $imagePath = $imageDirectory . $_SESSION['profile_image'];
                    $src = file_exists($imagePath) ? $imagePath : "../assets/image/profile_admin/default-placeholder.jpg";
                    ?>
                    <img src="<?php echo $src; ?>" alt="Profile Image" class="rounded-circle header-profile-user">
                </button>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <a class="dropdown-item" href="contacts-profile.php"><i class='bx bx-user-circle text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">My Account</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class='bx bx-log-out text-muted font-size-18 align-middle me-1'></i> <span class="align-middle">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>