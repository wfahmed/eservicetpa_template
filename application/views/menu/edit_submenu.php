<!-- Begin Page Content -->
<div class="container-fluid">
<?php
$submenu=$param['submenu'];
$menu=$param['menus'];
?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-lg-12">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('menu/submenu') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $submenu['id']; ?>" />
                <div class="form-group">
                    <label for="menu">الاسم باللغة الانجليزية</label>
                    <input class="form-control" type="text" name="title" placeholder="الاسم" value="<?= $submenu['title'] ?>" />
                </div>
                <div class="form-group">
                    <label for="menu">الاسم باللغة العربية</label>
                    <input class="form-control" type="text" name="ar_title" placeholder="الاسم" value="<?= $submenu['ar_title'] ?>" />
                </div>
                <div class="form-group">
                    <label for="menu">القائمة الرئيسية</label>
                    <select name="menu_id" id="menu_id" class="form-control">
                        <option value="">---اختر القائمة الرئيسية---</option>
                        <?php foreach ($menu as $m) : ?>
                        <option value="<?= $m['id']; ?>" <?php if($m['id']==$submenu['menu_id'])echo'selected';else echo '';?>><?= $m['menu']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="menu">الرابط</label>
                    <input class="form-control" type="text" name="url" placeholder="Url Submenu" value="<?= $submenu['url'] ?>" />
                </div>
                <div class="form-group">
                    <label for="menu">الرمز</label>
                    <input class="form-control" type="text" name="icon" placeholder="Submenu Icon" value="<?= $submenu['icon'] ?>" />
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" <?php if($submenu['is_active']==1)echo'checked';else echo '';?>>
                        <label class="form-check-label" for="is_active">
                            هل فعال؟
                        </label>
                    </div>
                </div>
                <!-- btn -->
                <input class="btn btn-success" type="submit" name="btn" value="حفظ" />
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->