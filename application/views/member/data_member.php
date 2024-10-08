<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>
<style>

</style>
<!-- Begin Page Content -->
<div class="container-fluid">
<?php
$user_members=$param['user_members'];
?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead
                            <?php
                            switch ($param['condition']) {
                                case 'emp':
                                    echo 'class="thead-dark-gblue"';
                                    break;
                                case 'all':
                                    echo 'class="thead-dark-orange"';
                                    break;
                                case 'family':
                                    echo 'class="thead-dark-ggreen"';
                                    break;
                                case 'family_orphan':
                                    echo 'class="thead-dark-ggreen"';
                                    break;
                                case 'child':
                                    echo 'class="thead-dark-purble"';
                                    break;
                                default:
                                  echo 'class="thead-dark"';
                                    return;
                            }?> >
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>عدد افراد الاسرة</th>
                                    <th>الحالة</th>
                                    <th>اجراءات</th>
                                </tr>
                        </thead>
                    <tbody>
                        <?php $index = 1; ?>
                        <?php foreach($user_members as $um) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $um['full_name']; ?></td>
                                <td><?= $um['total_member_no']; ?></td>
                                <td>
                                    <?php if ($um['is_active'] == 1) {
                                        echo 'Active';
                                    } else {
                                        echo 'InActive';
                                    } 
                                    ?>
                                </td>
                                <td>
                                    <a class="badge badge-primary btn-style " href="<?= site_url('member/detailmember/'.$um['id']); ?>">تفاصيل</a>
                                    <?php if (in_array($param['condition'], ['family_orphan', 'family'])) {?>
                                    <a class="badge badge-success btn-style"  href="<?= site_url('member/edit_member/'.$um['id']); ?>">إدارة الأسرة</a>

                                    <a class="badge  btn-style" style="background-color:#1d5441" href="<?= site_url('cv/index/'.$um['id']); ?>">السيرة الذاتية</a>
                                    <?php }?>
                                    <a class="badge badge-warning btn-style"  href="<?= site_url('member/editmember/'.$um['id']); ?>">الحالة</a>
                                    <a class="badge badge-danger btn-style"  href="#!" onclick="deleteConfirm('<?= site_url('member/deletemember/'.$um['id']); ?>')">حذف</a>
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

<!-- modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Deleted data cannot be recovered!</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Remove</a>
      </div>
    </div>
  </div>
</div>