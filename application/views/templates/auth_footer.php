<script>var base_url = "<?= base_url(); ?>";</script>
<!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>template\js\sb-admin-2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#login_user').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            var token = $('meta[name="X-CSRF-Token"]').attr('content'); // Retrieve CSRF token from meta tag

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-Token', token); // Set CSRF token in header
                },
                success: function(response) {
                    if (typeof response === "string") {
                        response = JSON.parse(response);
                    }
                    console.log(response);
                    console.log(response.status);

                    switch (response.status) {
                        case "auth":
                            console.log(response.message);
                            $('#msg').removeAttr('hidden');
                            $('#msg').text(response.message);
                            break;
                        case "error":
                            $('#msg').removeAttr('hidden');
                            $('#msg').text(response.message);
                            break;
                        case "admin":
                            var trimmedStr = response.status.replace(/^"|"$/g, '');
                            window.location.href=base_url+trimmedStr;
                            break;
                        default:
                            console.log("Unknown status: " + response.status);
                    }
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