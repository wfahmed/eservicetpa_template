<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
          <!-- Sidebar - Brand -->


        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


            <!-- Sidebar Toggle (Topbar) -->
            <!-- Sidebar Toggle-->
        <!--    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle2" href="#!"><i class="fas fa-bars"></i></button>-->


            <button id="sidebarToggleTop" class="btn btn-link   rounded-circle mr-3">
                <i class="fa fa-solid fa-bars"></i>
            </button>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <div class="topbar-divider d-none d-sm-block"></div>
                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['full_name']; ?></span>
                    <img class="img-profile rounded-circle" src="<?= base_url('assets/img/profile/').$user['image']; ?>">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= base_url('user'); ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>                        الملف الشخصي
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('user/edit'); ?>">
                        <i class="fas fa-fw fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>تعديل الملف الشخصي
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('user/changepassword'); ?>">
                        <i class="fas fa-fw fa-key fa-sm fa-fw mr-2 text-gray-400"></i>                       تغيير كلمة المرور
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>                        تسجيل الخروج
                    </a>
                </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->