const approved_value = document.getElementById('approved_value');
const unit_price = document.getElementById('unit_price');
const unit_amount = document.getElementById('unit_amount');

function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteContactModal').modal();
}
function details_stages_Modal(url){
    $.ajax({
        type: 'POST',
        url: '' +  url,
        data: '',
        cache: false,
        dataType: 'html',
        context: document.body,
        success: function (data) {
            res = JSON.parse(data);
            $('#proj_fk').val(res.proj_fk);
            $('#ps_fk').val(res.ps_fk);
            $('#proj_stage_id').val(res.proj_stage_id);
            $('#total_executed').val(res.total_executed);
            $('#executed_value').val(res.executed_value);
            $('#association_share').val(res.association_share);
            $('#unit_amount_actual').val(res.unit_amount_actual);
            $('#unit_actual_price').val(res.unit_actual_price);
            $('#unit_value_actual').val(res.unit_value_actual);
        }

    });
};

function detailsModal(url){
    $.ajax({
        type: 'POST',
        url: '' +  url,
        data: '',
        cache: false,
        dataType: 'html',
        context: document.body,
        success: function (data) {
            res = JSON.parse(data);
            $('#project_id').val(res.project_id);
            $('#support_fk').val(res.support_fk);
            $('#measure_unit').val(res.measure_unit);
            $('#approved_support_amount').val(res.approved_support_amount);
            $('#unit_amount').val(res.unit_amount);
            $('#unit_price').val(res.unit_price);
            $('#unit_value').val(res.unit_value);
            $('#ps_id').val(res.ps_id);
            // Assuming res.target_data is an array of tag objects
            const newTags = res.target_data;

            // Update the global tags array
            tags = newTags;

            // Update the tag list display
            updateTags();
        }

    });
};

document.addEventListener('DOMContentLoaded', function() {
    const project_form = document.getElementById('project_form');

    // Get the form elements
    const receivedFromSponsorInput = project_form.elements['received_from_sponsor'];
    const approvedAmountInput = project_form.elements['approved_amount'];
    const exchange_valueInput = project_form.elements['exchange_value'];
    const approved_valueInput = project_form.elements['approved_value'];

    const remainFromSponsorInput = project_form.elements['remain_from_sponsor'];

    approved_valueInput.addEventListener('blur', function() {
        // Retrieve values and convert them to numbers
        const approved_value = parseFloat(approved_valueInput.value) || 0;
        const approvedAmount = parseFloat(approvedAmountInput.value) || 0;
        const exchange_value = parseFloat(exchange_valueInput.value) || 0;

        const amountValue = exchange_value * approved_value;
        remainFromSponsorInput.value = amountValue;
        approvedAmountInput.value = amountValue;

    });
    // Attach the blur event handler to the received_from_sponsor input
    receivedFromSponsorInput.addEventListener('blur', function() {
        // Retrieve values and convert them to numbers
        const receivedFromSponsor = parseFloat(receivedFromSponsorInput.value) || 0;
        const approvedAmount = parseFloat(approvedAmountInput.value) || 0;

        // Check if the received amount exceeds the approved amount
        if (receivedFromSponsor > approvedAmount) {
            // Show an error message using SweetAlert2
            Swal.fire({
                icon: "error",
                title: "قيمة خاطئة",
                text: "أدخل قيمة صحيحة أقل أو تساوي المتبقي",
            });
        } else {
            // Calculate the remaining amount and update the field
            const remainFromSponsor = approvedAmount - receivedFromSponsor;
            remainFromSponsorInput.value = remainFromSponsor;
        }
    });

    /**********************/
    const supportForm = document.getElementById('supportForm');
    const tagsDataInput = supportForm.elements['tags-data'];
   // var count = tagsDataInput.val().length;
    supportForm.addEventListener('submit', function(event) {

            if($('#support_fk').val()==0){
                Swal.fire({
                    icon: "error",
                    title: "خطأ",
                    text: "اختر نوع الدعم ",
                });
                event.preventDefault();
            }
        if($('#tags-data').val()==0){
            Swal.fire({
                icon: "error",
                title: "خطأ",
                text: "اختر الفئات المستهدفة ",
            });
            event.preventDefault();
        }
        if($('#measure_unit').val()==0){
            Swal.fire({
                icon: "error",
                title: "خطأ",
                text: "اختر الوحدة ",
            });
            event.preventDefault();
        }

    });

});

$(document).ready(function() {
    $('#approved_support_amount').on('blur', function() {
        var approved=$('#approved_support_amount').val();
        var approved_remainder=$('#approved_remainder').val();
        if(approved>approved_remainder)
        {
            Swal.fire({
                icon: "error",
                title:"قيمة خاطئة" ,
                text: "أدخل قيمة صحيحة أقل أو تساوي المتبقي     ",
            });
        }
    });


    $('#unit_price').on('blur', function() {
        var u_price = parseFloat($('#unit_price').val()) || 0; // Convert to number, default to 0 if NaN
        var unit_amount = parseFloat($('#unit_amount').val()) || 0; // Convert to number, default to 0 if NaN

        if (unit_amount) {
            console.log('u_price ' + u_price);
            console.log('unit_amount ' + unit_amount);
            $('#unit_value').val(u_price * unit_amount);
        } else {
            $('#unit_value').val(''); // Clear value if unit_amount is 0 or empty
        }
    });

    //unit_amount.addEventListener('input', function() {
    $('#unit_amount').on('blur', function() {
    var u_price=$('#unit_price').val();
    var u_amount=$('#unit_amount').val();
    if(u_price)
    $('#unit_value').val(u_price*u_amount);
});

    function unlockTab(psid) {
        const stagesTab = document.getElementById('stages_tab');
        const supportTab = document.getElementById('support_tab');
        stagesTab.classList.remove('disabled');
        stagesTab.setAttribute('data-toggle', 'tab');

        // Set the value of ps_id in stageForm
        $('#stageForm input[name="ps_fk"]').val(psid);

        // Use Bootstrap's tab('show') method to programmatically open the tab
        $(stagesTab).addClass('active-tab');
        $(supportTab).removeClass('active-tab');
        $('#support').removeClass('show');
        $('#stages').addClass('show');
        window.scrollTo(200, 200);
    }

    $('#ps_fk').on('blur', function () {
        var value = $(this).val();
        if (value === '0' || value === '') {
            $('#card_stage').addClass('hidden'); // Hide the card
        } else {
            $('#card_stage').removeClass('hidden'); // Show the card
        }
    });
});