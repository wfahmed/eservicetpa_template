<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="<?php echo $this->security->get_csrf_token_name(); ?>" content="<?php echo $this->security->get_csrf_hash(); ?>">
    <title>Login</title>
    <link href="<?= base_url('assets/'); ?>vendor/bootstrap/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if ($this->session->flashdata('message')): ?>
        <?php echo $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <?php  $attributes=array('role'=>'form','id' => 'login_user_form');
    echo form_open('authentication/login',$attributes); ?>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>">
        <?php echo form_error('user_name'); ?>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
        <?php echo form_error('password'); ?>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <?php echo form_close(); ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#login_user_form').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var token = $('meta[name="csrf_test_name"]').attr('content'); // Retrieve CSRF token from meta tag

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('csrf_test_name', token); // Set CSRF token in header
                },
                success: function(response) {
                   console.info(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    console.log(xhr.responseText); // Debugging
                }
            });
        });
    });
</script>
</body>
</html>
