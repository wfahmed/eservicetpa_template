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
                    </div>
                    <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="الاسم الاول">
                                <?= form_error('fname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="sname" name="sname" placeholder="الاسم الثاني">
                                <?= form_error('sname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="tname" name="tname" placeholder="الاسم الثالث">
                                <?= form_error('tname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-user" id="lname" name="lname" placeholder="الاسم الرابع">
                                <?= form_error('lname', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="user_name" name="user_name" placeholder="اسم المستخدم"
                        value="<?= set_value('user_name'); ?>">
                        <?= form_error('user_name', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="البريد الالكتروني"
                        value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                          <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="كلمة الكرور">
                          <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                          <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="تحقق كلمة المرور">
                        </div>
                      </div>
                      <button type="submit" class="btn btn-danger btn-user btn-block">
                        تسجيل حساب
                      </button>
                    </form>
                    <hr>
                    <div class="text-center">
                      <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">هل نسيت كلمة المرور؟</a>
                    </div>
                    <div class="text-center">
                      <a class="small" href="<?= site_url('auth'); ?>">لديك حساب بالفعل؟ سجل الدخول الآن!</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>