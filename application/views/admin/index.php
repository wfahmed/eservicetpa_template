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
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">موظف له صلاحية</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_has_access']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-500" style="color: #5a5c69  !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('member/emp_show'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">المواطنين</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_citezn']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-500" style="color: #f6c23e   !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('member/citizen_show'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">عدد الأسر</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_family']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-500" style="color: #1cc88a   !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('member/family_show'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 ">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">عدد الأطفال</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_child']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-500" style="color: #36b9cc  !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('member/child_show'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 ">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">الموردين</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['supplier']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-500" style="color: #e74a3b  !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('supplier'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">عدد أسر الأيتام</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_family_orphan']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-500" style="color: #1cc88a   !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('member/family_orphan_show'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 ">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">عدد الأيتام</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['user_child_orphan']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-500" style="color: #36b9cc  !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('orphan/index'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4 d-none">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">المشاريع</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $param['projects']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-500" style="color: #36b9cc  !important;"></i>
                        </div>
                    </div>
                </div>
                <small><a class="ml-3" href="<?= base_url('project'); ?>">عرض &rarr;</a></small>
            </div>
        </div>
    </div>

    <h1 class="h3 mb-4 text-gray-800 d-none">المشاريع</h1>
    <div class="row col-md-12 d-none">

        <div class="col-md-6 ">
            <canvas id="lineChart" width="400" height="200"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="barChart" width="400" height="200"></canvas>
        </div>

    </div>
    <br>
    <br>
    <div class="row col-md-12 d-none">
        <div class="col-md-6">
            <canvas id="doughnutChart" width="400" height="200"></canvas>
        </div>

    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->