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

</style>
<script>
    function deleteContactConfirm(url){

        $('#btn-delete').attr('href', url);
        $('#deleteContactModal').modal();
    }
</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1  class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?php if(isset($param['user_row'])) $user_row=$param['user_row'];
    $rows=$param['PARENT_STATUS'];
    ?>

    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?= $this->session->flashdata('message'); ?>
    <?php $tab_id=$param['tab_id'] ;//var_dump($tab_id);die();?>

    <div class="card col-md-12 shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><a href="<?= base_url('member/family_show') ?>"><i class="fas fa-arrow-right"></i> رجوع</a></h6>
        </div>
        <div class="card-body">
            <div class="tab-container">
                <div class="tab-links">
                    <div class="active-tab"  data-id="<?=$param['id']?>"  data-tab="1" id="t1_tab">بيانات رب الأسرة</div>
                    <div class=""  data-id="<?=$param['id']?>"  data-tab="4" id="t4_tab"> الزوجات</div>
                    <div class=""  data-id="<?=$param['id']?>"  data-tab="5" id="t5_tab">بيانات الأبناء</div>
                    <div class=" "  data-id="<?=$param['id']?>"  data-tab="2" id="t2_tab">بيانات الإتصال</div>
                    <div class=""  data-id="<?=$param['id']?>"  data-tab="3" id="t3_tab">بيانات السكن</div>
                </div>
                    <div id="tab1" class="tab-content show "></div>
                    <div id="tab2"   class="tab-content"> </div>
                    <div id="tab3" class="tab-content"></div>
                    <div id="tab4" class="tab-content"></div>
                    <div id="tab5" class="tab-content"></div>


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