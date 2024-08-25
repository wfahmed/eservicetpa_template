<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <img width="100%" height="95%" src="<?= base_url().'/assets/img/logo.png'?>">
            </div>
        </a>

          <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- QUERY user_menu JOIN user_access_menu -->
        <?php
        $role_id = $this->session->userdata['role_id'];
        $queryMenu =    "SELECT DISTINCT `user_menu`.`id`,`menu_icon`, `menu`,`ar_menu` FROM `user_menu` JOIN `user_access_menu`
                        ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                        WHERE  `user_menu`.`display` =1 and `user_access_menu`.`role_id` = $role_id 
                        ORDER BY `user_access_menu`.`menu_id` ASC";
        $menu = $this->db->query($queryMenu)->result_array();
        ?>

        <!-- Looping Menu -->
        <?php foreach($menu as $m) : ?>
            <div class="sidebar-heading">
                <a class="" href="javascript:;" style="color:white;padding-right: 0rem;">
                    <span> <?= $m['ar_menu']; ?></span></a>
            </div>

            <!-- QUERY user_sub_menu JOIN user_menu-->
            <?php
            $menuId = $m['id'];
            $querySubMenu = "SELECT * FROM `user_sub_menu` JOIN `user_menu`
                            ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                            WHERE `user_sub_menu`.`menu_id` = $menuId
                            AND `user_sub_menu`.`is_active` = 1";
            $subMenu = $this->db->query($querySubMenu)->result_array();
            ?>

            <!-- Looping Sub Menu -->
            <?php foreach($subMenu as $sm) : ?>
                <!-- active menu -->
                <?php if ($title == $sm['title']) : ?>
                    <li class="nav-item active">
                <?php else : ?>
                    <li class="nav-item">
                <?php endif; ?>
                    <a class="nav-link pb-0 " href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['ar_title']; ?></span></a>
            <?php endforeach; ?>

            <!-- Looping divider -->
            <hr class="sidebar-divider mt-3">

        <?php endforeach; ?>

        <!-- Nav Item - logout -->
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>تسجيل الخروج</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->