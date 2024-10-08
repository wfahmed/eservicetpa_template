<style>
    .col-md-12 {
        display: flex;
        justify-content: center; /* Centers horizontally */
        margin-top: 10px; /* Optional: Add some space above the button */
    }
    .btn-minimize{
        color: #fff;
        background-color: #1cc78a;
        border-color: #0bab88;
    }
    .card-header {
        display: flex;
        justify-content: space-between;
        background: #81c28a;
        color: #fff;
        padding: 10px;
        cursor: pointer;
    }

    .card-body {
        padding: 15px;
        background: #fff;
        transition: height 0.3s ease;
    }
    .card-body.minimized {
        height: 0; /* Completely collapse the content */
        padding: 0; /* Remove padding */
        overflow: hidden; /* Ensure no content is visible */
    }

    .card-body.expanded {
        height: auto; /* Auto height for expanded state */
        padding: 15px; /* Restore padding */
        overflow: visible; /* Allow content to be visible */
    }
    #arrow {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    #arrow.up {
        transform: rotate(180deg); /* Arrow pointing up */
    }

</style>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    $sum_stage=0;
    if(isset($param['sum_stage']))
        $sum_stage=$param['sum_stage'];
    if(isset($param['row']))
        $row=$param['row'];

    ?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('project') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>

            <h5 class="card-title">بيانات المشروع الأساسية</h5>
            <button id="toggleCardBtn" class="btn btn-minimize">
                <span id="arrow">&#9660;</span> <!-- Down arrow for maximize -->
            </button>
        </div>
        <div class="card-body">
            <form id="project_form" action="#" method="post">
               <div class=" col-lg-12 ">
                    <div class="form-group row">
                        <div class="col-md-10">
                            <label for="menu">الجهة الداعمة </label>

                            <select name="support_id" id="support_id" class="form-control" readonly
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
                            <input type="text" class="form-control" id="exchange_value" name="exchange_value" title="قيمة التحويل " value="<?php if($row)echo $row['exchange_value'];else echo '3.3' ?>" readonly >
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="menu">القيمة بالدينار </label>
                            <input type="text" class="form-control" id="approved_value" name="approved_value" value="<?php if($row)echo $row['approved_value'];else echo '' ?>"
                                   placeholder="قيمة-دينار " readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="menu">القيمة بالدولار </label>
                            <input type="text" class="form-control" id="approved_amount" name="approved_amount" placeholder="قيمة $" value="<?php if($row)echo $row['approved_amount'];else echo '' ?>"
                                   readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="menu">تاريخ الاعتماد </label>
                            <input readonly type="text" class="form-control datepicker" id="approved_date" name="approved_date" placeholder="تاريخ الاعتماد" value="<?php if($row)echo $row['approved_date'];else echo '' ?>" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="menu">المبلغ المستلم </label>
                            <input readonly type="text" class="form-control" id="received_from_sponsor" name="received_from_sponsor"
                                   value="<?php if($row)echo $row['received_from_sponsor'];else echo '0' ?>"
                                   placeholder="المبلغ المستلم">
                        </div>
                        <div class="col-md-4">
                            <label for="menu">المبلغ المتبقي </label>
                            <input readonly type="text" class="form-control" id="remain_from_sponsor" name="remain_from_sponsor"
                                   value="<?php if($row)echo $row['remain_from_sponsor'];else echo '0' ?>"
                                   placeholder="المبلغ المتبقى">
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="menu">ملاحظات </label>
                        <textarea readonly type="text" class="form-control styled-textarea" id="notes" name="notes"
                                  placeholder="تفاصيل"><?php if($row)echo trim($row['notes']);else echo '' ?></textarea>
                    </div>


                </div>
            </form>
        </div>

        <div class="card-header">
          <h5 class="card-title">دعم المشروع موجه للمساعدات التالية</h5>
            <button id="toggleSupportCardBtn" class="btn btn-minimize">
                <span id="Supportarrow">&#9651</span> <!-- Down arrow for maximize -->
            </button>
        </div>
        <div id="collapseBody"  class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark-ggreen">
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
                    <?php
                    if(isset($project_support)){
                    foreach($project_support as $r) :
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
                    <?php endforeach;}?>
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

        <div class="card-header">
            <h5 class="card-title">مراحل تنفيذ المشروع</h5>
            <button id="toggleStageCardBtn" class="btn btn-minimize">
                <span id="Stagearrow">&#9660;</span> <!-- Down arrow for maximize -->
            </button>
        </div>
        <div id="collapseStageBody" class="card-body">
            <div  class="table-responsive">
                <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark-rounded">
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

        <div class="card-header">
            <h5 class="card-title">مراحل توريد المشروع</h5>
            <button id="toggleSupplierCardBtn" class="btn btn-minimize">
                <span id="Supplierarrow">&#9660;</span> <!-- Down arrow for maximize -->
            </button>
        </div>
        <div id="collapseSupplierBody" class="card-body">
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
<!-- /.container-fluid -->

</div>