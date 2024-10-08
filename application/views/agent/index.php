<style>
     .myTextarea {
        width: 100%;              /* Full width */
        height: 150px;            /* Height of the textarea */
        padding: 10px;            /* Inner padding */
        font-size: 16px;          /* Font size */
        line-height: 1.5;         /* Line height for readability */
        border: 2px solid #ccc;   /* Border color and thickness */
        border-radius: 8px;       /* Rounded corners */
        background-color: #f9f9f9; /* Light background color */
        resize: vertical;         /* Allow vertical resizing only */
        box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        outline: none;            /* Remove blue outline on focus */
    }

    .myTextarea:focus {
        border-color: #66afe9;    /* Change border color on focus */
        background-color: #fff;   /* Change background on focus */
        box-shadow: 0 0 8px rgba(102, 175, 233, 0.6); /* Glow effect on focus */
    }

</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1  class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?php if(isset($param['user_row'])) $user_row=$param['user_row'];    ?>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('member/family_show') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <form id="searchForm" action="<?=base_url().'agent/add'?>" method="POST">
                <input type="hidden" id="user_id" name="user_id" value="0">
                <input type="hidden" id="child_id" name="child_id" value="<?=$param['id']?>">
                <div class="form-group row">
                    <div class="col-md-4">
                    <label for="search_query">رقم الهوية</label>
                    <input type="text" id="search_query" name="search_query" class="form-control" placeholder="رقم الهوية">
                        <small class="search-instruction">اضغط Enter للبحث</small>
                </div>
                    <div class="col-md-3 d-none">
                        <button id="searchButton" type="button" class="btn btn-primary">ابحث</button></div>
                    <div class="col-md-4">
                        <label for="relation_type_id">العلاقة</label>
                        <select name="relation_type_id" id="relation_type_id" class="form-control" required>
                            <?php
                            $rows=$param['RELATION'];
                            foreach($rows as $r) : ?>
                                <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 ">
                        <label for="agent_approve_id"> المعتمد</label>
                        <select name="agent_approve_id" id="agent_approve_id" class="form-control" required>
                            <?php
                            $rows=$param['RELATION'];
                            foreach($rows as $r) : ?>
                                <option value="<?= $r['id']; ?>" ><?= $r['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="fname">الاسم الأول</label>
                        <input class="form-control" type="text" name="fname"  id="fname" placeholder="الاسم الأول" value="" required/>
                    </div>
                    <div class="col-md-3 ">
                        <label for="sname">الاسم الثاني</label>
                        <input class="form-control" type="text" id="sname" name="sname" placeholder="الاسم الثاني" value="" required/>
                    </div>
                    <div class="col-md-3">
                        <label for="tname">الاسم الثالث</label>
                        <input class="form-control" type="text" id="tname" name="tname"placeholder="الاسم الثالث" value="" required />
                    </div>
                    <div class="col-md-3">
                        <label for="lname">الاسم الرابع</label>
                        <input class="form-control" type="text" name="lname" id="lname" placeholder="الاسم الرابع" value="" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="tname">تفاصيل</label>
                        <textarea   id="details" class="myTextarea"></textarea>
                    </div>
                </div>
                <br>
                <!-- btn -->
                <div class="form-footer">
                    <input class="btn btn-success" type="submit" name="btn"  value="حفظ " />
                </div>
            </form>

        </div>
    </div>

    <div class="card">
        <div class="card-header py-3">
        </div>
        <div class="card-body">
            <h2>الوكلاء السابقين للطفل</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark-c center-text">
                    <tr>
                        <th>#</th>
                        <th>الاسم </th>
                        <th>الهوية </th>
                        <th>تاريخ الميلاد </th>
                        <th>صلة القرابة </th>
                        <th>إجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1;?>
                    <?php
                    if(isset($param['childAgent'])){
                        $childAgent=$param['childAgent'];
                        foreach($childAgent as $r) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $r['full_name']; ?></td>
                                <td><?= $r['identity']; ?></td>
                                <td><?= $r['dob']; ?></td>
                                <td><?= $r['relation_type']; ?></td>
                                <td>
                                    <a class="badge badge-danger btn-style"
                                       onclick="deleteConfirm('<?= site_url('agent/del/'.$r['agent_id'].'/'.$r['child_user_id'])?>')"
                                           href="#!">حذف</a>
                                    <a class="badge badge-primary btn-style " href="<?= site_url('member/detailmember/'.$r['id']); ?>">تفاصيل</a>
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