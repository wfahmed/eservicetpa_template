<?php if(isset($param['user_row'])) $user_row=$param['user_row'];
?>
<form id="father_form" action="<?= site_url('member/edit_member/'.$user_row['id']); ?>" method="post">

    <input type="hidden" id="user_id"  name="user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
    <!-- edit title -->
    <div class="form-group row">
        <div class="col-md-2.4" style="padding-left: 3px;padding-right: 2px;">
            <label for="identity">رقم الهوية</label>
            <input class="form-control" type="text" id="identity"  name="identity" placeholder="رقم الهوية " value="<?php if($user_row)echo $user_row['identity'];else echo '' ?>" maxlength="9" minlength="9" required/>
        </div>
        <div class="col-md-2.4" style="padding-left: 3px;">
            <label for="fname">الاسم الأول</label>
            <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="<?php if($user_row)echo $user_row['fname'];else echo '' ?>" required/>
            <div id="fnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2.4" style="padding-left: 3px;">
            <label for="sname">الاسم الثاني</label>
            <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" value="<?php if($user_row)echo $user_row['sname'];else echo '' ?>" required/>
            <div id="snameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2.4" style="padding-left: 3px;">
            <label for="tname">الاسم الثالث</label>
            <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" value="<?php if($user_row)echo $user_row['tname'];else echo '' ?>" required />
            <div id="tnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
        <div class="col-md-2.4" style="padding-left: 3px;">
            <label for="lname">الاسم الرابع</label>
            <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" value="<?php if($user_row)echo $user_row['lname'];else echo '' ?>" required/>
            <div id="lnameError" class="error-message-custom ">الاسم يحتوي على الحروف</div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="dob_father">تاريخ الميلاد</label>
            <input class="form-control datepicker" type="text" id="dob_father"  name="dob_father" placeholder="تاريخ الميلاد" value="<?=$user_row['dob']?>" required minlength="9" maxlength="9"/>
        </div>
        <div class="col-md-3">
            <label for="user_status">حالة الأب</label>
            <select name="user_status" id="user_status" class="form-control" required>
                <?php
                $rows=$param['PARENT_STATUS'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['user_status_id']){
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
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['maretal_status_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="naturalwork">طبيعة العمل</label>
            <select name="naturalwork" id="naturalwork" class="form-control" required>

                <?php $rows=$param['NATURAL_WORK'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['naturalwork_id']){
                        echo 'selected' ;} else echo '' ;
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-3">
            <label for="father_death_date">تاريخ الوفاة</label>
            <input placeholder="أدخل تاريخ الوفاة" type="text" class="form-control datepicker"
                   name="father_death_date" id="father_death_date"value="<?php if($user_row)echo $user_row['death_date'];else echo '' ?>" >
        </div>
        <div class="col-md-3">
            <label for="death_reason">سبب الوفاة</label>
            <select name="death_reason" id="death_reason" class="form-control select2" >
                <option value="0">اختر السبب</option>
                <?php $rows=$param['DEATH_REASON'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>"<?php if($user_row)if($r['id']== $user_row['death_reason_id']){
                        echo 'selected' ;} else echo '' ;
                    ?> ><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="col-md-3">
            <label for="incom">قيمة الدخل قبل 7 اكتوبر</label>
            <input class="form-control" type="text" id="incom" name="incom" placeholder="الدخل قبل الوفاة " value="<?php if($user_row){echo $user_row['incom'];}else echo '0' ?>" required/>
        </div>
        <div class="col-md-3">
            <label for="incom">قيمة الدخل بعد 7 اكتوبر</label>
            <input class="form-control" type="text" id="after_death_incom" name="after_death_incom" placeholder="الدخل بعد الوفاة " value="<?php if($user_row)echo $user_row['after_death_incom'];else echo '0' ?>" required/>
        </div>
    </div>

    <div class="form-group row">

        <div class="col-md-4   mb-3 mb-sm-0">
            <label  > المواطنة</label>
            <div class="form-check col-sm-12">
                <input class="form-check-input" type="radio" name="asylum_status" id="Refugee" value="1" required
                    <?php if( $user_row['asylum_status_id']=='1'){
                        echo 'checked' ; }
                    ?> >
                <label class="form-check-label" for="Refugee">لاجىء</label>
                <input class="form-check-input" type="radio" name="asylum_status" id="Citizen" value="2"
                    <?php
                    if( $user_row['asylum_status_id']=='2'){
                        echo 'checked' ;} ?>>
                <label class="form-check-label" for="Citizen"> مواطن</label>
            </div>
        </div>
        <div class="col-md-4 d-none  mb-3 mb-sm-0">
            <label >الجنس </label>
            <div class="form-check col-sm-12">
                <input class="form-check-input" type="radio" name="gender" id="male" value="1" required
                    <?php if( $user_row['gender_id']=='1'){
                        echo 'checked' ; }
                    ?> >
                <label class="form-check-label" for="Refugee">ذكر</label>
                <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                    <?php
                    if( $user_row['gender_id']=='2'){
                        echo 'checked' ;} ?>>
                <label class="form-check-label" for="Citizen"> أنثى</label>
            </div>
        </div>
    </div>
    <br>
    <!-- btn -->
    <div class="form-footer">
        <input class="btn btn-success" type="submit" id="submitBtn" name="btn" value="حفظ " />
    </div>
</form>