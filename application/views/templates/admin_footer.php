<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; <?= date('Y'); ?> المنظومة الإلكترونية</span>
      </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">هل أنت متأكد من تسجيل الخروج؟</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">اختر تسجيل الخروج إذا كنت متأكد من إنهاء الجلسة</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">إلغاء</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">تسجيل الخروج</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>

<script src="<?= base_url('assets/'); ?>template/css/datepicker/jquery-ui.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
<script src="<?= base_url('assets/'); ?>template/js/sweet_alert.min.js"></script>
<!--<script src="<?/*= base_url('assets/'); */?>template/css/datepicker/bootstrap.min.js"></script>
<script src="<?/*= base_url('assets/'); */?>template/css/datepicker/bootstrap-datepicker.min.js"></script>-->
<?php if (isset($param['js_file'])):
    $rows= $param['js_file'];
    //var_dump($rows);
    foreach($rows as $r) :?>
        <script src="<?php echo base_url($r); ?>"></script>
    <?php endforeach; ?>

<?php endif; ?>
<script>

// sustom upload file
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

// ajax role
$('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');
if(roleId) {
    $.ajax({
        url: "<?= base_url('admin/changeaccess'); ?>",
        type: 'post',
        data: {
            menuId: menuId,
            roleId: roleId
        },
        success: function () {
            document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
        }
    });
}
});
$(document).ready(function() {
$(function () {
    var date = new Date();
    date.setDate(date.getDate());
   // console.log('in datepicker'+date.getDate());
    $(".datepicker").datepicker({
       // startDate: date,
        format: 'dd-mm-YYYY',
        autoclose: true,
        todayHighlight: true,
    });
});
});
</script>

</body>

</html>