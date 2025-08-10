function gatherFormData(sections) {
    let formData = {};

    sections.forEach(section => {
        formData[section] = {};  // Create a nested object for each section
        const $div = $(`#${section}FilterCollapse`);

        // Handle date range
        const $dateRange = $div.find(`#${section}_date_range`);
        if ($dateRange.length) {
            const dateRange = $dateRange.val(); // Get the value from the date range input
            console.log('dateRange= ' + dateRange);

            // Check if the value contains ' - ' to ensure it is a range
            if (dateRange.includes(' - ')) {
                const dateRangeArray = dateRange.split(' - '); // Split into start and end dates

                // Extract the start and end dates
                formData[section]['death_date_from'] = dateRangeArray[0];
                formData[section]['death_date_to'] = dateRangeArray[1];

                console.log('from= ' + formData[section]['death_date_from']);
                console.log('to= ' + formData[section]['death_date_to']);
                var dateRange2 = $('#father_date_range').val().split(' - ');
                console.log('dateRange2= ' + dateRange2);
            } else {
                // Handle case where the date range is not formatted correctly
                console.error('Date range format is incorrect: ' + dateRange);
            }
        }

        // Handle select inputs
        const selectFields = [
            'user_status_id',
            'asylum_status_id',
            'naturalwork_id',
            'maretal_status_id',
            'disability_status_id',
            'health_status_id'
        ];

        selectFields.forEach(field => {
            const $select = $div.find(`#${section}_${field}`);
            if ($select.length) {
                formData[section][field] = $select.val();
            }
        });
    });

    return formData;
}


$(document).ready(function() {
    // Get the current date
    var currentDate = new Date();

// Subtract 18 years from the current date to calculate the start date
    var startDate = new Date();
    startDate.setFullYear(currentDate.getFullYear() - 18);

// Format the start and end dates as 'YYYY-MM-DD' using moment.js
    var formattedStartDate = moment(startDate).format('YYYY-MM-DD');
    var formattedEndDate = moment(currentDate).format('YYYY-MM-DD');
    var table = $('#orphanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+'orphan/view',
            type: 'POST',
            data: function(d) {
                /************father************/
                var dateRange = $('#father_date_range').val().split(' - ');
                /************mother************/
                const formData = gatherFormData(['father', 'mother']);
                return {...d, ...formData};
            },
            dataSrc: function(json) {
                console.log('Received data:', json);
                if (!json.data) {
                    console.error('Invalid data structure received');
                    return [];
                }
                return json.data;
            },
            error: function (xhr, error, thrown) {
                console.error('Ajax error:', error);
                console.log('Server response:', xhr.responseText);
            }
        },
        columns: [
            { data: 'full_name' },
            { data: 'identity' },
            { data: 'mother_name' },
            { data: 'father_name' },
            {
                data: null, // Use null because we will create a custom renderer
                render: function(data, type, row) {
                    return `
                    <a class="badge badge-primary btn-style" href="${base_url}member/detailmember/${row.id}">تفاصيل</a>
                    <a class="badge badge-danger btn-style" href="${base_url}member/printmember/${row.id}">طباعة</a>
                    <a class="badge badge-success btn-style" href="${base_url}member/edit_member/${row.parent_user_id}">إدارة الأسرة</a>
                    <a class="badge btn-style" style="background-color:#1d5441" href="${base_url}cv/index/${row.id}">السيرة الذاتية</a>
                `;
                }
            }
        ] ,
        initComplete: function(settings, json) {
            console.log('DataTable initialization complete');
        }
    });
    // Apply filters
    $('#applyFilters').on('click', function() {
        table.ajax.reload();
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
            // Reset the form
            $('#orphanFilterForm')[0].reset();

            // Reset all selectpicker fields (multiple and single selects)
            $('select.selectpicker').val(null).selectpicker('refresh');  // For resetting all selectpickers

            // If there are multiple selections in the selectpicker, reset it to null or default state
            $('select[multiple]').val(null).selectpicker('refresh');  // Specifically for multiple selects
// Reset date ranges for the different date pickers
        $('#father_date_range').data('daterangepicker').setStartDate(formattedStartDate);
        $('#father_date_range').data('daterangepicker').setEndDate(formattedEndDate);

        $('#mother_date_range').data('daterangepicker').setStartDate(formattedStartDate);
        $('#mother_date_range').data('daterangepicker').setEndDate(formattedEndDate);

        $('#child_date_range').data('daterangepicker').setStartDate(formattedStartDate);
        $('#child_date_range').data('daterangepicker').setEndDate(formattedEndDate);
            // Reload the DataTable or perform any other actions
            table.ajax.reload();
        });

    /****filters****/

