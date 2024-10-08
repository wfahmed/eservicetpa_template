<?php
if(isset($param['user_row'])) $user_row=$param['user_row'];
if(isset($param['user_child_row'])) $user_child_row=$param['user_child_row'];
if(isset($param['child']))  $child=$param['child'];
?>

<div class="accordion" id="accordionExample">
<div class="card">
    <div class="card-header " id="headingOne" style="background-color: #938686;">
        <h2 class="mb-0">
            <a style="color: aliceblue;font-weight: bold" class="" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                إضافة ابن/ة
            </a>
        </h2>
    </div>
    <div id="collapseOne" class="collapse <?php if(empty($user_child_row) )echo 'show';?>" aria-labelledby="headingOne" data-parent="#accordionExample">
    <div class="card-body ">
<form id="child_form" action="<?= site_url('member/add_member/'.$user_row['id'].'/5'); ?>" method="post">
    <input class="" type="hidden" name="gender" id="gender" value="أنثى" required >
    <input type="hidden" name="parent_user_id" id="parent_user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
    <!-- edit title -->
    <div class="form-group row">
        <div class="col-md-2.1" style="padding-left: 1px;padding-right: 0px;">
            <label for="identity">رقم الهوية</label>
            <input class="form-control" type="text" id="identity"  name="identity" placeholder="رقم الهوية " value="" maxlength="9" minlength="9" required/>
        </div>
        <div class="col-md-2" style="padding-left: 10px;">
            <label for="fname">الاسم الأول</label>
            <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="" required/>
            <div id="fnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2.1" style="padding-left: 10px;">
            <label for="sname">الاسم الثاني</label>
            <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" readonly value="<?php if($user_row)echo $user_row['fname'];else echo '' ?>" required/>
            <div id="snameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2.1" style="padding-left: 10px;">
            <label for="tname">الاسم الثالث</label>
            <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" readonly value="<?php if($user_row)echo $user_row['sname'];else echo '' ?>" required />
            <div id="tnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2" style="padding-left: 2px;">
            <label for="lname">الاسم الرابع</label>
            <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" readonly value="<?php if($user_row)echo $user_row['lname'];else echo '' ?>" required/>
            <div id="lnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
    </div>

    <div class="form-group row">

        <div class="col-md-3" >
            <label for="mother_user_id">الأم</label>
            <select name="mother_user_id" id="mother_user_id" class="form-control" required>
                <?php
                $rows=$param['wife'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['mother_user_id']){
                        echo 'selected' ;}
                    ?>><?= $r['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="dob_child">تاريخ الميلاد</label>
            <input class="form-control datepicker" type="text" id="dob_child"  name="dob_child" placeholder="تاريخ الميلاد" value="" required minlength="9" maxlength="9"/>
        </div>
        <div class="col-md-3">
            <label for="user_status">حالة الابن/ة</label>
            <select name="user_status" id="user_status" class="form-control" required>
                <?php
                $rows=$param['PARENT_STATUS'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3" hidden>
            <label for="relation_type_id">العلاقة</label>
            <select name="relation_type_id" id="relation_type_id" class="form-control" required>
                <?php
                $rows=$param['RELATION'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['relation_type_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="maretal_status">الحالة الإجتماعية</label>
            <select name="maretal_status" id="maretal_status" class="form-control" required>
                <?php
                $rows=$param['MARETAL_STATUS'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">


        <div class="col-md-3 d-none">
            <label for="naturalwork">طبيعة العمل</label>
            <select name="naturalwork" id="naturalwork" class="form-control" required>

                <?php $rows=$param['NATURAL_WORK'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-none  mb-3 mb-sm-0">
            <label  > المواطنة</label>
            <div class="form-check col-sm-12">
                <input class="form-check-input" type="radio" name="asylum_status" id="Refugee" value="1" required
                       checked  >
                <label class="form-check-label" for="Refugee">لاجىء</label>
                <input class="form-check-input" type="radio" name="asylum_status" id="Citizen" value="2">
                <label class="form-check-label" for="Citizen"> مواطن</label>
            </div>
        </div>
        <div class="col-md-3   mb-3 mb-sm-0">
            <label >الجنس </label>
            <div class="form-check col-sm-12">
                <input class="form-check-input" type="radio" name="gender" id="male" value="1" checked required
                >
                <label class="form-check-label" for="Refugee">ذكر</label>
                <input class="form-check-input" type="radio" name="gender" id="female" value="2" >
                <label class="form-check-label" for="Citizen"> أنثى</label>
            </div>
        </div>
    </div>
    <div class="form-group row d-none">
        <div class="col-md-3">
            <label for="child_death_date">تاريخ الوفاة</label>
            <input placeholder="أدخل تاريخ الوفاة" type="text" class="form-control datepicker"
                   name="child_death_date" id="child_death_date"value="" >
        </div>
        <div class="col-md-3">
            <label for="death_reason">سبب الوفاة</label>
            <select name="death_reason" id="death_reason" class="form-control select2" placeholder="اختر سبب" >
                <option>اختر سبب</option>
                <?php $rows=$param['DEATH_REASON'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="col-md-3">
            <label for="incom">الدخل قبل الوفاة</label>
            <input class="form-control" type="text" id="incom" name="incom" placeholder="الدخل قبل الوفاة " value="" />
        </div>
        <div class="col-md-3">
            <label for="after_death_incom">الدخل بعد الوفاة</label>
            <input class="form-control" type="text" id="after_death_incom" name="after_death_incom" placeholder="الدخل بعد الوفاة " value="" />
        </div>
    </div>


    <br>
    <!-- btn -->
    <div class="form-footer">
        <input class="btn btn-success" type="submit" id="submitBtn"  name="btn" value="حفظ " />
    </div>
</form>
</div>
</div>
</div>
<br>
<?php  if(!empty($user_child_row) ){ ?>
<div class="card">
    <div class="card-header" id="headingTwo" style="background-color: #937a7a;">
        <h2 class="mb-0">
            <a style="color: aliceblue;font-weight: bold"
                    class="collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                تفاصيل ابن/ة
            </a>
        </h2>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">

    <div class="card-body ">

        <form id="child_details_form"
              action="<?= site_url('member/edit_member/'.$user_child_row['id'].'/5' );?>" method="post">

            <input type="hidden" id="user_id"  name="user_id" value="<?php if($user_child_row)echo $user_child_row['id'];else echo '0' ?>" />
            <input type="hidden" id="parent_user_id" name="parent_user_id" value="<?php if($user_child_row)echo $user_child_row['parent_user_id'];else echo '0' ?>" />
            <!-- edit title -->
            <div class="form-group row">
                    <div class="col-md-2" style="padding-left: 10px;padding-right: 0px;">
                        <label for="identity">رقم الهوية</label>
                    <input class="form-control" type="text" id="identity"  name="identity" placeholder="رقم الهوية " value="<?php if($user_child_row)echo $user_child_row['identity'];else echo '' ?>" maxlength="9" minlength="9" required/>
                </div>

                    <div class="col-md-2.1" style="padding-left: 10px;">
                    <label for="fname">الاسم الأول</label>
                    <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="<?php if($user_child_row)echo $user_child_row['fname'];else echo '' ?>" required/>
                        <div id="fnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                </div>
                    <div class="col-md-2.1" style="padding-left: 10px;">
                    <label for="sname">الاسم الثاني</label>
                    <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" value="<?php if($user_child_row)echo $user_child_row['sname'];else echo '' ?>" required/>
                        <div id="snameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                </div>
                    <div class="col-md-2.1" style="padding-left: 10px;">
                    <label for="tname">الاسم الثالث</label>
                    <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" value="<?php if($user_child_row)echo $user_child_row['tname'];else echo '' ?>" required />
                        <div id="tnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                </div>
                    <div class="col-md-2" style="padding-left: 10px;">
                    <label for="lname">الاسم الرابع</label>
                    <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" value="<?php if($user_child_row)echo $user_child_row['lname'];else echo '' ?>" required/>
                        <div id="lnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-3" >
                    <label for="mother_user_id">الأم</label>
                    <select name="mother_user_id" id="mother_user_id" class="form-control" required>
                        <?php
                        $rows=$param['wife'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['mother_user_id']){
                                echo 'selected' ;}
                            ?>><?= $r['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="dob_child_detail">تاريخ الميلاد</label>
                    <input class="form-control datepicker" type="text" id="dob_child_detail"  name="dob_child_detail" placeholder="تاريخ الميلاد" value="<?=$user_child_row['dob']?>" required minlength="9" maxlength="9"/>
                </div>
                <div class="col-md-3">
                    <label for="user_status">حالة الابن/ة</label>
                    <select name="user_status" id="user_status" class="form-control" required>
                        <?php
                        $rows=$param['PARENT_STATUS'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['user_status_id']){
                                echo 'selected' ;}
                            ?>><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="maretal_status">الحالة الإجتماعية</label>
                    <select name="maretal_status" id="maretal_status" class="form-control" required>
                        <?php
                        $rows=$param['MARETAL_STATUS'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['maretal_status_id']){
                                echo 'selected' ;}
                            ?>><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">

                <div class="col-md-3 d-none">
                    <label for="relation_type_id">العلاقة</label>
                    <select name="relation_type_id" id="relation_type_id" class="form-control" readonly>
                        <?php
                        $rows=$param['RELATION'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['relation_type_id']){
                                echo 'selected' ;}
                            ?>><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-none">
                    <label for="naturalwork">طبيعة العمل</label>
                    <select name="naturalwork" id="naturalwork" class="form-control" required>

                        <?php $rows=$param['NATURAL_WORK'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($user_child_row)if($r['id']== $user_child_row['naturalwork_id']){
                                echo 'selected' ;} else echo '' ;
                            ?>><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-none  mb-3 mb-sm-0">
                    <label  > المواطنة</label>
                    <div class="form-check col-sm-12">
                        <input class="form-check-input" type="radio" name="asylum_status" id="Refugee" value="1" required
                            <?php if( $user_child_row['asylum_status_id']=='1'){
                                echo 'checked' ; }
                            ?> >
                        <label class="form-check-label" for="Refugee">لاجىء</label>
                        <input class="form-check-input" type="radio" name="asylum_status" id="Citizen" value="2"
                            <?php
                            if( $user_child_row['asylum_status_id']=='2'){
                                echo 'checked' ;} ?>>
                        <label class="form-check-label" for="Citizen"> مواطن</label>
                    </div>
                </div>
                <div class="col-md-3   mb-3 mb-sm-0">
                    <label >الجنس </label>
                    <div class="form-check col-sm-12">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="1" required
                            <?php if( $user_child_row['gender_id']=='1'){
                                echo 'checked' ; }
                            ?> >
                        <label class="form-check-label" for="Refugee">ذكر</label>
                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                            <?php
                            if( $user_child_row['gender_id']=='2'){
                                echo 'checked' ;} ?>>
                        <label class="form-check-label" for="Citizen"> أنثى</label>
                    </div>
                </div>
            </div>

            <div class="form-group row   d-none">
                <div class="col-md-3">
                    <label for="child_death_date_detail">تاريخ الوفاة</label>
                    <input placeholder="أدخل تاريخ الوفاة" type="text" class="form-control datepicker"
                           name="child_death_date_detail" id="child_death_date_detail"value="<?php if($user_child_row)echo $user_child_row['death_date'];else echo '' ?>" >
                </div>
                <div class="col-md-3">
                    <label for="death_reason">سبب الوفاة</label>
                    <select name="death_reason" id="death_reason" class="form-control select2" >
                        <option value="0">اختر السبب</option>
                        <?php $rows=$param['DEATH_REASON'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>"<?php if($user_child_row)if($r['id']== $user_child_row['death_reason_id']){
                                echo 'selected' ;} else echo '' ;
                            ?> ><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <div class="col-md-3">
                    <label for="incom">الدخل قبل الوفاة</label>
                    <input class="form-control" type="text" id="incom" name="incom" placeholder="الدخل قبل الوفاة " value="<?php if($user_child_row){echo $user_child_row['incom'];}else echo '0' ?>" required/>
                </div>
                <div class="col-md-3">
                    <label for="after_death_incom">الدخل بعد الوفاة</label>
                    <input class="form-control" type="text" id="after_death_incom" name="after_death_incom" placeholder="الدخل بعد الوفاة " value="<?php if($user_child_row)echo $user_child_row['after_death_incom'];else echo '0' ?>" required/>
                </div>
            </div>


            <br>
            <!-- btn -->
            <div class="form-footer">
                <input class="btn btn-success" type="submit" id="submitBtn"  name="btn" value="حفظ " />
            </div>
        </form>
    </div>
    </div>
</div>
<?php  }?>
</div>
<?php  if(isset($child)&& count($child)>=1){ ?>
<div class="card">
    <div class="card-header py-3"> </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark-c">
                <tr>
                    <th>#</th>
                    <th>اسم الابن/ة</th>
                    <th>رقم الهوية </th>
                    <th>تاريخ الميلاد  </th>
                    <th>العلاقة</th>
                    <th>الأم</th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1;?>
                <?php
                if(isset($child)){
                    foreach($child as $r) : ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $r['full_name']; ?></td>
                            <td><?= $r['identity']; ?></td>
                            <td><?= $r['dob']; ?></td>
                            <td><?= $r['relation_type']; ?></td>
                            <td><?= $r['mother']; ?></td>
                            <td>
                                <a class="badge badge-success btn-style" onclick="getChildDetails(<?=$r['uid']?>)" href="#">تعديل</a>
                                <a class="badge badge-primary btn-style " href="<?= site_url('member/detailmember/'.$r['uid']); ?>">تفاصيل</a>
                                <a class="badge badge-warning btn-style " href="<?= site_url('user/edit/'.$r['uid']); ?>">الصورة </a>
                                <a class="badge  btn-style " style="background-color:#194616" href="<?= site_url('agent/index/'.$r['uid']); ?>">الوكيل</a>
                                <a class="badge  btn-style" style="background-color:#1d5441" href="<?= site_url('cv/index/'.$r['uid']); ?>">السيرة الذاتية</a>
                                <a class="badge badge-danger btn-style" onclick="deleteConfirm(<?=$r['uid']?>)"
                                   href="<?= site_url('member/deletemember/'.$r['uid'].'/5'.'/'.$r['parent_user_id']); ?>">حذف</a>
                            </td>
                        </tr>
                        <?php $index++; ?>
                    <?php endforeach; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <?php  }?>