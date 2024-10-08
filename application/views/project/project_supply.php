<style>
    table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        max-width: 200px; /* Adjust as needed */
        overflow: hidden; /* Optional: hide overflowed content */
        text-overflow: ellipsis; /* Optional: add ellipsis for overflowed text */
        white-space: nowrap; /* Optional: prevent text from wrapping */
    }
    .card-header {
        display: grid;
        grid-template-columns: auto 1fr;
        align-items: center;
    }
    .card-header h6 {
        grid-column: 1;
    }
    .card-header span {
        grid-column: 3;

    }
    .hidden {
        display: none;
    }
    .tab-links div.disabled {
        pointer-events: none;
        color: #6c757d;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    .custom_btn{
        cursor: pointer;
        height: 25px;
        width: 48px;
    }

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
    .tags-input {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: border-color 0.3s ease-in-out;
    }

    .tags-input:focus-within {
        border-color: #007bff;
        background-color: #e9ecef;
    }

    .tags-input ul {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
        margin: 0;
    }

    .tags-input ul li {
        display: inline-flex;
        align-items: center;
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        margin: 3px;
        border-radius: 20px;
        font-size: 14px;
    }

    .tags-input ul li .remove-tag {
        background: transparent;
        border: none;
        margin-left: 8px;
        cursor: pointer;
        font-size: 12px;
        color: white;
        transition: color 0.3s ease-in-out;
    }

    .tags-input ul li .remove-tag:hover {
        color: #ff4d4d;
    }

    #input-tag {
        border: none;
        outline: none;
        flex-grow: 1;
        padding: 5px;
        font-size: 14px;
        color: #333;
        background-color: transparent;
    }

    #input-tag::placeholder {
        color: #999;
    }

    .tags-input:hover {
        border-color: #007bff;
    }

    .tags-input:focus-within ul li {
        background-color: #0069d9;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800" style="-webkit-text-stroke: thin;"><?= $title; ?></h1>


    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>
    <?php
    if(isset($param['rowSupport'])) $rowSupport=$param['rowSupport'];
    if(isset($param['rowStage'])) $rowStage=$param['rowStage'];
    $sub_title=$this->data['sub_title'];
    $sum_stage=0;
    if(isset($param['sum_stage']))
        $sum_stage=$param['sum_stage'];?>
    <?php if(isset($param['row'])) $row=$param['row'];?>
    <?php if(isset($param['project_supply'])) $project_supply=$param['project_supply'];
    if(isset($param['suppliers']))
    $rows=$param['suppliers'];
    $executed_value=0;
   // var_dump($rowStage);
    if(isset($rowStage) && count($rowStage)>0)
    $executed_value=$rowStage['executed_value'];
    ?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('project/edit_project/'.$row['project_id'].'/3')?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
            <span class="m-0 font-weight-bold text-primary hh"><?=$sub_title ;?></span>
        </div>
        <div class="card-body">
                    <div class="card-body form_style" id="card_supply">
                        <form id="supplyForm" action="<?php echo site_url('project/add_edit_supply/'.$row['project_id'].'/'.$rowSupport['ps_id']); ?>" method="post">
                            <input type="hidden" id="proj_fk" name="proj_fk" value="<?php if($row)echo $row['project_id'];else echo '0' ?>" />
                            <input type="hidden" id="ps_fk"  name="ps_fk" value="<?=$rowSupport['ps_id']?>" />
                            <input type="hidden" id="support_fk"  name="support_fk" value="<?=$rowSupport['support_fk']?>" />
                            <input type="hidden" id="proj_supply_id"  name="proj_supply_id" value="0" />
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="support_type">المورد</label>
                                    <select name="supplier_fk" id="supplier_fk" class="form-control" required>
                                        <option value="0" >اختر المورد</option>
                                        <?php

                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['supplier_id']; ?>" data_atr="<?= $r['supplier_name']; ?>"><?= $r['supplier_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="supplier_date">التاريخ</label>
                                    <input type="text" class="form-control datepicker" id="supplier_date" name="supplier_date"   required>
                                </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="supplier_date">القيمة الفعلية للتنفيذ</label>
                                    <input type="text" class="form-control datepicker" id="executed_value" name="executed_value"  value="<?=$executed_value?>" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="supplier_paid_amount">المبلغ</label>
                                    <input type="text" class="form-control" id="supplier_paid_amount" name="supplier_paid_amount"   required>
                                </div>
                                </div>

                               <div class="form-group row">
                                <div class="col-md-12 ">
                                    <label for="notes"> </label>
                                    <textarea type="text" class="form-control styled-textarea" id="notes" name="notes"
                                              value=""
                                              placeholder="تفاصيل"></textarea>
                                </div>


                            </div>
                            <div class="form-footer">
                                <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
                            </div>
                        </form>
                    </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark-c">
                        <tr>
                            <th>#</th>
                            <th>المورد</th>
                            <th>التاريخ</th>
                            <th>المبلغ</th>
                           <!-- <th>المتبقي</th>-->
                            <th>ملاحظات</th>
                            <th>اجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $index = 1; $project_supply=$param['project_supply']?>
                        <?php foreach($project_supply as $r) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $r['supplier_name']; ?></td>
                                <td><?= $r['supplier_date']; ?></td>
                                <td><?= $r['supplier_paid_amount']; ?></td>
                               <!-- <td><?/*= $r['remaining_amount']; */?></td>-->
                                <td><?= $r['notes']; ?></td>
                                <td>
                                    <a  class="badge badge-success custom_btn" style="font-size:14px; color: white;" onclick="details_supply_Modal('<?php echo site_url('project/details_supply/'.$r['proj_supply_id']);?>')">تعديل</a>
                                    <a  class="badge badge-warning custom_btn" style="font-size:14px; color: white;" href="<?php echo site_url('project/add_edit_supply_pay/'.$r['proj_supply_id']);?>">مديونية</a>
                                    <a  class="badge badge-danger custom_btn" style="font-size:14px; color: white;" onclick="deleteConfirm('<?php echo site_url('project/delete_supply/'.$r['proj_supply_id'].'/'.$param['row']['project_id'].'/'.$r['ps_fk']);?>')">حذف</a>
                                </td>
                            </tr>
                            <?php $index++; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<!-- /.container-fluid -->
<!-- End of Main Content -->
<!-- modal delete -->
<div class="modal fade" id="deletetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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