<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#parent_id').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
    });
</script>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title; ?></h1>
<?php
$param=$this->data['param']['row'];
$rows=$this->data['param']['rows'];
//var_dump($this->data['param']['rows']);die();
?>
    <div class="col-lg-7">
        <?= $this->session->flashdata('message'); ?>
    </div>

    <div class="card col-lg-7 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('admin/def') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $param['id']; ?>" />
                <div class="form-group">
                    <input type="text" class="form-control" id="title" name="title" placeholder="الثابت" value="<?=$param['title']?>">
                </div>
                <div class="form-group">
                    <select name="parent_id" id="parent_id" class="form-control select2" >
                        <option value="">---اختر التعريف الرئيسي---</option>
                        <?php ;
                        foreach($rows as $r) : ?>
                            <option value="<?= $r['id']; ?>" <?php if($r['id']==$param['parent_id'])echo 'selected';else echo '';?>><?= $r['path']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- btn -->
                <input class="btn btn-success" type="submit" name="btn" value="حفظ" />
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->