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

    <form id="eduForm" action="<?= site_url('cv/add_edu'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="user_id"  name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
        <input type="hidden" id="attach_id"  name="attach_id" value="" />
        <input type="hidden" id="edu_stage_id"  name="edu_stage_id" value="56" />
        <div class="form-group row">
            <div class="col-md-4">
                <label for="edu_level_id">المرحلة العلمية</label>
                <select name="edu_level_id" id="edu_level_id" class="form-control" required >
                    <?php $rows=$categories=$param['EDUCATION'];?>
                    <?php foreach ($rows as $categoryId => $category): ?>
                        <optgroup label="<?php echo htmlspecialchars($category['title']); ?>">
                            <?php foreach ($category['items'] as $item): ?>
                                <option data-parent="<?=$categoryId?>" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4 ">
                <label for="edu_details">تفاصيل</label>
                <textarea class="form-control" type="text" id="edu_details" name="edu_details" placeholder="تفاصيل" value="" ></textarea>
            </div>
            <div class="col-md-4">
                <label >
                   الشهادة
                </label>
                <div class="row">
                    <div class="col-sm-3">
                        <a class="d-none" id="eduReport" href="#" target="_blank">افتح المرفق</a>
                    </div>
                    <div class="col-sm-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="edu_file" name="edu_file">
                            <label class="custom-file-label" for="edu_file">أدخل الملف</label>
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
                    <th>المرحلة </th>
                    <th>المستوى  </th>
                    <th>تفاصيل </th>
                    <th>نوع المرفق </th>
                    <th>المرفق </th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1; $rows=$param['edu']?>
                <?php
                if(isset($rows)){
                    foreach($rows as $r) : ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $r['edu_level']; ?></td>
                            <td><?= $r['edu_stage']; ?></td>
                            <td><?= $r['edu_details']; ?></td>
                            <td><?= $r['attach_type']; ?></td>
                            <td>   <?php if (!empty($r['attach_path'])): ?>
                                    <a href="<?= base_url($r['attach_path']); ?>" target="_blank">افتح المرفق</a>
                                <?php else: ?>

                                <?php endif; ?></td>
                            <td>
                                <a  class="badge badge-success" style="font-size:14px; color: white;" onclick="getEduDetails('<?=$r['edu_id'];?>')">تعديل</a>
                                <a  class="badge badge-danger" style="font-size:14px; color: white;" onclick="deleteConfirm('<?php echo site_url('cv/delete_edu/'.$r['edu_id'].'/'.$param['user_row']['id'].'/'.'1');?>')">حذف</a>
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