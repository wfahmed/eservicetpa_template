<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800" style="-webkit-text-stroke: thin;"><?= $title; ?></h1>


    <?php if(isset($param['row'])) $row=$param['row'];?>
    <?php if(isset($param['project_supply'])) $project_supply=$param['project_supply'];
    //var_dump($project_supply);?>
    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('supplier') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="card-body form_style" id="card_supply">
                        <form id="stageForm" action="#" method="post">
                            <div class=" col-lg-12 ">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label >اجمالي المبلغ المطلوب$</label>
                                        <input type="text" value="<?=$row['total_value']?>" class="form-control" id="supplier_name" name="supplier_name" placeholder="الاسم" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label >اجمالي المبلغ المسدد$</label>
                                        <input type="text" value="<?=$row['total_paid']?>" class="form-control" id="contact_email" name="contact_email" placeholder="البريد " readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label >اجمالي المتبقي$</label>
                                        <input type="text" value="<?=$row['total_value']-$row['total_paid']?>" class="form-control" id="contact_phone" name="contact_phone" placeholder="جوال" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label >اسم المورد</label>
                                        <input type="text" value="<?=$row['supplier_name']?>" class="form-control" id="supplier_name" name="supplier_name" placeholder="الاسم" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label >البريد</label>
                                        <input type="text" value="<?=$row['contact_email']?>" class="form-control" id="contact_email" name="contact_email" placeholder="البريد " readonly>
                                    </div>
                                    <div class="col-md-3">
                                        <label >الجوال</label>
                                        <input type="text" value="<?=$row['contact_phone']?>" class="form-control" id="contact_phone" name="contact_phone" placeholder="جوال" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label >العنوان </label>
                                    <textarea type="text" class="form-control" id="address" name="address" placeholder="عنوان" readonly><?=$row['address']?></textarea>
                                </div>

                            </div>
                        </form>
                    </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark-c">
                        <tr>
                            <th>#</th>
                            <th>الجهة</th>
                            <th>الدعم</th>
                            <th>المورد</th>
                            <th>التاريخ</th>
                            <th>$المبلغ</th>
                            <th>المسدد$</th>
                            <th>المتبقي$</th>
                            <th>اجراءات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $index = 1; $project_supply=$param['project_supply'];
                        if(isset($project_supply)){?>
                        <?php foreach($project_supply as $r) : ?>
                            <tr>
                                <td><?= $index; ?></td>
                                <td><?= $r['associaton_name']; ?></td>
                                <td><?= $r['support_name']; ?></td>
                                <td><?= $r['supplier_name']; ?></td>
                                <td><?= $r['supplier_date']; ?></td>
                                <td><?= $r['supplier_paid_amount']; ?></td>
                                <td><?= $r['total_paid_sup']; ?></td>
                                <td><?= $r['supplier_paid_amount']-$r['total_paid_sup']; ?></td>
                                <td>  <a   class="badge badge-success" style="font-size:14px;"  href="#"
                                           data-toggle="modal" data-target="#newDefModal"
                                         onclick="details_debts_Modal(<?=$r['proj_supply_id']?>,'<?=$r['associaton_name'].'  '.$r['support_name']?>')"
                                        >الدفعات</a></td>
                            </tr>
                            <?php $index++; ?>
                        <?php endforeach; }?>
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
    </div>

</div>
</div>

<div class="modal fade" id="newDefModal" tabindex="-1" role="dialog" aria-labelledby="newDefModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDefModalLabel">دفعات المورد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form -->
            <form action="#" method="post">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped" id="dataTableDebts" width="100%" cellspacing="0">
                                <thead class="thead-dark-c">
                                <tr>
                                    <th>#</th>
                                    <th>التاريخ</th>
                                    <th>الفاتورة</th>
                                    <th>قيمة الفاتورة</th>
                                    <th>سند القبض</th>
                                    <th>ملاحظات</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

