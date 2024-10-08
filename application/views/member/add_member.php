<!-- Begin Page Content -->
<div class="container-fluid">
    <?php

    if(isset($param['user']))
    {
        $user=$param['user'];
    }?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>

    <div class="card col-lg-12 shadow mb-4">
        <div class="card-body">
            <div class="tab-container">
                <ul class="tab-menu">
                    <li class=" " data-tab="tab_father">بيانات رب الأسرة</li>
                </ul>

                <div class="tab-content-menu">
                    <div id="tab_father" class="tab active">
                        <form action="<?= site_url('member/add_member'); ?>" method="post">
                            <input type="hidden" name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
                            <!-- edit title -->
                            <div class="form-group row">
                                <div class="col-md-2.4" style="padding-left: 21px;padding-right: 12px;">
                                    <label for="identity">رقم الهوية</label>
                                    <input class="form-control" type="text" id="identity"  name="identity" placeholder="رقم الهوية " value="" required minlength="9" maxlength="9"/>
                                </div>
                                <div class="col-md-2" style="padding-left: 21px;">
                                <label for="fname">الاسم الأول</label>
                                <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="" required/>
                                    <div id="fnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                            </div>
                                <div class="col-md-2 " style="padding-left: 21px;">
                                <label for="sname">الاسم الثاني</label>
                                <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" value="" required/>
                                    <div id="snameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                            </div>
                                <div class="col-md-2.4" style="padding-left: 21px;">
                                    <label for="tname">الاسم الثالث</label>
                                    <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" value="" required />
                                    <div id="tnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                                </div>
                                <div class="col-md-2.4" style="padding-left: 21px;">
                                    <label for="lname">الاسم الرابع</label>
                                    <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" value="" required/>
                                    <div id="lnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-3" style="padding-right: 10px;">
                                    <label for="dob">تاريخ الميلاد</label>
                                    <input class="form-control datepicker" type="text" id="dob"  name="dob" placeholder="تاريخ الميلاد" value="" required minlength="9" maxlength="9"/>
                                </div>
                                <div class="col-md-3" >
                                    <label for="user_status">حالة الأب</label>
                                    <select name="user_status" id="user_status" class="form-control" required>
                                        <?php $rows=$param['PARENT_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3" >
                                    <label for="maretal_status">الحالة الإجتماعية</label>
                                    <select name="maretal_status" id="maretal_status" class="form-control" required>
                                        <?php
                                        $rows=$param['MARETAL_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3" >
                                    <label for="naturalwork">طبيعة العمل</label>
                                    <select name="naturalwork" id="naturalwork" class="form-control" required>

                                        <?php $rows=$param['NATURAL_WORK'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="death_date">تاريخ الوفاة</label>
                                    <input placeholder="أدخل تاريخ الوفاة" type="text" class="form-control datepicker"
                                           name="death_date" id="death_date" >
                                </div>
                                <div class="col-md-3">
                                    <label for="death_reason">سبب الوفاة</label>
                                    <select name="death_reason" id="death_reason" class="form-control" >
                                        <option value="0">أختر السبب</option>
                                        <?php $rows=$param['DEATH_REASON'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <label for="incom">قيمة الدخل قبل 7 اكتوبر</label>
                                    <input class="form-control" type="text" id="incom" name="incom" placeholder="الدخل قبل الوفاة " value="0" />
                                </div>
                                <div class="col-md-3">
                                    <label for="incom">قيمة الدخل بعد 7 اكتوبر</label>
                                    <input class="form-control" type="text" id="after_death_incom" name="after_death_incom" placeholder="الدخل بعد الوفاة " value="0" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3   mb-3 mb-sm-0">
                                    <label > </label>
                                    <div class="form-check col-sm-12">

                                        <input class="form-check-input" type="radio" name="asylum_status" id="Refugee" value="1" checked>
                                        <label class="form-check-label" for="Refugee">لاجىء</label>
                                        <input class="form-check-input" type="radio" name="asylum_status" id="Citizen" value="2">
                                        <label class="form-check-label" for="Citizen"> مواطن</label>
                                    </div>
                                </div>
                            </div>
                            <!-- btn -->
                            <div class="form-footer">
                                <input class="btn btn-success" type="submit" id="submitBtn"  name="btn" value="حفظ " />
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->