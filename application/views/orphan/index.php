<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>
<style>
    #age_from, #age_to {
        width: 70px;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-left: none;
        border-right: none;
    }
    .card-header {
        cursor: pointer;
    }

    .card-header button {
        cursor: pointer;
        width: 100%;
        text-align: right;
        padding: 0;
        background: none;
        border: none;
        font-weight: bold;
    }

    .card-header button:focus {
        outline: none;
        box-shadow: none;
    }
    item.active .page-link {
        background-color: #722b75!important;
        border-color: #722b75!important;
    }
    .paginate_button.active .page-link {
        background-color: #722b75 !important;
        border-color: #722b75 !important;
        color: #fff !important; /* Optional: set text color to white */
    }
    .paginate_button.active {
        background-color: #722b75 !important;
        border-color: #722b75 !important;
        color: #fff !important; /* Optional: set text color to white */
    }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
<?php
//$orphans=$param['orphans'];
?>
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <div class="card shadow mb-4">
        <form id="orphanFilterForm" class="mb-4">
            <div class="container-fluid">
                <div class="card-header" id="GuaranteeFilterHeader">
                    <h5 class="mb-0">
                        <button   type="button" data-bs-toggle="collapse" data-bs-target="#GuaranteeFilterCollapse" aria-expanded="true" aria-controls="GuaranteeFilterCollapse">
                            محددات الكفالة
                        </button>
                    </h5>
                </div>
                <div id="GuaranteeFilterCollapse" class="collapse show" aria-labelledby="GuaranteeFilterHeader">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="guarantee_type_id" class="form-label">نوع الكفالة</label>
                                    <select id="guarantee_type_id" class="form-control" name="guarantee_type_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['RELIEF'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="guarantee_subtype_id" class="form-label">قيمة الكقالة</label>
                                    <select id="guarantee_subtype_id" name="guarantee_subtype_id[]" class="form-control" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['GUARANTEE_SUB'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="currency_id" class="form-label"> العملة</label>
                                    <select id="currency_id" class="form-control" name="currency_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['CURRENCY'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="donar_id" class="form-label">الجهة المانحة</label>
                                    <select id="donar_id" class="form-control" name="donar_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['SUPPORTING_BODIES'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="benefit_id" class="form-label"> نوع الاستفادة</label>
                                    <select id="benefit_id" class="form-control" name="benefit_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['BENEFIT'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="benefit_date_range" class="form-label">تاريخ الاستفادة</label>
                                    <div class="input-group">
                                        <input type="text" id="benefit_date_range" class="form-control" readonly>
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="father_asylum_status_id" class="form-label">المدة</label>
                                    <select id="father_asylum_status_id" class="form-control">
                                        <option value="">اختر</option>
                                        <option value="2">مرة واحدة</option>
                                        <option value="1">ممتدة</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-header" id="fatherFilterHeader">
                    <h5 class="mb-0">
                        <button type="button" data-bs-target="#fatherFilterCollapse" aria-expanded="true" aria-controls="fatherFilterCollapse">
                            محددات الوالد
                        </button>
                    </h5>
                </div>
                <div id="fatherFilterCollapse" class="collapse show" aria-labelledby="fatherFilterHeader">

                <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_date_range" class="form-label">تاريخ الوفاة</label>
                            <div class="input-group">
                                <input type="text" id="father_date_range" class="form-control" readonly>
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_asylum_status_id" class="form-label">المواطنة</label>
                            <select id="father_asylum_status_id" class="form-control">
                                <option value="">اختر</option>
                                <option value="2">مواطن</option>
                                <option value="1">لاجىء</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_user_status_id" class="form-label">حالة الأب</label>
                            <select id="father_user_status_id" class="form-control" name="father_user_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['PARENT_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_naturalwork_id" class="form-label">طبيعة العمل</label>
                            <select id="father_naturalwork_id" name="father_naturalwork_id[]" class="form-control" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['NATURAL_WORK'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_maretal_status_id" class="form-label">الحالة الاجتماعية</label>
                            <select id="father_maretal_status_id" class="form-control" name="father_maretal_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['MARETAL_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_disability_status_id" class="form-label">حالة الإعاقة</label>
                            <select id="father_disability_status_id" class="form-control" name="father_disability_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['DISABILITY_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="form-group">
                            <label for="father_health_status_id" class="form-label">الحالة الصحية</label>
                            <select id="father_health_status_id" class="form-control" name="father_health_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['HEALTH'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                </div>

                <div class="card-header" id="motherFilterHeader">
                    <h5 class="mb-0">
                        <button   type="button" data-bs-toggle="collapse" data-bs-target="#motherFilterCollapse" aria-expanded="true" aria-controls="motherFilterCollapse">
                            محددات الوالدة
                        </button>
                    </h5>
                </div>
                <div id="motherFilterCollapse" class="collapse show" aria-labelledby="motherFilterHeader">
                    <div class="card-body">
                <div class="row ">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_date_range" class="form-label">تاريخ الوفاة</label>
                            <div class="input-group">
                                <input type="text" id="mother_date_range" class="form-control" readonly>
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_user_status_id" class="form-label">حالة الأم</label>
                            <select id="mother_user_status_id" class="form-control" name="mother_user_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['PARENT_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_naturalwork_id" class="form-label">طبيعة العمل</label>
                            <select id="mother_naturalwork_id" name="mother_naturalwork_id[]" class="form-control" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['NATURAL_WORK'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_maretal_status_id" class="form-label">الحالة الاجتماعية</label>
                            <select id="mother_maretal_status_id" class="form-control" name="mother_maretal_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['MARETAL_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_disability_status_id" class="form-label">حالة الإعاقة</label>
                            <select id="mother_disability_status_id" class="form-control" name="mother_disability_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['DISABILITY_STATUS'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label for="mother_health_status_id" class="form-label">الحالة الصحية</label>
                            <select id="mother_health_status_id" class="form-control" name="mother_health_status_id[]" multiple="multiple">
                                <option value="">اختر</option>
                                <?php $rows=$param['HEALTH'];
                                foreach($rows as $r) : ?>
                                    <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
                </div>

                <div class="card-header" id="dewllingFilterHeader">
                    <h5 class="mb-0">
                        <button   type="button" data-bs-toggle="collapse" data-bs-target="#dewllingFilterCollapse" aria-expanded="true" aria-controls="dewllingFilterCollapse">
                            محددات السكن
                        </button>
                    </h5>
                </div>
                <div id="dewllingFilterCollapse" class="collapse show" aria-labelledby="dewllingFilterHeader">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="dwelling_nature_id" class="form-label">طبيعة المسكن</label>
                                    <select id="dwelling_nature_id" class="form-control" name="dwelling_nature_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['DWELLING_NATURE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="dwelling_damage_id" class="form-label">حالة المسكن</label>
                                    <select id="dwelling_damage_id" name="dwelling_damage_id[]" class="form-control" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['DWELLING_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="governorate_id" class="form-label"> المحافظة</label>
                                    <select id="governorate_id" class="form-control" name="governorate_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['GOVERNORATES'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="valley_side_id" class="form-label">المنطقة الحالية</label>
                                    <select id="valley_side_id" class="form-control" name="valley_side_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['VALLEY_SIDE'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header" id="orphanFilterHeader">
                    <h5 class="mb-0">
                        <button type="button" data-bs-target="#orphanFilterCollapse" aria-expanded="true" aria-controls="orphanFilterCollapse">
                            محددات اليتيم
                        </button>
                    </h5>
                </div>
                <div id="orphanFilterCollapse" class="collapse show" aria-labelledby="orphanFilterHeader">

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_date_range" class="form-label">تاريخ الميلاد</label>
                                    <div class="input-group">
                                        <input type="text" id="child_date_range" class="form-control" readonly>
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_gender_id" class="form-label">الجنس</label>
                                    <select id="orphan_gender_id" class="form-control">
                                        <option value="">اختر</option>
                                        <option value="2">أنثى</option>
                                        <option value="1">ذكر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_age_range" class="form-label">العمر (من - إلى)</label>
                                    <div class="input-group">
                                        <input type="number" id="age_from" class="form-control" min="0" max="150" placeholder="من">
                                        <span class="input-group-text">-</span>
                                        <input type="number" id="age_to" class="form-control" min="0" max="150" placeholder="إلى">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_edu_id" class="form-label"> المستوى التعليمي</label>
                                    <select id="orphan_edu_id" name="orphan_edu_id[]" class="form-control" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['EDUCATION'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_disability_status_id" class="form-label">حالة الإعاقة</label>
                                    <select id="orphan_disability_status_id" class="form-control" name="orphan_disability_status_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['DISABILITY_STATUS'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="orphan_health_status_id" class="form-label">الحالة الصحية</label>
                                    <select id="orphan_health_status_id" class="form-control" name="orphan_health_status_id[]" multiple="multiple">
                                        <option value="">اختر</option>
                                        <?php $rows=$param['HEALTH'];
                                        foreach($rows as $r) : ?>
                                            <option value="<?= $r['id']; ?>"><?= $r['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 form-footer">
                    <button type="button" id="applyFilters" class="btn btn-primary">نفذ البحث</button>
                    <button type="reset" id="resetFilters" class="btn btn-secondary">إلغاء</button>
                </div>
            </div>
        </form>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped" id="orphanTable" width="100%" cellspacing="0">
                        <thead class="thead-dark-purble">
                                <tr>
                                    <th>الاسم</th>
                                    <th>العمر</th>
                                    <th>الوالد</th>
                                    <th>الوالدة</th>
                                    <th>الوكيل</th>
                                    <th>العلاقة</th>
                                    <th>اجراءات</th>
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
<!-- End of Main Content -->

<!-- modal delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Deleted data cannot be recovered!</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Remove</a>
      </div>
    </div>
  </div>
</div>