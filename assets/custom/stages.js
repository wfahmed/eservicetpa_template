function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deletetModal').modal();
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


document.addEventListener('DOMContentLoaded', function() {
    const stageForm = document.getElementById('stageForm');

    // Get the form elements
    const executed_valueInput = stageForm.elements['executed_value'];
    const total_executedInput = stageForm.elements['total_executed'];
    const association_sharedInput = stageForm.elements['association_share'];

    executed_valueInput.addEventListener('blur', function() {
        // Retrieve values and convert them to numbers
        const executed_value = parseFloat(executed_valueInput.value) || 0;
        const total_executed = parseFloat(total_executedInput.value) || 0;
        const ex_value = total_executed-executed_value

        association_sharedInput.value = ex_value;
    });
});

$(document).ready(function() {
const unit_amount_actual = document.getElementById('unit_amount_actual');
const unit_actual_price = document.getElementById('unit_actual_price');
$('#unit_amount_actual').on('input', function () {
    var u_price=$('#unit_actual_price').val();
    var unit_amount=$('#unit_amount_actual').val();
    let executed_value = parseFloat($('#executed_value').val()) || 0;
    let res = parseFloat($('#res').val()) || 0;
    if(res){
        res=u_price*unit_amount;
        $('#unit_value_actual').val(res);
        if(res>executed_value){
            Swal.fire({
                icon: "error",
                title: "قيمة خاطئة",
                text: "أدخل قيمة صحيحة أقل أو تساوي المنفذ فعلياً",
            });
        }
    }
});

$('#unit_actual_price').on('input', function () {
//unit_actual_price.addEventListener('input', function() {
    var u_price=$('#unit_actual_price').val();
    var unit_amount=$('#unit_amount_actual').val();
    let executed_value = parseFloat($('#executed_value').val()) || 0;
    let res = parseFloat($('#res').val()) || 0;
    if(unit_amount){
        res=u_price*unit_amount;
        $('#unit_value_actual').val(res);
        if(res>executed_value){
            Swal.fire({
                icon: "error",
                title: "قيمة خاطئة",
                text: "أدخل قيمة صحيحة أقل أو تساوي المنفذ فعلياً",
            });
        }
    }
});

$('#ps_fk').on('input', function () {
    var value = $(this).val();
    if (value === '0' || value === '') {
        $('#card_stage').addClass('hidden'); // Hide the card
    } else {
        $('#card_stage').removeClass('hidden'); // Show the card
    }
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
});