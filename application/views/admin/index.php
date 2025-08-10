<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <?php if(in_array($this->session->userdata('role_id'), [1, 14])){?>

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
        <?php }?>
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

    </div>
    <?php if (isset($param['user_members'])) {
        $user_members = $param['user_members']; ?>
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">الموظفون الأكثر نشاطاً</h1>
            </div>

            <!-- Employee Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="employeeStats" width="100%" cellspacing="0">
                            <thead style="background: linear-gradient(to right, #f3d68e, #25ed54); color: #fff;">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهوية</th>
                                <th>عدد المحدثين بواسطته</th>
                                <th>عدد المضافين بواسطته</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 1; ?>
                            <?php foreach ($user_members as $um) : ?>
                                <?php //if ($um['refreshed_count'] > 0) : ?>
                                <tr style="<?= $um['is_active'] == 0 ? 'background-color: #ebd78c;' : ''; ?>">
                                <td><?= $index; ?></td>
                                        <td><?= htmlspecialchars($um['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($um['identity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($um['refreshed_count'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= htmlspecialchars($um['added_count'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    </tr>
                                    <?php $index++; ?>
                                <?php //endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

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