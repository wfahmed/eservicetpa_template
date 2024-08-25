<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?> ل <?= $param['role']['role']; ?></h1>
    <div class="col-lg-12">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#newAccessModal"><i class="fas fa-plus"></i> إضافة جديد</a></h6>

           <!-- <h6 class="m-0 font-weight-bold text-primary"><a href="<?/*= base_url('admin/role') */?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>-->
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark-ggreen">
                                <tr>
                                <th>#</th>
                                <th>الاسم باللغة الانجليزية</th>
                                <th>الاسم باللغة العربية</th>
                                <th>إجراءات</th>
                                </tr>
                        </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php

                       $menu=$param['menu'];
                        // var_dump($menu);die();
                        foreach((array)$menu as  $m ) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $m['menu'] ?></td>
                                <td><?= $m['ar_menu']; ?></td>
                                <td>
                                   <a class="badge badge-danger" style="font-size:14px;" href="#!" onclick="deleteConfirm('<?= site_url('admin/delete_access_role/'.$m['id']); ?>')">حذف</a>
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
<div class="modal fade" id="newAccessModal" tabindex="-1" role="dialog" aria-labelledby="newAccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">إضافة شاشات للصلاحية</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form -->
            <form action="<?= site_url('admin/addroleaccess'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control" >
                            <option value="">---اختر الشاشة---</option>
                            <?php $menu=$param['menusub'];
                            foreach($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['ar_title']; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="role_id" name="role_id" value="<?= $param['role_id']; ?>">
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