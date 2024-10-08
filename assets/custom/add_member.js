

$(document).ready(function() {
    $('.datepicker').datepicker({
        changeYear: true,
        changeMonth: true,
        yearRange: "1950:2024",
        dateFormat: "yy-mm-dd",
        defaultDate: new Date(1950, 0, 1),
        minDate: new Date(1950, 0, 1),
        maxDate: new Date(),
    });


    $('#identity').on('blur', function() {
        var identity=$('#identity').val();
      var isValid = validatePalestinianID(identity);
        if (isValid) {
            {
                // Create an AJAX request
                $.ajax({
                    url: base_url+'member/validate_identity',  // Replace with your actual controller/method
                    type: 'POST',
                    data: { identity: identity },
                    success: function(response) {
                        // Handle the response from the server
                        if (response.status==1) {

                        } else {
                            Swal.fire({
                                icon: "error",
                                title:"قيمة خاطئة" ,
                                text:response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        console.error('AJAX error:', status, error);
                    }
                });
            }
        } else {
            Swal.fire({
                icon: "error",
                title:"قيمة خاطئة" ,
                text: "أدخل رقم هوية صحيح  ",
            });
        }
        });

    $('#fname').off('blur').on('blur', function() {

        var fname = $(this).val();

        var isValid = validateName(fname);

        if (isValid) {
            $(' #fnameError').hide(); // Hide error message
            $(' #submitBtn').prop('disabled', false);
        } else {
            $(' #fnameError').show(); // show error message
            $(' #submitBtn').prop('disabled', true); // Disable submit button
        }
    });

    $('#sname').off('blur').on('blur', function() {

        var fname = $(this).val();
        var isValid = validateName(fname);
        if (isValid) {
            $(' #snameError').hide(); // Hide error message
            $(' #submitBtn').prop('disabled', false);
        } else {
            $(' #snameError').show(); // show error message
            $(' #submitBtn').prop('disabled', true); // Disable submit button
        }
    });

    $('#tname').off('blur').on('blur', function() {

        var fname = $(this).val();
        var isValid = validateName(fname);
        if (isValid) {
            $(' #tnameError').hide(); // Hide error message
            $(' #submitBtn').prop('disabled', false);
        } else {
            $(' #tnameError').show(); // show error message
            $(' #submitBtn').prop('disabled', true); // Disable submit button
        }
    });

    $('#lname').off('blur').on('blur', function() {

        var fname = $(this).val();
        var isValid = validateName(fname);
        if (isValid) {
            $(' #lnameError').hide(); // Hide error message
            $(' #submitBtn').prop('disabled', false);
        } else {
            $(' #lnameError').show(); // show error message
            $(' #submitBtn').prop('disabled', true); // Disable submit button
        }
    });
    });