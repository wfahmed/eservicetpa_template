function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteContactModal').modal();
}

function getEduDetails(id) {
    $.ajax({
        url: base_url + 'cv/detail_edu',
        type: 'POST',
        data: { edu_id: id },
        success: function(response) {
            // Ensure the tab content is fully loaded before modifying the form
            // Attempt to parse the response to ensure it's valid JSON
            var form = $('#eduForm');
            if (response.edu_id !== 0) {
                // Update form action URL
                form.attr('action', base_url + 'cv/edit_edu/' + response.edu_id);

                // Update form fields
                $('#attach_id', form).val(response.attach_id);
                $('#user_id', form).val(response.usid); // Corrected from `usid` to `user_id`
                $('#edu_level_id', form).val(response.edu_level_id);
                $('#edu_stage_id', form).val(response.edu_stage_id);
                $('#edu_details', form).val(response.edu_details);

                // Handle the health report link visibility and href
                var eduReport = $('#eduReport', form);
                if (response.attach_id) {
                    eduReport.removeClass('d-none'); // Ensure class is removed if the report exists
                    eduReport.attr('href', base_url + '/' + response.attach_path); // Set the correct href
                } else {
                    eduReport.addClass('d-none'); // Hide the link if no report exists
                }
            }

        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function getHealthDetails(id) {
    $.ajax({
        url: base_url + 'cv/detail_health',
        type: 'POST',
        data: { health_id: id },
        success: function(response) {
            // Ensure the tab content is fully loaded before modifying the form
            // Attempt to parse the response to ensure it's valid JSON
                var form = $('#healthForm');
            if (response.health_id !== 0) {
                // Update form action URL
                form.attr('action', base_url + 'cv/edit_health/' + response.health_id);

                // Update form fields
                $('#attach_id', form).val(response.attach_id);
                $('#user_id', form).val(response.usid); // Corrected from `usid` to `user_id`
                $('#disability_type_id', form).val(response.disability_type_id);
                $('#health_status_id', form).val(response.health_status_id);
                $('#health_details', form).val(response.health_details);

                // Handle the health report link visibility and href
                var healthReport = $('#healthReport', form);
                if (response.attach_id) {
                    healthReport.removeClass('d-none'); // Ensure class is removed if the report exists
                    healthReport.attr('href', base_url + '/' + response.attach_path); // Set the correct href
                } else {
                    healthReport.addClass('d-none'); // Hide the link if no report exists
                }
            }

        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
        }
    });
}

function populateSubTypes(selectedNeedTypeId) {
    if (selectedNeedTypeId) {
        $.ajax({
            url: base_url + 'cv/get_select', // Replace with your controller method URL
            type: 'POST',
            data: { need_type_id: selectedNeedTypeId },
            dataType: 'json',
            success: function(response) {
                var $subTypeSelect = $('#needu_sub_type_id', needForm);
                $subTypeSelect.empty(); // Clear previous options

                if (response.length > 0) {
                    $.each(response, function(index, item) {
                        $subTypeSelect.append(
                            $('<option></option>').val(item.id).text(item.title)
                        );
                    });
                } else {
                    $subTypeSelect.append(
                        $('<option></option>').val('').text('No options available')
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    }
}


function initializeFormHandlers() {
    var healthForm = document.getElementById('healthForm');
    if (healthForm) {
        healthForm.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            label.innerHTML = fileName;
        });
    }

    var eduForm = document.getElementById('eduForm');
    if (eduForm) {
        eduForm.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            var label = e.target.nextElementSibling;
            label.innerHTML = fileName;
        });
        var eduLevelSelect = document.querySelector('#edu_level_id',eduForm);
        if (eduLevelSelect) {
            eduLevelSelect.addEventListener('change', function(e) {
                var selectedOption = e.target.options[e.target.selectedIndex];
                var selectedValue = selectedOption.getAttribute('data-parent');// Get the value of the selected option
                document.querySelector('#edu_stage_id',eduForm).value = selectedValue; // Update the value of the input field
            });
        }
    }

    var hobForm = document.getElementById('hobForm');
    if (hobForm) {
        $('#hobby_id',hobForm).select2({
            placeholder: "اختر الهوايات",
            allowClear: true
        });
    }

    var needForm = document.getElementById('needForm');
    if (needForm) {
        var initialNeedTypeId = $('#need_type_id', needForm).val();
        populateSubTypes(initialNeedTypeId);
        $('#need_type_id',needForm).on('change', function() {
            var selectedNeedTypeId = $(this).val();

            if (selectedNeedTypeId) {
                populateSubTypes(selectedNeedTypeId);
            }
        });
        $('#needu_sub_type_id',needForm).select2({
            placeholder: "اختر الاحتياج",
            allowClear: true
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
            $(target).load(base_url+'cv/load_tab/'+tabId+'/'+Id, function() {
                $(target).addClass('loaded');
                initializeFormHandlers();
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