<script>var base_url = "<?= base_url(); ?>";</script>

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
          <span> © <?= date('Y'); ?>&nbsp;&nbsp;المنظومة الإلكترونية  | جمعية فلسطين الغد &nbsp;&nbsp; </span>
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
<script src="<?= base_url('assets/'); ?>vendor/datepicker/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/popper.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- Load jQuery, Popper.js, and Bootstrap JS from CDN -->


  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>template/js/sb-admin-2.min.js"></script>
  <script src="<?= base_url('assets/'); ?>template/js/moment.min.js"></script>
  <script src="<?= base_url('assets/'); ?>template/js/daterangepicker.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->

<script src="<?= base_url('assets/'); ?>template/js/select2.min.js"></script>
<script src="<?= base_url('assets/'); ?>template/js/sweet_alert.min.js"></script>
<script src="<?= base_url('assets/'); ?>template/js/axios.min.js"></script>
<script src="<?= base_url('assets/'); ?>template/js/main.js"></script>

<!--<script src="<?/*= base_url('assets/'); */?>custom/maximize_header.js"></script>-->
<!--<script src="<?/*= base_url('assets/'); */?>custom/tag_input.js"></script>-->
<!--<script src="<?/*= base_url('assets/'); */?>template/css/datepicker/bootstrap-datepicker.min.js"></script>-->

<?php if (isset($param['js_file'])):
    $rows= $param['js_file'];
    //var_dump($rows);
    foreach($rows as $r) :?>
        <script src="<?php echo base_url($r); ?>"></script>
    <?php endforeach; ?>

<?php endif; ?>
</body>

</html>