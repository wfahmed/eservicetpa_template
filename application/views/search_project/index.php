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
<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">
<?php
                    //    var_dump($param['rows'][0]['supplier_id']);?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="card col-lg-12 shadow mb-4 ">
            <div class="card-header">
                <h5 class="card-title">محددات البحث</h5>
                <button id="toggleCardBtn" class="btn btn-minimize">
                    <span id="arrow">&#9660;</span> <!-- Down arrow for maximize -->
                </button>
            </div>
            <div class="card-body">
                <!-- Form Container -->
           <form id="project_form_search" action="#" method="post">
                        <div class="form-body">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>الجهة المانحة</label>
                                        <select name="support_id" id="support_id" class="form-control" >
                                            <option value="">---اختر الجهة---</option>
                                            <?php $supporting_bodies = $param['supporting_bodies'];
                                            foreach($supporting_bodies as $r) : ?>
                                                <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>نوع الإغاثة</label>
                                        <select name="support_type_id" id="support_type_id" class="form-control" >
                                            <option value="">---اختر---</option>
                                            <?php $supporting_type = $param['supporting_type'];
                                            foreach($supporting_type as $r) : ?>
                                                <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label>المورد</label>
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            <option value="">---اختر المورد---</option>
                                            <?php $suppliers = $param['suppliers'];
                                            foreach($suppliers as $r) : ?>
                                                <option value="<?= $r['supplier_id']; ?>"><?= $r['supplier_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" id="searchBtn" class="btn btn-minimize">ابحث</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
        <div class="card col-lg-12 shadow mb-4 ">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="search_projectDT" width="100%" cellspacing="0">
                        <thead class="thead-dark-green">
                        <tr>
                            <th>الجهة</th>
                            <th>تاريخ</th>
                            <th> بالدينار</th>
                            <th> الاعتماد$</th>
                            <th> مستلم$</th>
                            <th> متبقي$</th>
                            <th>نوع الدعم</th>
                            <th>المورد</th>
                            <th>$المبلغ</th>
                            <th>المسدد$</th>
                            <th>$المتبقي</th>
                            <th>إجراءات</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            </div>

    </div>
    <!-- /.container-fluid -->

</div>
</div>
<!-- End of Main Content -->