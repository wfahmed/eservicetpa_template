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
                <h6 class="m-0 font-weight-bold text-primary"><a href="" data-toggle="modal" data-target="#newSupplierModal"><i class="fas fa-plus"></i> إضافة مورد</a></h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark-gblue">
                        <tr>
                            <th>#</th>
                            <th>الاسم </th>
                            <th>اسم المخاطبة </th>
                            <th>جوال</th>
                            <th>عنوان</th>
                            <th>إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $rows=$param['rows'];
                        if(isset($rows)){
                            $index = 1; ?>
                            <?php foreach($rows as $r) : ?>
                                <tr>
                                    <td><?= $index; ?></td>
                                    <td><?= $r['supplier_name']; ?></td>
                                    <td><?= $r['contact_name']; ?></td>
                                    <td><?= $r['contact_phone']; ?></td>
                                    <td><?= $r['address']; ?></td>
                                    <td>
                                        <?php //$encoded_data = urlencode($r['supplier_id'])?>
                                        <?php $encoded_data = $r['supplier_id'] ?>
                                        <a class="badge badge-success" style="font-size:14px;" href="<?= site_url('supplier/edit_supplier/'.$encoded_data); ?>">تعديل</a>
                                        <a class="badge badge-warning" style="font-size:14px;" href="<?= site_url('supplier/debts_supplier/'.$encoded_data); ?>">مديونية</a>
                                        <a class="badge badge-primary" style="font-size:14px;" href="<?= site_url('supplier/print_supplier/'.$encoded_data); ?>">طباعة</a>
                                        <a class="badge badge-danger" style="font-size:14px;" href="#!" onclick="deleteConfirm('<?= site_url('supplier/delete_supplier/'.$encoded_data); ?>')">حذف</a>
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

<!-- Modal add new SupplierModal-->

<div class="modal fade" id="newSupplierModal" tabindex="-1" role="dialog" aria-labelledby="newSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">إضافة مورد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form -->
            <form id="supply_form" action="<?= site_url('supplier/add_supplier'); ?>" method="post">
                <div class="modal-body ">
                    <div class=" col-lg-12 ">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="الاسم" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="contact_name" name="contact_name" placeholder="اسم التخاطب">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="contact_email" name="contact_email" placeholder="البريد ">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone" placeholder="جوال" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <input type="text" class="form-control" id="address" name="address" placeholder="عنوان" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="country" name="country" placeholder="دولة">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="state" name="state" placeholder="ولاية">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="city" name="city" placeholder="مدينة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="رمز بريدي">
                        </div>
                        <div class="form-group row">
                            <input type="text" class="form-control" id="website" name="website" placeholder="موقع إلكتروني">
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
