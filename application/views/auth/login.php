<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?= $title; ?></h1>
                                   <div id="msg" class="alert alert-danger " hidden></div>
                                        <?php
                                        if ($this->session->flashdata('message')): ?>
                                            <?php echo $this->session->flashdata('message'); ?>
                                        <?php endif; ?>
                                </div>
                                <?php
                                $attributes=array('role'=>'form','id' => 'login_user');
                                echo form_open('auth/login_user',$attributes);
                                ?>
                              <!-- <form id="login_user" class="user" method="post" action="<?/*= base_url('auth'); */?>">-->

                                <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="user_name" name="user_name" placeholder="أدخل اسم المستخدم"
                                        value="<?= set_value('user_name'); ?>">
                                        <?= form_error('user_name', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                        <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="أدخل كلمة المرور">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-user btn-block">
                                        سجل الدخول
                                    </button>
                                </form>
                                <?php //echo form_close(); ?>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= site_url('auth/registration'); ?>">تسجيل حساب جديد!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>