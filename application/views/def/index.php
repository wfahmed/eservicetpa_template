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
    <div class="col-lg-12">
        <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#newDefModal"><i class="fas fa-plus"></i> إضافة ثابت</a></h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                                <tr>
                                <th>#</th>
                                <th>الثابت</th>
                                <th> مساره</th>
                                <th>إجراءات</th>
                                </tr>
                        </thead>
                    <tbody>
                        <?php $index = 1;
                        $rows=$param['rows']?>
                        <?php if($rows)
                        foreach($rows as $r) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $r['title']; ?></td>
                                <td><?= $r['path']; ?></td>
                                <td>
                                    <a class="badge badge-success" style="font-size:14px;" href="<?= site_url('admin/editdef/'.$r['id']); ?>">تعديل</a>
                                   <?php if($r['id']>1){?> <a class="badge badge-danger" style="font-size:14px;" href="#!" onclick="deleteConfirm('<?= site_url('admin/deletedef/'.$r['id']); ?>')">حذف</a>
                            <?php }else echo '';?>
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

<!-- Modal add new menu-->
<div class="modal fade" id="newDefModal" tabindex="-1" role="dialog" aria-labelledby="newDefModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newDefModalLabel">إضافة ثابت جديدة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- form -->
      <form action="<?= site_url('admin/adddef'); ?>" method="post">
        <div class="modal-body">
        <div class=" col-lg-12 ">

            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="الثابت">
            </div>
            <div class="form-group">
                <select name="menu_id" id="menu_id" class="form-control" >
                    <!--<option value="">---اختر التعريف الرئيسي---</option>-->
                    <?php $rows=$param['rows'];
                    foreach($rows as $r) : ?>
                        <option value="<?= $r['id']; ?>" <?php if($r['id']==1){echo 'selected';}else{echo '';}?>><?= $r['path']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">حفظ</button>
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