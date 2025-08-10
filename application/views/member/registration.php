<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
          <div class="row">
              <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                  <div class="p-5">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4"><?= $title; ?></h1>
                        <?php if (validation_errors()) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= validation_errors(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <form class="user" method="post" action="<?= base_url('member/add_employee'); ?>">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label >الاسم</label>
                                <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="الاسم الاول" required>
                                <?= form_error('fname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-6">
                                <label >الأب</label>
                                <input type="text" class="form-control form-control-user" id="sname" name="sname" placeholder="الاسم الثاني" required>
                                <?= form_error('sname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label >الجد</label>
                                <input type="text" class="form-control form-control-user" id="tname" name="tname" placeholder="الاسم الثالث" required>
                                <?= form_error('tname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-6">
                                <label >العائلة</label>
                                <input type="text" class="form-control form-control-user" id="lname" name="lname" placeholder="الاسم الرابع" required>
                                <?= form_error('lname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                      <div class="form-group">
                          <label >اسم المستخدم</label>
                        <input type="text" class="form-control form-control-user" id="user_name" name="user_name" placeholder="اسم المستخدم" required
                        value="<?= set_value('user_name'); ?>">
                        <?= form_error('user_name', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label >كلمة المرور</label>
                          <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="كلمة الكرور" required>
                          <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <label >إعادة كلمة المرور</label>
                          <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="تحقق كلمة المرور" required>
                        </div>
                      </div>
                          <div class="form-group row">
                              <div class="col-sm-6 mb-3 mb-sm-0">
                              <label >الصلاحية</label>
                              <select name="role_id" id="role_id" class="form-control selectpicker" data-live-search="true"  required>
                                  <?php
                                  $rows=$param['roles'];
                                  foreach($rows as $r) : ?>
                                      <option value="<?= $r['id']; ?>" ><?= $r['role']; ?></option>
                                  <?php endforeach; ?>
                              </select>
                          </div>
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                  <label >الهوية</label>
                                  <input type="text" class="form-control form-control-user" id="identity" name="identity" placeholder="الهوية" required

                              </div>
                          </div>

                      <button type="submit" class="btn btn-danger btn-user btn-block">
                        تسجيل حساب
                      </button>
                    </form>
                    <hr>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>