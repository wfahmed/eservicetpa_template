
$(document).ready(function() {
    $('#orphanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+'orphan/view',
            type: 'POST',
            data: function(d) {
                var dateRange = $('#father_date_range').val().split(' - ');
                d.death_date_from = dateRange[0];
                d.death_date_to = dateRange[1];
                d.ageFrom = $('#age_from').val();
                d.ageTo = $('#age_to').val();
                d.user_status_id = $('#father_user_status_id').val();
                d.asylum_status_id = $('#father_asylum_status_id').val();
                d.naturalwork_id = $('#father_naturalwork_id').val();
                d.maretal_status_id = $('#father_maretal_status_id').val();
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
            { data: 'age' },
            { data: 'mother_name' },
            { data: 'father_name' },
            { data: 'agent_name' },
            { data: 'agent_relation_type' },
            { data: 'agent_relation_type' },
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
        $('#orphanFilterForm')[0].reset();
        $('select[multiple]').val(null).trigger('change');
        $('#father_date_range').data('daterangepicker').setStartDate('2023-01-01');
        $('#father_date_range').data('daterangepicker').setEndDate('2027-12-31');

        $('#mother_date_range').data('daterangepicker').setStartDate('2023-01-01');
        $('#mother_date_range').data('daterangepicker').setEndDate('2027-12-31');


        $('#child_date_range').data('daterangepicker').setStartDate('2023-01-01');
        $('#child_date_range').data('daterangepicker').setEndDate('2027-12-31');
        table.ajax.reload();
    });

    /****filters****/
    // Initialize date range picker
        // Get current date and last year's date
    var currentDate = moment();
    var lastYear = moment().subtract(1, 'year').startOf('year');
    var lastChildYear = moment().subtract(18, 'year').startOf('year');
// Initialize date range picker

    $('#benefit_date_range').daterangepicker({
        opens: 'left',
        minDate: lastYear,
        maxDate: currentDate,
        startDate: lastYear,
        endDate: currentDate,
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
            'العام الماضي': [lastYear, moment().subtract(1, 'year').endOf('year')]
        }
    });

    $('#father_date_range').daterangepicker({
        opens: 'left',
        minDate: lastYear,
        maxDate: currentDate,
        startDate: lastYear,
        endDate: currentDate,
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
            'العام الماضي': [lastYear, moment().subtract(1, 'year').endOf('year')]
        }
    });
    //mother
    $('#mother_date_range').daterangepicker({
        opens: 'left',
        minDate: lastYear,
        maxDate: currentDate,
        startDate: lastYear,
        endDate: currentDate,
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
            'العام الماضي': [lastYear, moment().subtract(1, 'year').endOf('year')]
        }
    });
    //child
    $('#child_date_range').daterangepicker({
        opens: 'left',
        minDate: lastChildYear,
        maxDate: currentDate,
        startDate: lastChildYear,
        endDate: currentDate,
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
            'العام الماضي': [lastYear, moment().subtract(1, 'year').endOf('year')]
        }
    });
    // Initialize select2 for multiple select
    $('select[multiple]').select2({
        placeholder: "اختر",
        allowClear: true
    });
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
});