// Initialize the date range picker with the calculated start and end dates
    $('#father_date_range').daterangepicker({
        opens: 'left',
        minDate: formattedStartDate,  // Minimum selectable date (18 years ago)
        maxDate: formattedEndDate,    // Maximum selectable date (today)
        startDate: null, // Initial start date (18 years ago)
        endDate: null,     // Initial end date (today)
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'تطبيق',
            cancelLabel: 'إلغاء',
            fromLabel: 'من',
            toLabel: 'إلى',
            customRangeLabel: 'مخصص',
            daysOfWeek: ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],
            monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            firstDay: 6
        },
        ranges: {
            'اليوم': [moment(), moment()],
            'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'آخر 7 أيام': [moment().subtract(6, 'days'), moment()],
            'آخر 30 يوم': [moment().subtract(29, 'days'), moment()],
            'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
            'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'العام الحالي': [moment().startOf('year'), moment()],
            'العام الماضي': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    });
    $('#father_date_range').val('');

    $('#benefit_date_range').daterangepicker({
        opens: 'left',
        minDate: formattedStartDate,  // Minimum selectable date (18 years ago)
        maxDate: formattedEndDate,    // Maximum selectable date (today)
        startDate: null, // Initial start date (18 years ago)
        endDate: null,     // Initial end date (today)
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'تطبيق',
            cancelLabel: 'إلغاء',
            fromLabel: 'من',
            toLabel: 'إلى',
            customRangeLabel: 'مخصص',
            daysOfWeek: ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],
            monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            firstDay: 6
        },
        ranges: {
            'اليوم': [moment(), moment()],
            'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'آخر 7 أيام': [moment().subtract(6, 'days'), moment()],
            'آخر 30 يوم': [moment().subtract(29, 'days'), moment()],
            'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
            'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'العام الحالي': [moment().startOf('year'), moment()],
            'العام الماضي': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    });
    $('#benefit_date_range').val('');
    //mother

    $('#mother_date_range').daterangepicker({
        opens: 'left',
        minDate: formattedStartDate,  // Minimum selectable date (18 years ago)
        maxDate: formattedEndDate,    // Maximum selectable date (today)
        startDate: null, // Initial start date (18 years ago)
        endDate: null,     // Initial end date (today)
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'تطبيق',
            cancelLabel: 'إلغاء',
            fromLabel: 'من',
            toLabel: 'إلى',
            customRangeLabel: 'مخصص',
            daysOfWeek: ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],
            monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            firstDay: 6
        },
        ranges: {
            'اليوم': [moment(), moment()],
            'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'آخر 7 أيام': [moment().subtract(6, 'days'), moment()],
            'آخر 30 يوم': [moment().subtract(29, 'days'), moment()],
            'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
            'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'العام الحالي': [moment().startOf('year'), moment()],
            'العام الماضي': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    });
    $('#mother_date_range').val('');
    //child
    $('#child_date_range').daterangepicker({
        opens: 'left',
        minDate: formattedStartDate,  // Minimum selectable date (18 years ago)
        maxDate: formattedEndDate,    // Maximum selectable date (today)
        startDate: null, // Initial start date (18 years ago)
        endDate: null,     // Initial end date (today)
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'تطبيق',
            cancelLabel: 'إلغاء',
            fromLabel: 'من',
            toLabel: 'إلى',
            customRangeLabel: 'مخصص',
            daysOfWeek: ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],
            monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
            firstDay: 6
        },
        ranges: {
            'اليوم': [moment(), moment()],
            'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'آخر 7 أيام': [moment().subtract(6, 'days'), moment()],
            'آخر 30 يوم': [moment().subtract(29, 'days'), moment()],
            'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
            'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'العام الحالي': [moment().startOf('year'), moment()],
            'العام الماضي': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    });
    $('#child_date_range').val('');
    /**********/
    // Initialize Bootstrap collapse
    var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
    var collapseList = collapseElementList.map(function (collapseEl) {
        return new bootstrap.Collapse(collapseEl, {
            toggle: false
        })
    });
    // Add click event listeners to toggle collapse state for the entire header
    // Add click event listeners to toggle collapse state for the entire header
    $('.card-header').on('click', function(e) {
        e.preventDefault();

        console.log('Header clicked');
        var $header = $(this);
        var $button = $header.find('button');
        var target = $button.data('bs-target');

        $(target).collapse('toggle');

        // Toggle the aria-expanded attribute
        var isExpanded = $button.attr('aria-expanded') === 'true';
        $button.attr('aria-expanded', !isExpanded);
    });

    $('.card-header').click();
    /*********/
    $('#age_from, #age_to').on('change', function() {
        var fromAge = parseInt($('#age_from').val()) || 0;
        var toAge = parseInt($('#age_to').val()) || 150;

        if (fromAge > toAge) {
            $('#age_to').val(fromAge);
        }
    });
    /*****select******************/
