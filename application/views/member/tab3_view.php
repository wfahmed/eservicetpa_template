<?php if(isset($param['user_row'])) $user_row=$param['user_row'];
$rows=$param['PARENT_STATUS'];
?>
<style>
    /* Change the font size and weight of the optgroup label */
    .dropdown .dropdown-menu .dropdown-header{
        text-align: center;
        color:#948585;
        font-size: medium;
        font-weight: bolder;
    }
</style>
<form id="dwelling_form" action="<?= site_url('member/edit_dwelling/'.$user_row['id']); ?>"
      data-edit-mode="true" data-selected-general-area-id="<?= $user_row['general_area_id']; ?>"
      data-selected-land-id="<?= $user_row['nearest_famous_place']; ?>"
      data-selected-city-id="<?= $user_row['city_id']; ; ?>" data-selected-local-area-id="<?= $user_row['local_area_id']; ?>"
      method="post">
    <input class="form-control" type="hidden" name="governorate" id="governorate" placeholder="مدينة" value="<?=$user_row['general_area_id'] ?>" required/>
    <input type="hidden" name="user_id" value="<?php if($user_row)echo $user_row['id'];else echo '0' ?>" />
    <?php $groups=$param['GOVERNORATES'];?>
    <!-- edit title -->
    <h2 class="section-header" style=" color: #333; border-bottom: 2px solid #ccc;">السكن الأصلي</h2>
    <div class="form-group row">
        <div class="col-md-3">
            <label for="city_id">محافظة / مدينة</label>
            <select name="city_id" id="city_id" class="form-control  selectpicker" data-live-search="true"
                    title="اختر..."  required>
                <?php foreach ($groups as $element): ?>
                    <?php if (isset($element['children'])): ?>
                        <optgroup label="<?= $element['title']; ?>">
                            <?php foreach ($element['children'] as $child): ?>
                                <option data-gov="<?= $child['parent_id']; ?>" value="<?= $child['id']; ?>"><?= $child['title']; ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php else: ?>
                        <option value="<?= $element['id']; ?>"><?= $element['title']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

        </div>
        <div class="col-md-3">
            <label for="general_area_id">منطقة</label>
            <select   title="اختر..."  style="display:none;"  class="form-control selectpicker" data-live-search="true"
                      type="text" name="general_area_id" id="general_area_id"   required>

            </select>
        </div>
        <div class="col-md-3">
            <label for="local_area_id">حي</label>
            <select style="display:none;"   title="اختر..."  class="form-control selectpicker" data-live-search="true"
                    type="text" name="local_area_id" id="local_area_id"   required>

            </select>
        </div>
        <div class="col-md-3">
            <label for="nearest_famous_place">أقرب معلم</label>
            <select style="display:none;"   title="اختر..."  class="form-control selectpicker" data-live-search="true"
                    type="text" name="nearest_famous_place" id="nearest_famous_place"   >

            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <label for="mosque">معلم مدخل -سابقا</label>
            <input class="form-control" type="text" id="mosque" name="mosque" placeholder="مسجد"  value="<?php if($user_row)echo $user_row['mosque'];else echo '' ?>" />
        </div>
        <div class="col-md-4 ">
            <label for="detailed_original_housing_address">عنوان</label>
            <input class="form-control" type="text" id="detailed_original_housing_address" name="detailed_original_housing_address" placeholder="مسجد"  value="<?php if($user_row)echo $user_row['detailed_original_housing_address'];else echo '' ?>" />
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
        <div class="col-md-4  ">
                <label for="current_residence">عنوان</label>
                <input class="form-control" type="text" id="current_residence" name="current_residence" placeholder="مسجد"  value="<?php if($user_row)echo $user_row['current_residence'];else echo '' ?>" />

        </div>
        <div class="col-md-4  d-none">
            <label for="current_residence">منطقة رئيسية</label>
            <select name="current_governorate_id" id="current_governorate_id" class="form-control" required>
                <?php $rows=$param['GOVERNORATES'];
                foreach($rows as $r) : ?>
                    <option value="<?= $r['id']; ?>" <?php if($user_row)if($r['id']== $user_row['current_governorate_id']){
                        echo 'selected' ;}
                    ?>><?= $r['title']; ?></option>
                <?php endforeach; ?>
            </select>

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
