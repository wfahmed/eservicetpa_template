<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">
<?php
                    //    var_dump($param['rows'][0]['supplier_id']);?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
        </div>

        <div class="card col-lg-12 shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#newProjectModal"><i class="fas fa-plus"></i> إضافة مشروع</a></h6>
               
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark-ggreen">
                        <tr>
                            <th>#</th>
                            <th>الجهة الداعمة </th>
                            <th>نوع الدعم </th>
                            <th>تاريخ الاعتماد </th>
                            <th> قيمة الاعتماد بالدينار</th>
                            <th> قيمة الاعتماد $</th>
                            <th>إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rows=$param['rows'];//var_dump($rows);
                        if(isset($rows)){
                            $index = 1; ?>
                            <?php foreach($rows as $r) : ?>
                                <tr>
                                    <td><?= $index; ?></td>
                                    <td><?= $r['support_name']; ?></td>
                                    <td><?= $r['support_type']; ?></td>
                                    <td><?= $r['approved_date']; ?></td>
                                    <td><?= $r['approved_value']; ?></td>
                                    <td><?= $r['approved_amount']; ?></td>
                                    <td>
                                        <?php $encoded_data = urlencode($r['project_id'])?>
                                        <?php $encoded_data = $r['project_id']?>
                                        <a class="badge badge-success" style="font-size:14px;" href="<?= site_url('project/edit_project/'.$encoded_data); ?>">تعديل</a>
                                        <a class="badge badge-warning" style="font-size:14px;" href="<?= site_url('project/print_project/'.$encoded_data); ?>">تفاصيل</a>
                                        <a class="badge badge-danger" style="font-size:14px;" href="#!" onclick="deleteConfirm('<?= site_url('project/delete_project/'.$encoded_data); ?>')">حذف</a>
                                    </td>
                                </tr>
                                <?php $index++; ?>
                            <?php endforeach; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
</div>
<!-- End of Main Content -->

<!-- Modal add new ProjectModal-->

<div class="modal fade" id="newProjectModal" tabindex="-1" role="dialog" aria-labelledby="newProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">إضافة مشروع</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form -->
            <form id="project_form" action="<?= site_url('project/add_project'); ?>" method="post">
                <div class="modal-body ">
                    <div class=" col-lg-12 ">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <select name="support_id" id="support_id" class="form-control" required
                                    <option value="">---اختر الجهة---</option>
                                    <?php $supporting_bodies=$param['supporting_bodies'];
                                    foreach($supporting_bodies as $r) : ?>
                                        <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="exchange_value" name="exchange_value" title="قيمة التحويل " value="3.3" readonly required>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="approved_value" name="approved_value" placeholder="قيمة-دينار " required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="approved_amount" name="approved_amount" placeholder="قيمة $" readonly required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control datepicker" id="approved_date" name="approved_date" placeholder="تاريخ الاعتماد" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="received_from_sponsor" name="received_from_sponsor" value="0" placeholder="المبلغ المستلم">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="remain_from_sponsor" name="remain_from_sponsor" value="0" readonly placeholder="المبلغ المتبقى">
                            </div>

                        </div>
                        <div class="form-group row">
                            <textarea type="text" class="form-control styled-textarea" id="notes" name="notes" placeholder="تفاصيل"></textarea>
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
</div><?php