// Initialize city select picker
    // Initialize city select picker
    $('#city_id').selectpicker({
        liveSearch: true,
        size: 10,
        width: '100%',
        showSubtext: true,
        liveSearchPlaceholder: 'ابحث....',
        noneSelectedText: 'اختر',
        deselectAllText: 'إلغاء التحديد',
        selectAllText: 'تحديد الكل',
        actionsBox: true
    });

// Initialize other select pickers (initially hidden)
    $('#general_area_id, #local_area_id, #nearest_famous_place,#orphan_gender_id').selectpicker({
        liveSearch: true,
        size: 10,
        width: '100%',
        showSubtext: true,
        liveSearchPlaceholder: 'ابحث....',
        noneSelectedText: 'اختر',
        deselectAllText: 'إلغاء التحديد',
        selectAllText: 'تحديد الكل',
        actionsBox: true
    });
    $('#general_area_id, #local_area_id, #nearest_famous_place').selectpicker('hide');

    $('#city_id').on('changed.bs.select', function () {
        var selectedValue = $(this).val();
        if (selectedValue) {
            $('#general_area_id').empty().selectpicker('refresh');
            $.ajax({
                url: base_url + '/member/get_general_area',
                type: 'POST',
                data: {
                    city_id: selectedValue,
                    mode: 1,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.length > 0) {
                        $.each(response, function (index, area) {
                            $('#general_area_id').append($('<option>', {
                                value: area.id,
                                text: area.title
                            }));
                        });
                        $('#general_area_id').selectpicker('refresh').selectpicker('show');
                    } else {
                        $('#general_area_id').selectpicker('hide');
                        Swal.fire({
                            icon: 'warning',
                            title: 'لا يوجد مناطق',
                            text: 'لا يوجد مناطق في هذه المدينة',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function () {
                    $('#general_area_id').selectpicker('hide');
                    Swal.fire({
                        icon: 'warning',
                        title: 'لا يوجد مناطق',
                        text: 'لا يوجد مناطق في هذه المحافظة',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    // General Area Change Event
    $('#general_area_id').on('changed.bs.select', function () {
        var generalAreaID = $(this).val();
        if (generalAreaID) {
            $('#local_area_id').empty().selectpicker('refresh').hide();
            $('#nearest_famous_place').empty().selectpicker('refresh').hide();
            $.ajax({
                url: base_url + '/member/get_local_area',
                type: 'POST',
                data: {
                    general_area_id: generalAreaID,
                    mode:1
                },
                dataType: 'json',
                success: function (response) {
                    if (response.length > 0) {
                        $.each(response, function (index, area) {
                            var option = $('<option>', {
                                value: area.id,
                                text: area.title
                            });
                            $('#local_area_id').append(option);
                        });
                        $('#local_area_id').selectpicker('show').selectpicker('refresh');
                    } else {
                        $('#local_area_id').hide();
                        Swal.fire({
                            icon: 'warning',
                            title: 'لا يوجد أحياء',
                            text: 'لا يوجد أحياء في هذه المنطقة',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    $('#local_area_id').hide();
                    Swal.fire({
                        icon: 'warning',
                        title: 'لا يوجد أحياء',
                        text: 'لا يوجد أحياء في هذه المنطقة',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });

    // Local Area Change Event
    $('#local_area_id').on('changed.bs.select', function () {
        var placeID = $(this).val();
        if (placeID) {
            $('#nearest_famous_place').empty().selectpicker('refresh').hide();
            $.ajax({
                url: base_url + '/member/get_landmark',
                type: 'POST',
                data: {
                    placeID: placeID,
                    mode:1
                },
                dataType: 'json',
                success: function (response) {
                    if (response.length > 0) {
                        $.each(response, function (index, area) {
                            var option = $('<option>', {
                                value: area.id,
                                text: area.title
                            });
                            $('#nearest_famous_place').append(option);
                        });

                        $('#nearest_famous_place').selectpicker('show').selectpicker('refresh');
                    } else {
                        $('#nearest_famous_place').hide();
                        Swal.fire({
                            icon: 'warning',
                            title: 'لا يوجد معالم',
                            text: 'لا يوجد معالم في هذا الحي',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'لا يوجد معالم',
                        text: 'لا يوجد معالم في هذا الحي',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    });


});
