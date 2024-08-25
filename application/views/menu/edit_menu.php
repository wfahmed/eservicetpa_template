<!-- Begin Page Content -->
<div class="container-fluid">
<?php $menu=$param['menu'];?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-lg-12">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('menu') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $menu['id']; ?>" />
                    <!-- edit title -->
                	<div class="form-group">
                		<label for="menu">اسم القائمة باللغة الانجليزية</label>
                		<input class="form-control" type="text" name="menu" placeholder="Menu Name" value="<?= $menu['menu'] ?>" readonly/>
                	</div>
                <div class="form-group">
                    <label for="ar_menu">اسم القائمة باللغة العربية</label>
                    <input class="form-control" type="text" name="ar_menu" id="ar_menu" placeholder="اسم القائمة" value="<?= $menu['ar_menu'] ?>" />
                </div>
                <div class="form-group">
                    <label for="menu_icon">رمز القائمة</label>
                    <input class="form-control" type="text" name="menu_icon"  id="menu_icon" placeholder="الرمز" value="<?= $menu['menu_icon'] ?>" />
                </div>
                <div class="form-group  col-lg-12">
                    <div class="form-check ">
                        <?php if ($menu['display'] == 1) : ?>
                            <?= '<input class="form-check-input" type="checkbox" value="1" id="display" name="display" checked>' ?>
                        <?php else : ?>
                            <?= '<input class="form-check-input" type="checkbox" value="1" id="display" name="display">' ?>
                        <?php endif; ?>
                        <label class="form-check-label" for="display">
                            هل يعرض؟
                        </label>
                    </div>
                </div>
                <!-- btn -->
                <input class="btn btn-success" type="submit" name="btn" value="حفظ التعديل" />
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->