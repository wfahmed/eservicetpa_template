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

    .center-text th {
        text-align: center;
    }
</style>
<div class="card-body form_style">
    <?php if(isset($param['user_row'])) $user_row=$param['user_row'];
    ?>

    <form id="healthForm" action="<?= site_url('cv/add_health'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="user_id"  name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
        <input type="hidden" id="attach_id"  name="attach_id" value="" />
        <div class="form-group row">
            <div class="col-md-6">
                <label for="disability_type_id">نوع الإعاقة</label>
                <select name="disability_type_id" id="disability_type_id" class="form-control" required >
                    <?php $rows=$param['DISABILITY_STATUS'];
                    foreach($rows as $r) : ?>
                        <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="health_status_id ">الوضع الصحي</label>
                <select name="health_status_id" id="health_status_id" class="form-control" required >
                    <?php $rows=$param['HEALTH'];
                    foreach($rows as $r) : ?>
                        <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
        <div class="form-group row">
            <div class="col-md-6 ">
                <label for="health_details">تفاصيل</label>
                <textarea class="form-control" type="text" id="health_details" name="health_details" placeholder="تفاصيل" value="" ></textarea>
            </div>

            <div class="col-md-6">
                <label >
                    التقرير الصحي
                </label>
                <div class="row">
                    <div class="col-sm-3">
                       <a class="d-none" id="healthReport" href="#" target="_blank">افتح المرفق</a>
                    </div>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label" for="file">أدخل الملف</label>
                        </div>
                    </div>
                </div>
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
                <thead class="thead-dark-c center-text">
                <tr>
                    <th>#</th>
                    <th>الإعاقة </th>
                    <th>الوضع الصحي </th>
                    <th>تفاصيل </th>
                    <th>نوع المرفق </th>
                    <th>المرفق </th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1; $rows=$param['health']?>
                <?php
                if(isset($rows)){
                    foreach($rows as $r) : ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $r['disability_type']; ?></td>
                            <td><?= $r['health_status']; ?></td>
                            <td><?= $r['health_details']; ?></td>
                            <td><?= $r['attach_type']; ?></td>
                            <td>   <?php if (!empty($r['attach_path'])): ?>
                                    <a href="<?= base_url($r['attach_path']); ?>" target="_blank">افتح المرفق</a>
                                <?php else: ?>

                                <?php endif; ?></td>
                            <td>
                                <a  class="badge badge-success" style="font-size:14px; color: white;" onclick="getHealthDetails('<?=$r['health_id'];?>')">تعديل</a>
                                <a  class="badge badge-danger" style="font-size:14px; color: white;" onclick="deleteConfirm('<?php echo site_url('cv/delete_health/'.$r['health_id'].'/'.$param['user_row']['id'].'/'.'1');?>')">حذف</a>
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