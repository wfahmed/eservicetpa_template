<script>
    function deleteConfirm(url){
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800" style="font-family: 'Simplified Arabic';font-weight: bolder"><?= $title; ?></h1>

    <div class="card shadow h-100 py-2">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <?= form_open_multipart('user/edit'); ?>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">البريد</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                        </div>
                    </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">المستخدم</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?= $user['user_name']; ?>" readonly>
                    </div>
                </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">الإسم الرباعي</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['full_name']; ?>" readonly>
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2">
                        الصورة
                        </div>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                                </div>
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">أدخل الملف</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Change</button>
                        </div>
                    </div>
                </form>
                <a class="badge badge-danger " style="font-size:14px;visibility: hidden;" href="#!" onclick="deleteConfirm('<?= site_url('user/deleteuser/'.$user['id']); ?>')">Delete Account</a>
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
      <div class="modal-body">Deleted accounts cannot be recovered!</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a id="btn-delete" class="btn btn-danger" href="#">Remove</a>
      </div>
    </div>
  </div>
</div>