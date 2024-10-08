<?php if(isset($param['user_row'])) $user_row=$param['user_row'];
$rows=$param['PARENT_STATUS'];
?>

<form id="dwelling_form" action="<?= site_url('member/edit_dwelling/'.$user_row['id']); ?>" method="post">

    <input type="hidden" name="user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
    <!-- edit title -->
    <h2 class="section-header" style=" color: #333; border-bottom: 2px solid #ccc;">السكن الأصلي</h2>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="governorate">محافظة</label>
            <select name="governorate" id="governorate" class="form-control" required>
                <?php $rows=$param['GOVERNORATES'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['governorate_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="Local_area">مدينة</label>
            <input class="form-control" type="text" name="Local_area" id="Local_area" placeholder="مدينة" value="<?php if($user_row)echo $user_row['Local_area'];else echo '' ?>" required/>
        </div>
        <div class="col-md-4">
            <label for="original_residence">أقرب معلم</label>
            <input class="form-control" type="text" id="original_residence" name="original_residence"
                   placeholder="أقرب معلم" value="<?php if($user_row)echo $user_row['original_residence'];else echo '' ?>" required />
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="dwelling_nature">طبيعة المسكن</label>
            <select name="dwelling_nature" id="dwelling_nature" class="form-control" required>
                <?php $rows=$param['DWELLING_NATURE'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['dwelling_nature_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 ">
            <label for="dwelling_damage">حالة المسكن</label>
            <select name="dwelling_damage" id="dwelling_damage" class="form-control" required>
                <?php $rows=$param['DWELLING_STATUS'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['dwelling_damage_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>


    </div>


    <h2 class="section-header" style=" color: #333; border-bottom: 2px solid #ccc;">السكن الحالي</h2>
    <div class="form-group row">
        <div class="col-md-4">
            <label for="valley_side">التواجد الحالي</label>
            <select name="valley_side" id="valley_side" class="form-control" required>
                <?php $rows=$param['VALLEY_SIDE'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['valley_side_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="current_residence_status">المنطقة الحالية</label>
            <select name="current_residence_status" id="current_residence_status" class="form-control" required>
                <?php $rows=$param['CURRENT_RESIDENCE'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['current_residence_status_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4  d-none">
            <label for="current_governorate_id">محافظة</label>
            <select name="current_governorate_id" id="current_governorate_id" class="form-control" required>
                <?php $rows=$param['GOVERNORATES'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['current_governorate_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4  d-none">
            <label for="current_residence">مدينة</label>
            <input class="form-control" type="text" name="current_residence" id="current_residence" placeholder="مدينة" value="<?php if($user_row)echo $user_row['current_residence'];else echo '' ?>" required/>
        </div>
        <div class="col-md-4  d-none">
            <label for="nearest_famous_place">أقرب مسجد</label>
            <input class="form-control" type="text" name="nearest_famous_place" id="nearest_famous_place" placeholder="أقرب مسجد" value="<?php if($user_row)echo $user_row['nearest_famous_place'];else echo '' ?>" required/>
        </div>
    </div>

    <div class="form-group row">



    </div>
    <br>
    <!-- btn -->
    <div class="form-footer">
        <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
    </div>
</form>
