<style>
    .card-body {
        padding: 0.5rem !important;
    }
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
        width: 43px;
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
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>


    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>
    <?php $tab_id=$param['tab_id'] ;
    $sum_stage=0;
    if(isset($param['sum_stage']))
        $sum_stage=$param['sum_stage'];?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('project') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <div class="tab-container">
                <div class="tab-links">
                    <div class="active-tab" data-tab="1" id="t1_tab">بيانات الاعتماد</div>
                    <div class=" " data-tab="2" id="t2_tab">بيانات الدعم المقدم</div>
                    <div class="" data-tab="3" id="t3_tab">بيانات التنفيذ</div>
                    <div class="" data-tab="4" id="t4_tab">بيانات المورد</div>
                </div>
                    <div id="tab1" class="tab-content show ">
                        <?php
                        if(isset($param['row'])) $row=$param['row'];
                        if(isset($param['sum_unit_value'])) $sum_unit_value=$param['sum_unit_value'];
                        if(isset($param['project_support'])) $project_support=$param['project_support'];
                        //var_dump($project_support);die();
                        ?>
                        <form id="project_form" action="<?= site_url('project/edit_project/'.$row['project_id']); ?>" method="post">
                            <input type="hidden" name="project_id" value="<?php if($row)echo $row['project_id'];else echo '0' ?>" />
                            <!-- edit title -->
                            <div class=" col-lg-12 ">
                                <div class="form-group row">
                                    <div class="col-md-10">
                                        <label for="menu">الجهة الداعمة </label>
                                        <select name="support_id" id="support_id" class="form-control" required
                                        <option value="">---اختر الجهة---</option>
                                        <?php $supporting_bodies=$param['supporting_bodies'];
                                        foreach($supporting_bodies as $r) : ?>
                                            <option value="<?= $r['id']; ?>"
                                                <?php if($row['support_id']== $r['id'])echo 'selected';else echo '3.3' ?>
                                            ><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="menu">قيمة التحويل </label>
                                        <input type="text" class="form-control" id="exchange_value" name="exchange_value" title="قيمة التحويل " value="<?php if($row)echo $row['exchange_value'];else echo '3.3' ?>" readonly required>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="menu">القيمة بالدينار </label>
                                        <input type="text" class="form-control" id="approved_value" name="approved_value" value="<?php if($row)echo $row['approved_value'];else echo '' ?>"
                                               placeholder="قيمة-دينار " required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="menu">القيمة بالدولار </label>
                                        <input type="text" class="form-control" id="approved_amount" name="approved_amount" placeholder="قيمة $" value="<?php if($row)echo $row['approved_amount'];else echo '' ?>"
                                               readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="menu">تاريخ الاعتماد </label>
                                        <input type="text" class="form-control datepicker" id="approved_date" name="approved_date" placeholder="تاريخ الاعتماد" value="<?php if($row)echo $row['approved_date'];else echo '' ?>" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="menu">المبلغ المستلم </label>
                                        <input type="text" class="form-control" id="received_from_sponsor" name="received_from_sponsor"
                                               value="<?php if($row)echo $row['received_from_sponsor'];else echo '0' ?>"
                                               placeholder="المبلغ المستلم">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="menu">المبلغ المتبقي </label>
                                        <input type="text" class="form-control" id="remain_from_sponsor" name="remain_from_sponsor"
                                               value="<?php if($row)echo $row['remain_from_sponsor'];else echo '0' ?>"
                                               placeholder="المبلغ المتبقى">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label for="menu">ملاحظات </label>
                                    <textarea type="text" class="form-control styled-textarea" id="notes" name="notes"
                                              placeholder="تفاصيل"><?php if($row)echo trim($row['notes']);else echo '' ?></textarea>
                                </div>


                            </div>
                            <br>
                            <!-- btn -->
                            <div class="form-footer">
                            <input class="btn btn-success" type="submit" name="btn" value="حفظ " />
                            </div>
                        </form>
                    </div>

                    <div id="tab2"   class="tab-content">
                        <div class="card-body form_style">
                        <form id="supportForm" action="<?php echo site_url('project/add_edit_support'); ?>" method="post">
                            <input type="hidden" name="project_id" value="<?php if($row)echo $row['project_id'];else echo '0' ?>" />
                            <input type="hidden" id="approved_amount" name="approved_amount" value="<?php if($row)echo $row['approved_amount'];else echo '0' ?>" />
                            <input type="hidden" id="sum_unit_value" name="sum_unit_value" value="<?php if($sum_unit_value)echo $sum_unit_value;else echo '0' ?>" />
                            <input type="hidden" id="tags-data" name="tags-data" value="0"/>
                            <input type="hidden" id="ps_id"  name="ps_id" value="" />
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="support_fk">نوع الدعم</label>
                                    <select name="support_fk" id="support_fk" class="form-control" required>
                                        <option value="0">اختر نوع الدعم</option>
                                        <?php $rows=$param['support_type'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>" data_atr="<?= $r['title']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="approved_support_amount">المبلغ المعتمد$</label>
                                    <input type="text" class="form-control" id="approved_support_amount" name="approved_support_amount"   required>
                                </div>
                                <div class="col-md-3">
                                    <label for="approved_remainder">متبقى من المعتمد$</label>
                                    <input type="text" class="form-control" id="approved_remainder" name="approved_remainder"
                                           value="<?=$row['approved_amount']-$sum_unit_value?>"
                                           readonly>
                                </div>
                                <div class="col-md-3 ">
                                    <label for="contact_value">وحدة القياس</label>
                                    <select name="measure_unit" id="measure_unit" class="form-control" required>
                                            <option value="0">اختر وحدة القياس</option>
                                            <option value="عدد">عدد</option>
                                            <option value="كمية">كمية</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="unit_amount">المقدار</label>
                                    <input type="text" class="form-control" id="unit_amount" name="unit_amount"   required>
                                </div>
                                <div class="col-md-4 ">
                                    <label for="unit_price">السعر للوحدة</label>
                                    <input type="text" class="form-control" id="unit_price" name="unit_price"   required>
                                </div>
                                <div class="col-md-4 ">
                                    <label for="unit_value">المبلغ </label>
                                    <input type="text" class="form-control" id="unit_value" name="unit_value"   required readonly>
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                <label for="target">الفئات المستهدفة </label>
                                <div class="tags-input">
                                    <ul id="tags" name="tags"></ul>
                                    <input type="text" id="input-tag" name="input-tag" placeholder="ادخل الفئة" autocomplete="off" />
                                    <ul id="tags-dropdown" name="tags-dropdown"  class="tags-dropdown"></ul>
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
                                <thead class="thead-dark-c">
                                <tr>
                                    <th>#</th>
                                    <th> الدعم </th>
                                    <th> المبلغ المعتمد$ </th>
                                    <th> القياس </th>
                                    <th>المقدار</th>
                                    <th>السعر$</th>
                                    <th>المبلغ$</th>
                                    <th>الفئات المستهدفة</th>
                                    <th>إجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $index = 1;
                                $sum_approved_support_amount=0;
                                $sum_unit_value=0;
                                ?>
                                <?php foreach($project_support as $r) :
                                    $sum_approved_support_amount+=$r['approved_support_amount'];
                                    $sum_unit_value+=$r['unit_value'];?>
                                    <tr>
                                        <td><?= $index; ?></td>
                                        <td><?= $r['support_name']; ?></td>
                                        <td><?= $r['approved_support_amount']; ?></td>
                                        <td><?= $r['measure_unit']; ?></td>
                                        <td><?= $r['unit_amount']; ?></td>
                                        <td><?= $r['unit_price']; ?></td>
                                        <td><?= $r['unit_value']; ?></td>
                                        <td><?= $r['target_name']; ?></td>
                                        <td>
                                            <a  class="badge badge-primary custom_btn" style="font-size:14px; color: white;" href="<?php echo site_url('project/add_edit_stage/'.$param['row']['project_id'].'/'.$r['ps_id'])?>">تنفيذ</a>
                                            <a  class="badge badge-warning custom_btn" style="font-size:14px; color: white;" href="<?php echo site_url('project/add_edit_supply/'.$param['row']['project_id'].'/'.$r['ps_id'])?>">توريد</a>
                                            <a  class="badge badge-success custom_btn" style="font-size:14px; color: white;" onclick="detailsModal('<?php echo site_url('project/details_support/'.$r['ps_id']);?>')">تعديل</a>
                                            <a  class="badge badge-danger custom_btn" style="font-size:14px; color: white;" onclick="deleteConfirm('<?php echo site_url('project/delete_support/'.$r['ps_id'].'/'.$param['row']['project_id'].'/'.'support');?>')">حذف</a>
                                        </td>
                                    </tr>
                                    <?php $index++; ?>
                                <?php endforeach;?>
                                <?php
                                if($sum_approved_support_amount!=0){ ?>
                                        <tr>
                                    <td colspan="2" style="font-weight: bolder;color: #0a0a0a">إجمالي المبلغ المعتمد</td>
                                    <td style="font-weight: bolder;color: #0a0a0a"><?=  $sum_approved_support_amount?></td>
                                    <td></td>
                                    <td colspan="2" style="font-weight: bolder;color: #0a0a0a">إجمالي المبلغ المنفذ</td>
                                    <td style="font-weight: bolder;color: #0a0a0a"><?= $sum_unit_value?></td>
                                    <td></td>
                                    <td> </td>
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        </div>
                    </div>

                    <div id="tab3" class="tab-content">
                        <div class="card">
                            <div class="card-header py-3">
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="thead-dark-c">
                                        <tr>
                                            <th>#</th>
                                            <th>الإجمالي المنفذ </th>
                                            <th>القيمة المنفذة فعليا$ </th>
                                            <th>حصة المؤسسة$  </th>
                                            <th>عدد الوحدات الفعلي  </th>
                                            <th>سعر الوحدة الفعلي$  </th>
                                            <th>المبلغ الإجمالي الفعلي$  </th>
                                            <th>نوع الدعم  </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $index = 1;
                                        $project_stages=$param['project_stages'];
                                        $sum_total_executed=0;
                                        $sum_executed_value=0;
                                        $sum_association_share=0;
                                        ?>
                                        <?php foreach($project_stages as $r) :
                                            $sum_association_share+=$r['association_share'];
                                            $sum_executed_value+=$r['executed_value'];
                                            $sum_total_executed+=$r['total_executed'];
                                            ?>
                                            <tr>
                                                <td><?= $index; ?></td>
                                                <td><?= $r['total_executed']; ?></td>
                                                <td><?= $r['executed_value']; ?></td>
                                                <td><?= $r['association_share']; ?></td>
                                                <td><?= $r['unit_amount_actual']; ?></td>
                                                <td><?= $r['unit_actual_price']; ?></td>
                                                <td><?= $r['unit_value_actual']; ?></td>
                                                <td><?= $r['support_name']; ?></td>

                                            </tr>
                                            <?php $index++; ?>
                                        <?php endforeach;
                                        if($sum_association_share!=0){
                                        ?>
                                            <tr>
                                                <td colspan="3" style="font-weight: bolder;color: #0a0a0a">اجمالي التنفيذ</td>
                                        <td colspan="5" style="font-weight: bolder;color: #0a0a0a"><?=$sum_total_executed?></td>
                                        </tr>
                                            <tr>
                                                <td colspan="3" style="font-weight: bolder;color: #0a0a0a">اجمالي القيم المنفذة فعلياً</td>
                                                <td colspan="5" style="font-weight: bolder;color: #0a0a0a"><?=$sum_executed_value?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="font-weight: bolder;color: #0a0a0a">اجمالي حصة المؤسسة</td>
                                                <td colspan="5" style="font-weight: bolder;color: #0a0a0a"><?=$sum_association_share?></td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                <div id="tab4" class="tab-content">
                    <div class="card">
                        <div class="card-header py-3">
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-dark-c">
                                    <tr>
                                        <th>#</th>
                                        <th>المورد</th>
                                        <th>التاريخ</th>
                                     <!--   <th>الفاتورة</th>-->
                                        <th>$المبلغ</th>
                                     <!--   <th>سند القبض</th>-->
                                        <th>$المتبقي</th>
                                        <th>ملاحظات</th>
                                        <th>الدعم</th>
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
                                           <!-- <td><?/*= $r['supplier_invoice']; */?></td>-->
                                            <td><?= $r['supplier_paid_amount']; ?></td>
                                            <!--<td><?/*= $r['receipt_no']; */?></td>-->
                                            <td><?= $r['remaining_amount']; ?></td>
                                            <td><?= $r['notes']; ?></td>
                                            <td><?= $r['support_name']; ?></td>
                                            <td>
                                                <a  class="badge badge-warning custom_btn" style="font-size:14px; color: white;width:60px;" href="<?php echo site_url('project/add_edit_supply_pay/'.$r['proj_supply_id'])?>">تفاصيل</a></td>
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