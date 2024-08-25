<style>
   .form_style{
       border: 1px solid #ddd; /* Border around the box */
       border-radius: 8px; /* Rounded corners */
       padding: 16px; /* Space inside the box */
       box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow effect */
       background-color: #fff; /* Background color */
   }
   .form-footer {
       display: flex;
       justify-content: center; /* Align buttons to the right */
       gap: 10px; /* Space between buttons */
   }

</style>
<script>
    function deleteContactConfirm(url){

        $('#btn-delete').attr('href', url);
        $('#deleteContactModal').modal();
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
    <?php $tab_id=$param['tab_id'] ;//var_dump($tab_id);die();?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('member/datamember') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <div class="tab-container">
                <div class="tab-links">
                    <div class="active-tab" data-tab="father" id="father_tab">بيانات رب الأسرة</div>
                    <div class=" " data-tab="contact" id="contact_tab">بيانات الإتصال</div>
                    <div class="" data-tab="dwelling" id="dwelling_tab">بيانات السكن</div>
                </div>


                    <div id="father" class="tab-content show ">  <?php if(isset($param['user_row'])) $user_row=$param['user_row'];?>
                        <form action="<?= site_url('member/edit_member/'.$user_row['id']); ?>" method="post">

                            <input type="hidden" name="user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
                            <!-- edit title -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                <label for="fname">الاسم الأول</label>
                                <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="<?php if($user_row)echo $user_row['fname'];else echo '' ?>" required/>
                            </div>
                                <div class="col-md-6 ">
                                <label for="sname">الاسم الثاني</label>
                                <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" value="<?php if($user_row)echo $user_row['sname'];else echo '' ?>" required/>
                            </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="tname">الاسم الثالث</label>
                                    <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" value="<?php if($user_row)echo $user_row['tname'];else echo '' ?>" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="lname">الاسم الرابع</label>
                                    <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" value="<?php if($user_row)echo $user_row['lname'];else echo '' ?>" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                <label for="identity">رقم الهوية</label>
                                <input class="form-control" type="text" id="identity"  name="identity" placeholder="رقم الهوية " value="<?php if($user_row)echo $user_row['identity'];else echo '' ?>" maxlength="9" minlength="9" required/>
                            </div>
                                <div class="col-md-6">
                                    <label for="user_status">حالة الأب</label>
                                    <select name="user_status" id="user_status" class="form-control" required>
                                        <?php $rows=$param['PARENT_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['user_status']){
                                              echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="death_date">تاريخ الوفاة</label>
                                    <input placeholder="أدخل تاريخ الوفاة" type="text" class="form-control datepicker"
                                           name="death_date" id="death_date"value="<?php if($user_row)echo $user_row['death_date'];else echo '' ?>" >
                                </div>
                                <div class="col-md-6">
                                    <label for="death_reason">سبب الوفاة</label>
                                    <select name="death_reason" id="death_reason" class="form-control" >
                                        <?php $rows=$param['DEATH_REASON'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"<?php if($user_row)if($r['id']== $user_row['death_reason']){
                                                echo 'selected' ;} else echo '' ;
                                            ?> ><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="incom">الدخل قبل الوفاة</label>
                                    <input class="form-control" type="text" id="incom" name="incom" placeholder="الدخل قبل الوفاة " value="<?php if($user_row){echo $user_row['incom'];}else echo '0' ?>" required/>
                                </div>
                                <div class="col-md-6">
                                    <label for="incom">الدخل بعد الوفاة</label>
                                    <input class="form-control" type="text" id="after_death_incom" name="after_death_incom" placeholder="الدخل بعد الوفاة " value="<?php if($user_row)echo $user_row['after_death_incom'];else echo '0' ?>" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="naturalwork">طبيعة العمل</label>
                                    <select name="naturalwork" id="naturalwork" class="form-control" required>

                                        <?php $rows=$param['NATURAL_WORK'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['naturalwork']){
                                                echo 'selected' ;} else echo '' ;
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6   mb-3 mb-sm-0">
                                    <label > </label>
                                    <div class="form-check col-sm-6">
                                        <input class="form-check-input" type="radio" name="asylum_status" id="Refugee" value="لاجىء"
                                            <?php if( $user_row['asylum_status']=='لاجىء'){
                                            echo 'checked' ; }
                                        ?> >
                                        <label class="form-check-label" for="Refugee">لاجىء</label>
                                        <input class="form-check-input" type="radio" name="asylum_status" id="Citizen" value="مواطن"
                                            <?php
                                                if( $user_row['asylum_status']=='مواطن'){
                                            echo 'checked' ;} ?>>
                                        <label class="form-check-label" for="Citizen"> مواطن</label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- btn -->
                            <div class="form-footer">
                            <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
                            </div>
                        </form>
                    </div>

                    <div id="contact"   class="tab-content">
                        <div class="card-body form_style">
                        <form id="contactForm" action="<?php echo site_url('member/add_contact'); ?>" method="post">
                            <input type="hidden" id="user_id"  name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="contact_type">نوع الاتصال</label>
                                    <select name="contact_type" id="contact_type" class="form-control" required>
                                        <?php $rows=$param['CONTACT_TYPE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 ">
                                    <label for="contact_value">القيمة</label>
                                    <input class="form-control" type="text" id="contact_value" name="contact_value" placeholder="الاتصال" value="" required/>
                                </div>

                            </div>
                            <div class="form-footer">
                                <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
                            </div>
                        </form>
                        </div>
                        <div class="card">
                        <div class="card-header py-3">
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark-c">
                                <tr>
                                    <th>#</th>
                                    <th>نوع الاتصال </th>
                                    <th>الاتصال </th>
                                    <th>إجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1; $contacts=$param['contacts']?>
                                <?php foreach($contacts as $con) : ?>
                                    <tr>
                                        <td><?= $index; ?></td>
                                        <td><?= $con['title']; ?></td>
                                        <td><?= $con['contact_value']; ?></td>
                                        <td>
                                            <a  class="badge badge-danger" style="font-size:14px; color: white;" onclick="deleteContactConfirm('<?php echo site_url('member/delete_member_contact/'.$con['id'].'/'.$param['user_row']['id'].'/'.'contact');?>')">حذف</a>
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

                    <div id="dwelling" class="tab-content">
                        <form id="dwelling_form" action="<?= site_url('member/edit_dwelling/'.$user_row['id']); ?>" method="post">

                            <input type="hidden" name="user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
                            <!-- edit title -->
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="original_residence">عنزان المسكن الأصلي</label>
                                    <input class="form-control" type="text" id="original_residence" name="original_residence"
                                           placeholder="عنوان المسكن الأصلي" value="<?php if($user_row)echo $user_row['original_residence'];else echo '' ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="dwelling_nature">طبيعة المسكن</label>
                                    <select name="dwelling_nature" id="dwelling_nature" class="form-control" required>
                                        <?php $rows=$param['DWELLING_NATURE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['dwelling_nature']){
                                                echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4 ">
                                    <label for="dwelling_damage">نوع الأضرار</label>
                                    <select name="dwelling_damage" id="dwelling_damage" class="form-control" required>
                                        <?php $rows=$param['DWELLING_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['dwelling_damage']){
                                                echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="current_residence_status">نوع الإقامة الحالية</label>
                                    <select name="current_residence_status" id="current_residence_status" class="form-control" required>
                                        <?php $rows=$param['CURRENT_RESIDENCE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['current_residence_status']){
                                                echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="current_residence">عنوان الإقامة الحالية</label>
                                    <input class="form-control" type="text" name="current_residence" id="current_residence" placeholder="عنوانالإقامة الحالية" value="<?php if($user_row)echo $user_row['current_residence'];else echo '' ?>" required/>
                                </div>
                                <div class="col-md-4">
                                    <label for="valley_side">موقعه من الوادي</label>
                                    <select name="valley_side" id="valley_side" class="form-control" required>
                                        <?php $rows=$param['VALLEY_SIDE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['valley_side']){
                                                echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="governorate">محافظة</label>
                                    <select name="governorate" id="governorate" class="form-control" required>
                                        <?php $rows=$param['GOVERNORATES'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['governorate']){
                                                echo 'selected' ;}
                                            ?>><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="nearest_famous_place">أقرب مسجد</label>
                                    <input class="form-control" type="text" name="nearest_famous_place" id="nearest_famous_place" placeholder="أقرب مسجد" value="<?php if($user_row)echo $user_row['nearest_famous_place'];else echo '' ?>" required/>
                                </div>
                                <div class="col-md-4">
                                    <label for="Local_area">المنطقة المحلية</label>
                                    <input class="form-control" type="text" name="Local_area" id="Local_area" placeholder="المنطقة المحلية " value="<?php if($user_row)echo $user_row['Local_area'];else echo '' ?>" required/>
                                </div>
                            </div>
                            <br>
                            <!-- btn -->
                            <div class="form-footer">
                                <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
                            </div>
                        </form>

                    </div>


            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<!-- modal delete -->
<div class="modal fade" id="deleteContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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