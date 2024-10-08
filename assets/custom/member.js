function mumAgent(id){
    Swal.fire({
        title: "هل تريد جعل الأم وكيلة لأبنائها",
        icon: "question",
        iconHtml: "؟",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "نعم <i class=\"fa fa-thumbs-up\"></i>",
        denyButtonText: ` <i class="fa fa-thumbs-down"></i>لا`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                url: base_url+'agent/add_agent_mother', // Replace with your URL
                type: 'POST',
                dataType: 'json',
                data: { id: id },
                success: function(response) {
                    Swal.fire({
                        title: "نجحت",
                        text: response.message,
                        icon: "success"
                    });
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        } else if (result.isDenied) {
            Swal.fire("لم يتم الحفظ", "", "info");
        }
    });

}

function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteContactModal').modal();
}

function validate_identity_ajx(identity,user_id,form,parent_user_id,type){
    $.ajax({
        url: base_url+'member/validate_identity',  // Replace with your actual controller/method
        type: 'POST',
        data: {
            identity: identity ,
            form : form,
            parent_user_id : parent_user_id,
            type : type,
        },
        success: function(response) {
            if (response.status !== 1) {
                if (response.user_id !== user_id) {
                    Swal.fire({
                        icon: "error",
                        title:"قيمة خاطئة" ,
                        text: response.message,
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function validate_contact_ajx(contact_value,contact_type){
    $.ajax({
        url: base_url+'member/validate_contact',  // Replace with your actual controller/method
        type: 'POST',
        data: {
            contact_value: contact_value ,
            contact_type : contact_type
        },
        success: function(response) {
            if (response.status !== 1) {
                if (response.user_id !== user_id) {
                    $('#contactForm  #submitBtn').prop('disabled', true);
                    Swal.fire({
                        icon: "error",
                        title:"قيمة خاطئة" ,
                        text: response.message,
                    });
                }else{
                    $('#contactForm  #submitBtn').prop('disabled', false);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function setRadio(gender,wife_details_form, gender_id) {
    if (gender_id === null || gender_id === undefined) {
        console.error('gender_id is not defined');
        console.error(gender_id);
        return;
    }
    // Find the radio button group with name 'gender' in the provided form
    $('input[name="'+gender+'"]', wife_details_form).each(function() {
        // Check if this radio button's value matches the provided gender_id
        if ($(this).val() === gender_id.toString()) {
            $(this).prop('checked', true); // Set the radio button to checked
        } else {
            $(this).prop('checked', false); // Ensure other radio buttons are unchecked
        }
    });
}

function initializeSelect2() {
    $('#death_reason').select2({
        placeholder: 'Select an option',
        allowClear: true,
        width: '100%' // Ensure Select2 fits within the container
    });
}

function getMemDetails(id) {
    $.ajax({
        url: base_url + 'member/get_details',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            // Ensure the tab content is fully loaded before modifying the form
                var form = $('#wife_details_form');
                if (response.id !== 0) {
                    // Update form action URL
                    form.attr('action', base_url + 'member/edit_member/' + response.id+'/4');

                    $('#user_id', form).val(response.id);
                    $('#huz_user_id', form).val(response.huspand_user_id);
                    $('#fname', form).val(response.fname);
                    $('#sname', form).val(response.sname);
                    $('#tname', form).val(response.tname);
                    $('#lname', form).val(response.lname);
                    $('#identity', form).val(response.identity);
                    $('#user_status', form).val(response.user_status_id);
                    $('#maretal_status', form).val(response.maretal_status_id);
                    $('#wife_death_date', form).val(response.death_date);
                    $('#death_reason', form).val(response.death_reason_id);
                    $('#incom', form).val(response.incom);
                    $('#dob_wife', form).val(response.dob);
                    $('#after_death_incom', form).val(response.after_death_incom);
                    $('#naturalwork', form).val(response.naturalwork_id);

                    // Set radio button values
                    setRadio('gender', form, response.gender_id);
                    setRadio('asylum_status', form, response.asylum_status_id);
                    $('#dob_wife', form).each(function() {
                        $(this).datepicker({
                            changeYear: true,
                            changeMonth: true,
                            yearRange: "1950:2024",
                            dateFormat: "yy-mm-dd",
                            defaultDate: new Date(1950, 0, 1),
                            minDate: new Date(1950, 0, 1),
                            maxDate: new Date(),
                        });
                    });
                    $('#wife_death_date', form).each(function() {
                        $(this).datepicker({
                            changeYear: true,
                            changeMonth: true,
                            yearRange: "1950:2024",
                            dateFormat: "yy-mm-dd",
                            defaultDate: new Date(1950, 0, 1),
                            minDate: new Date(1950, 0, 1),
                            maxDate: new Date(),
                        });
                    });
                }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function getChildDetails(id) {
    $.ajax({
        url: base_url + 'member/get_details',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            // Ensure the tab content is fully loaded before modifying the form
            var form = $('#child_details_form');
            if (response.id !== 0) {
                // Update form action URL
                form.attr('action', base_url + 'member/edit_member/' + response.id+'/5');

                $('#user_id', form).val(response.id);
                $('#parent_user_id', form).val(response.parent_user_id);
                $('#fname', form).val(response.fname);
                $('#sname', form).val(response.sname);
                $('#tname', form).val(response.tname);
                $('#lname', form).val(response.lname);
                $('#identity', form).val(response.identity);
                $('#user_status', form).val(response.user_status_id);
                $('#maretal_status', form).val(response.maretal_status_id);
                $('#child_death_date_detail', form).val(response.death_date);
                $('#death_reason', form).val(response.death_reason_id);
                $('#relation_type_id', form).val(response.relation_type_id);
                $('#incom', form).val(response.incom);
                $('#dob_child_detail', form).val(response.dob);
                $('#after_death_incom', form).val(response.after_death_incom);
                $('#naturalwork', form).val(response.naturalwork_id);

                // Set radio button values
                setRadio('gender', form, response.gender_id);
                setRadio('asylum_status', form, response.asylum_status_id);
                $('#dob_child_detail', form).each(function() {
                    $(this).datepicker({
                        changeYear: true,
                        changeMonth: true,
                        yearRange: "1950:2024",
                        dateFormat: "yy-mm-dd",
                        defaultDate: new Date(1950, 0, 1),
                        minDate: new Date(1950, 0, 1),
                        maxDate: new Date(),
                    });
                });
                $('#child_death_date_detail', form).each(function() {
                    $(this).datepicker({
                        changeYear: true,
                        changeMonth: true,
                        yearRange: "1950:2024",
                        dateFormat: "yy-mm-dd",
                        defaultDate: new Date(1950, 0, 1),
                        minDate: new Date(1950, 0, 1),
                        maxDate: new Date(),
                    });
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function initializeFormHandlers() {
    var contactForm = document.getElementById('contactForm');
    if (contactForm) {
        var selectElement = contactForm.querySelector('#contact_type');
        var contactValueInput = contactForm.querySelector('#contact_value');

        if (selectElement && contactValueInput) {
            selectElement.addEventListener('change', function() {
                updateValidation(this.value, contactValueInput);
            });

            // Initial validation setup
            updateValidation(selectElement.value, contactValueInput);
        }
        $('#contactForm #contact_value').off('blur').on('blur', function() {
            var contact_value = $(this).val();
            var contact_type =$('#contactForm #contact_type').val();
                validate_contact_ajx(contact_value,contact_type);
        });
    }

    var father_form = document.getElementById('father_form');
    if (father_form) {
        let user_id = $('#user_id', father_form).val();
        $('#identity', father_form).off('blur').on('blur', function() {
            var identity = $(this).val();
            var isValid = validatePalestinianID(identity);
            if (isValid) {
                validate_identity_ajx(identity, user_id,'father',0,0);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "قيمة خاطئة",
                    text: "أدخل رقم هوية صحيح  ",
                });
            }
        });

        $('#father_form #fname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#father_form  #fnameError').hide(); // Hide error message
                $('#father_form  #submitBtn').prop('disabled', false);
            } else {
                $('#father_form  #fnameError').show(); // show error message
                $('#father_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#father_form #sname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#father_form  #snameError').hide(); // Hide error message
                $('#father_form  #submitBtn').prop('disabled', false);
            } else {
                $('#father_form  #snameError').show(); // show error message
                $('#father_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#father_form #tname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#father_form  #tnameError').hide(); // Hide error message
                $('#father_form  #submitBtn').prop('disabled', false);
            } else {
                $('#father_form  #tnameError').show(); // show error message
                $('#father_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#father_form #lname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#father_form  #lnameError').hide(); // Hide error message
                $('#father_form  #submitBtn').prop('disabled', false);
            } else {
                $('#father_form  #lnameError').show(); // show error message
                $('#father_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#dob_father', father_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });

        $('#father_death_date', father_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });


    }

    // Handling form for wife
    var wifeForm = document.getElementById('wife_form');
    if (wifeForm) {
        let user_id = $('#user_id', wifeForm).val();
        $('#identity', wifeForm).off('blur').on('blur', function() {
            var identity = $(this).val();
            var maretal_status = $('#wife_form #maretal_status').val();
            var huz_user_id = $('#wife_form #husband_user_id').val();
            var isValid = validatePalestinianID(identity);
            if (isValid) {
                validate_identity_ajx(identity, user_id,'wife',huz_user_id,maretal_status);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "قيمة خاطئة",
                    text: "أدخل رقم هوية صحيح  ",
                });
            }
        });
        $('#dob', wifeForm).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });
        $('#death_date', wifeForm).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });

        $('#wife_form #fname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_form  #fnameError').hide(); // Hide error message
                $('#wife_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_form  #fnameError').show(); // show error message
                $('#wife_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_form #sname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_form  #snameError').hide(); // Hide error message
                $('#wife_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_form  #snameError').show(); // show error message
                $('#wife_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_form #tname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_form  #tnameError').hide(); // Hide error message
                $('#wife_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_form  #tnameError').show(); // show error message
                $('#wife_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_form #lname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#wife_form  #lnameError').hide(); // Hide error message
                $('#wife_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_form  #lnameError').show(); // show error message
                $('#wife_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });
    }

    // Handling form for wife_details_form
    var wife_details_form = document.getElementById('wife_details_form');
    if (wife_details_form) {
        $('#wife_details_form #fname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_details_form  #fnameError').hide(); // Hide error message
                $('#wife_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_details_form  #fnameError').show(); // show error message
                $('#wife_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_details_form #sname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_details_form  #snameError').hide(); // Hide error message
                $('#wife_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_details_form  #snameError').show(); // show error message
                $('#wife_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_details_form #tname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#wife_details_form  #tnameError').hide(); // Hide error message
                $('#wife_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_details_form  #tnameError').show(); // show error message
                $('#wife_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#wife_details_form #lname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#wife_details_form  #lnameError').hide(); // Hide error message
                $('#wife_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#wife_details_form  #lnameError').show(); // show error message
                $('#wife_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#identity', wife_details_form).off('blur').on('blur', function() {
            var identity = $(this).val();
            var maretal_status = $('#wife_details_form #maretal_status').val();
            var huz_user_id = $('#wife_details_form #huz_user_id').val();
            var isValid = validatePalestinianID(identity);
            if (isValid) {
                let user_id = $('#user_id', wife_details_form).val();
                validate_identity_ajx(identity, user_id,'wife',huz_user_id,maretal_status);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "قيمة خاطئة",
                    text: "أدخل رقم هوية صحيح  ",
                });
            }
        });

        $('#dob_wife', wife_details_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });

        $('#wife_death_date', wife_details_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });
    }

    // Handling form for child
    var child_form = document.getElementById('child_form');
    if (child_form) {
        $('#child_form #fname').off('blur').on('blur', function() {

            var fname = $(this).val();
         
            var isValid = validateName(fname);
           
            if (isValid) {
                $('#child_form  #fnameError').hide(); // Hide error message
                $('#child_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_form  #fnameError').show(); // show error message
                $('#child_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_form #sname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_form  #snameError').hide(); // Hide error message
                $('#child_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_form  #snameError').show(); // show error message
                $('#child_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_form #tname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_form  #tnameError').hide(); // Hide error message
                $('#child_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_form  #tnameError').show(); // show error message
                $('#child_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_form #lname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_form  #lnameError').hide(); // Hide error message
                $('#child_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_form  #lnameError').show(); // show error message
                $('#child_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });
        
        let user_id = $('#user_id', child_form).val();
        $('#identity', child_form).off('blur').on('blur', function() {
            var identity = $(this).val();
            var parent_user_id = $('#child_form #parent_user_id').val();
            var isValid = validatePalestinianID(identity);
            if (isValid) {
                validate_identity_ajx(identity, user_id,'child',parent_user_id,0);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "قيمة خاطئة",
                    text: "أدخل رقم هوية صحيح  ",
                });
            }
        });
      
        $('#dob_child', child_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });
      
        $('#child_death_date', child_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });
     
       $('#user_status',child_form).val(7);
       
        $('#maretal_status',child_form).val(10);
       
        $('#relation_type_id',child_form).val(143);
        child_form.querySelectorAll('input[name="gender"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                let selectedGender = event.target.value;
                if (selectedGender === "1") {
                    $('#relation_type_id', child_form).val(143); // Set relation type for male
                } else if (selectedGender === "2") {
                    $('#relation_type_id', child_form).val(144); // Set relation type for female
                }
            });
        });

    }

    // Handling form for child
    var child_details_form = document.getElementById('child_details_form');
    if (child_details_form) {
        $('#child_details_form #fname').off('blur').on('blur', function() {

            var fname = $(this).val();

            var isValid = validateName(fname);

            if (isValid) {
                $('#child_details_form  #fnameError').hide(); // Hide error message
                $('#child_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_details_form  #fnameError').show(); // show error message
                $('#child_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_details_form #sname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_details_form  #snameError').hide(); // Hide error message
                $('#child_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_details_form  #snameError').show(); // show error message
                $('#child_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_details_form #tname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_details_form  #tnameError').hide(); // Hide error message
                $('#child_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_details_form  #tnameError').show(); // show error message
                $('#child_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        $('#child_details_form #lname').off('blur').on('blur', function() {

            var fname = $(this).val();
            var isValid = validateName(fname);
            if (isValid) {
                $('#child_details_form  #lnameError').hide(); // Hide error message
                $('#child_details_form  #submitBtn').prop('disabled', false);
            } else {
                $('#child_details_form  #lnameError').show(); // show error message
                $('#child_details_form  #submitBtn').prop('disabled', true); // Disable submit button
            }
        });

        let user_id = $('#user_id', child_details_form).val();
        $('#identity', child_details_form).off('blur').on('blur', function() {
            var identity = $(this).val();
            var parent_user_id = $('#child_details_form #parent_user_id').val();
            var isValid = validatePalestinianID(identity);
            if (isValid) {
                validate_identity_ajx(identity, user_id,'child',parent_user_id,0);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "قيمة خاطئة",
                    text: "أدخل رقم هوية صحيح  ",
                });
            }
        });

        $('#dob_child_detail', child_details_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });

        $('#child_death_date_detail', child_details_form).each(function() {
            $(this).datepicker({
                changeYear: true,
                changeMonth: true,
                yearRange: "1950:2024",
                dateFormat: "yy-mm-dd",
                defaultDate: new Date(1950, 0, 1),
                minDate: new Date(1950, 0, 1),
                maxDate: new Date(),
            });
        });

        child_details_form.querySelectorAll('input[name="gender"]').forEach((elem) => {
            elem.addEventListener("change", function(event) {
                let selectedGender = event.target.value;
                if (selectedGender === "1") {
                    $('#relation_type_id', child_details_form).val(143); // Set relation type for male
                } else if (selectedGender === "2") {
                    $('#relation_type_id', child_details_form).val(144); // Set relation type for female
                }
            });
        });
    }

    // Handling form for dwelling
    var dwellingForm = document.getElementById('dwelling_form');
    if (dwellingForm) {
        dwellingForm.addEventListener('submit', function(event) {
            var requiredFields = dwellingForm.querySelectorAll('[required]');
            var isValid = true;

            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.setCustomValidity('هذا الحقل مطلوب');
                } else {
                    field.setCustomValidity(''); // Remove custom message if field is filled
                }
            });

            if (!isValid) {
                event.preventDefault();
                dwellingForm.reportValidity();
            }
        });
    }

}

document.addEventListener('DOMContentLoaded', function () {
    // Initialize form handlers when the DOM is ready
    initializeFormHandlers();

    // Use a timeout to delay the activation of the first tab
    setTimeout(function() {
        var firstTab = document.querySelector('.tab-links div:first-child');
        if (firstTab) {
            var firstTabTarget = firstTab.getAttribute('data-tab');
            if (firstTabTarget) {
                // Activate the tab using the data-tab value
                $('#t' + firstTabTarget + '_tab').click();
            }
        }
    }, 100);  // Adjust this timeout if needed

    // Reinitialize handlers on tab change
    document.querySelectorAll('.tab-links div').forEach(tab => {
        tab.addEventListener('click', function () {
            setTimeout(function() {
                initializeFormHandlers(); // Ensure form handlers are reinitialized
              //  initializeTabDatepickers();   // Reinitialize Datepicker
            }, 100); // Delay to ensure content is loaded
        });
    });

});

$(document).ready(function() {
    $('.tab-links div').on('click', function(e) {
        e.preventDefault();
        var tabId = $(this).data('tab');
        var Id = $(this).data('id');
        var target = '#tab' + tabId;

        if (!$(target).hasClass('loaded')) {
            // Load content if not already loaded
            $(target).load(base_url+'member/load_tab/'+tabId+'/'+Id, function() {
                $(target).addClass('loaded');
                initializeFormHandlers();
                if (tabId == '1') {
                    initializeSelect2();
                }
                if (tabId == '4') {
                    initializeSelect2();
                }
                if (tabId == '5') {
                    initializeSelect2();
                }

            });
        } else {
           // initializeTabDatepickers(); // Reinitialize Datepicker if tab was already loaded
        }
    });

    var tabId = getUrlSegment(4);

    if (tabId) {
        $('#t' + tabId + '_tab').click(); // Click the tab dynamically
    } else {
        // Default tab if no tabId is found
        setTimeout(function() {
            $('#t1_tab').click();
        }, 100);  // Adjust this timeout if needed
    }
});