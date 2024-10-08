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

    <form id="hobForm" action="<?= site_url('cv/add_hob'); ?>" method="post" >
        <input type="hidden" id="user_id"  name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
        <div class="form-group row">
            <div class="col-md-12">
                <label for="hobby_id">الهوايات</label>
                <select name="hobby_id[]" id="hobby_id" class="form-control" multiple="multiple" required>
                        <?php $rows=$param['HOBBIES'];
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                        <?php endforeach; ?>
                </select>
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
                    <th>الهواية </th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1; $rows=$param['hob']?>
                <?php
                if(isset($rows)){
                    foreach($rows as $r) : ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $r['hobby']; ?></td>
                            <td>
                                <a  class="badge badge-danger" style="font-size:14px; color: white;" onclick="deleteConfirm('<?php echo site_url('cv/delete_hob/'.$r['hob_id'].'/'.$param['user_row']['id'].'/'.'3');?>')">حذف</a>
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