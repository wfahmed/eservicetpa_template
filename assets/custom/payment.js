function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deletetModal').modal();
}

function details_pay_Modal(url){
    $.ajax({
        type: 'POST',
        url: '' +  url,
        data: '',
        cache: false,
        dataType: 'html',
        context: document.body,
        success: function (data) {
            res = JSON.parse(data);
            $('#sp_id ').val(res.sp_id );
            $('#proj_fk').val(res.proj_fk);
            $('#ps_fk').val(res.ps_fk);
            $('#supplier_fk').val(res.supplier_fk);
            $('#support_fk').val(res.support_fk);
            $('#sp_supplier_date').val(res.sp_supplier_date);
            $('#supplier_invoice').val(res.supplier_invoice);
            $('#invoice_value').val(res.invoice_value);
            $('#receipt_no').val(res.receipt_no);
            $('#remaining_value').val(res.remaining_value);
            $('#notes').val(res.notes);
        }

    });
};
$('#invoice_value').on('input', function() { // Use 'input' to trigger on value change
    let invoice_value = parseFloat($('#invoice_value').val());
    let supplier_paid_amount = parseFloat($('#supplier_paid_amount').val());
    let paid_amount = parseFloat($('#paid_amount').val());
    let sumVal=invoice_value+paid_amount;
    $('#remaining_value').val(supplier_paid_amount-sumVal);
    if (invoice_value > supplier_paid_amount) {
        Swal.fire({
            icon: "error",
            title: "إدخال خاطيء",
            text: "قيمة الفاتورة أكبر من المبلغ المدفوع",
        });
    }
});
$(document).ready(function() {

});