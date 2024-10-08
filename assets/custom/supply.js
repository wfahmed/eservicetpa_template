function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deletetModal').modal();
}
function details_supply_Modal(url){
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
            $('#proj_supply_id').val(res.proj_supply_id);
            $('#supplier_fk').val(res.supplier_fk);
            $('#supplier_date').val(res.supplier_date);
            $('#supplier_invoice').val(res.supplier_invoice);
            $('#supplier_paid_amount').val(res.supplier_paid_amount);
            $('#receipt_no').val(res.receipt_no);
            $('#remaining_amount').val(res.remaining_amount);
            $('#notes').val(res.notes);
        }

    });
};

document.getElementById('supplyForm').addEventListener('submit', function(event) {
    // Get form values
    var selectElement = document.getElementById('supplier_fk');
    var sup_val = selectElement.value;  // Get the value of the selected option
    if (sup_val == "0") {  // Assuming 0 is the value for the "Please select" option
        Swal.fire({
            icon: "error",
            title: "خطأ",
            text: "اختر مورد ",
        });
        event.preventDefault(); // Stop form submission if validation fails
    }
});

$(document).ready(function() {

$('#supplier_paid_amount').on('input', function() {
    $('#remaining_amount').val($('#supplier_paid_amount').val());
});
});

