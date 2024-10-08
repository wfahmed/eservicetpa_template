<!-- Begin Page Content -->
<div class="container-fluid">
<?php
$row=$param['row'];
?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-lg-12">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('project/supplier') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <!-- form -->
            <form id="supply_form" action="<?= site_url('supplier/edit_supplier/'.urlencode($row['supplier_id'])); ?>" method="post">
                <input type="hidden" name="supplier_id" id="supplier_id" value="<?= $row['supplier_id']; ?>" />
                    <div class=" col-lg-12 ">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label for="menu">الاسم</label>
                                <input type="text" value="<?= $row['supplier_name']; ?>"  class="form-control" id="supplier_name" name="supplier_name" placeholder="الاسم" required>
                            </div>
                            <div class="col-md-4">
                                <label for="menu">اسم التخاطب</label>
                                <input type="text" value="<?= $row['contact_name']; ?>" class="form-control" id="contact_name" name="contact_name" placeholder="اسم التخاطب">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="menu">الايميل </label>
                                <input type="text" value="<?= $row['contact_email']; ?>" class="form-control" id="contact_email" name="contact_email" placeholder="البريد ">
                            </div>
                            <div class="col-md-6">
                                <label for="menu">جوال </label>
                                <input type="text" value="<?= $row['contact_phone']; ?>"  class="form-control" id="contact_phone" name="contact_phone" placeholder="جوال">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="menu">الدولة </label>
                                <input type="text" value="<?= $row['country']; ?>"  class="form-control" id="country" name="country" placeholder="دولة">
                            </div>
                            <div class="col-md-4">
                                <label for="menu">ولاية </label>
                                <input type="text" value="<?= $row['state']; ?>"class="form-control" id="state" name="state" placeholder="ولاية">
                            </div>
                            <div class="col-md-4">
                                <label for="menu">مدينة </label>
                                <input type="text" value="<?= $row['city']; ?>" class="form-control" id="city" name="city" placeholder="مدينة">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="menu">عنوان </label>
                            <input type="text" value="<?= $row['address']; ?>" class="form-control" id="address" name="address" placeholder="عنوان">
                        </div>
                        <div class="form-group row">
                            <label for="menu">رمز بريدي </label>
                            <input type="text" value="<?= $row['postal_code']; ?>" class="form-control" id="postal_code" name="postal_code" placeholder="رمز بريدي">
                        </div>
                        <div class="form-group row">
                            <label for="menu">موقع إلكتروني </label>
                            <input type="text" value="<?= $row['website']; ?>" class="form-control" id="website" name="website" placeholder="موقع إلكتروني">
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->