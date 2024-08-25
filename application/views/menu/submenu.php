<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if (validation_errors()) : ?>
    <div class="alert alert-danger" role="alert">
        <?= validation_errors(); ?>
    </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#newSubmenuModal"><i class="fas fa-plus"></i> إضافة قائمة فرعية</a></h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="<?php
                    if(isset( $param['gmenu_id']))echo 'thead-dark-c';else echo
                    'thead-dark'?>">
                                <tr>
                                    <th>#</th>
                                    <th>Menu </th>
                                    <th>اسم </th>
                                    <th> القائمة الرئيسية </th>
                                    <th>الرابط</th>
                                    <th>الرمز</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                </tr>
                        </thead>
                    <tbody>
                        <?php $index = 1; $submenu=$param['submenu']?>
                        <?php foreach($submenu as $sm) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $sm['title']; ?></td>
                                <td><?= $sm['ar_title']; ?></td>
                                <td><?= $sm['menu']; ?></td>
                                <td><?= $sm['url']; ?></td>
                                <td>
                                    <?php if ($sm['icon']) : ?>
                                        <?= '<i class="'.$sm['icon'].'"></i>' ?>
                                    <?php else : ?>
                                        <?= '<i class=""></i>' ?>
                                    <?php endif; ?></td>
                                <td>
                                     <?php if($sm['is_active'] == 1) : ?>
                                    <?= ' <i class="fa fa-check-circle" style="color: green;"></i>' ?>
                                    <?php else : ?>
                                    <?= ' <i class="fa fa-check-circle" style="color: red;"></i>' ?>
                                    <?php endif; ?></td>
                                </td>
                                <td>
                                    <a class="badge badge-success" style="font-size:14px;" href="<?= site_url('menu/editsubmenu/'.$sm['id']); ?>">تعديل</a>
                                    <a class="badge badge-danger" style="font-size:14px;" href="#!" onclick="deleteConfirm('<?= site_url('menu/deletesubmenu/'.$sm['id']); ?>')">حذف</a>
                                </td>
                            </tr>
                        <?php $index++; ?>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal add new submenu-->
<div class="modal fade" id="newSubmenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubmenuModalLabel">إضافة قائمة فرعية جديدة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form -->
      <form action="<?= site_url('menu/addsubmenu'); ?>" method="post">
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="menu">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="ar_title" name="ar_title" placeholder="الاسم">
            </div>
            <div class="form-group">
                <select name="menu_id" id="menu_id" class="form-control"  <?php
                if(isset( $param['gmenu_id']))echo 'readonly ';else echo
                ''?>><?= $m['menu']; ?>>
                    <option value="">---اختر القائمة الرئيسية---</option>
                    <?php $menu=$param['menus'];
                    foreach($menu as $m) : ?>
                    <option value="<?= $m['id']; ?>"  <?php
                    if(isset( $param['gmenu_id']))echo 'selected ';else echo
                    ''?>><?= $m['menu']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="url" name="url" placeholder="الرابط">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="icon" name="icon" placeholder="الرمز">
            </div>
            <div class="form-group">
            <div class="col-md-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                <label class="form-check-label" for="is_active">
                  هل فعال؟
                </label>
              </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>

        </div>
      </form>
    </div>
  </div>
</div>

<!-- modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">هل أنت متأكد؟</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">لا يمكن استعادة البيانات المحذوفة!</div>
            <div class="modal-footer">
                <a id="btn-delete" class="btn btn-danger" href="#">حذف</a>

                <button class="btn btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
            </div>
        </div>
    </div>
</div>