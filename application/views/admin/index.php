<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Access Authority</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user_role; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('admin/role'); ?>">View &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Registered Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $user_member; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('admin/datamember'); ?>">View &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Menu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $menu; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('menu'); ?>">View &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Submenu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sub_menu; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('menu/submenu'); ?>">View &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Report</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $report; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-500"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('report'); ?>">View &rarr;</a></small>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->