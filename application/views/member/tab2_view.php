
<style>
    .center-text th {
        text-align: center;
    }
</style>
<div class="card-body form_style">
    <?php if(isset($param['user_row'])) $user_row=$param['user_row'];
    $rows=$param['PARENT_STATUS'];
    ?>

    <form id="contactForm" action="<?php echo site_url('member/add_contact'); ?>" method="post">
        <input type="hidden" id="user_id"  name="user_id" value="<?php if(isset($param['user_row']))echo $param['user_row']['id'];else echo '0' ?>" />
        <div class="form-group row">
            <div class="col-md-6">
                <label for="contact_type">وسيلة الاتصال</label>
                <select name="contact_type" id="contact_type" class="form-control" required >
                    <?php $rows=$param['CONTACT_TYPE'];
                    foreach($rows as $r) : ?>
                        <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 ">
                <label for="contact_value">الاتصال</label>
                <input class="form-control" type="text" id="contact_value" name="contact_value" placeholder="الاتصال" value="" required/>
            </div>

        </div>
        <div class="form-footer">
            <input class="btn btn-success" type="submit"  id="submitBtn"  name="btn" value="حفظ " />
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
                    <th>وسيلة الاتصال </th>
                    <th>الاتصال </th>
                    <th>إجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1; $contacts=$param['contacts']?>
                <?php
                if(isset($contacts)){
                    foreach($contacts as $con) : ?>
                        <tr>
                            <td><?= $index; ?></td>
                            <td><?= $con['title']; ?></td>
                            <td dir='ltr' style="text-align: left"><?= $con['contact_value']; ?></td>
                            <td>
                                <a  class="badge badge-danger" style="font-size:14px; color: white;" onclick="deleteContactConfirm('<?php echo site_url('member/delete_member_contact/'.$con['id'].'/'.$param['user_row']['id'].'/'.'2');?>')">حذف</a>
                            </td>
                        </tr>
                        <?php $index++; ?>
                    <?php endforeach; }?>
                </tbody>
            </table>
        </div>
    </div>
</div>