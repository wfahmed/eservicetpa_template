function details_debts_Modal(id,title){
    url=base_url+'supplier/get_debts/'+id;
    $('#newDefModalLabel').text(' دفعات المورد ل '+title);
    $.ajax({
        type: 'POST',
        url: '' +  url,
        data: '',
        cache: false,
        dataType: 'html',
        context: document.body,
        success: function (data) {
            response = JSON.parse(data);
           //console.log(response);
            var modal = $("#newDefModal");
            var tableBody = document.querySelector('#dataTableDebts tbody');
            tableBody.innerHTML = ''; // Clear any existing rows
            let i=0;
            response.forEach(function(item) {
                var tr = document.createElement('tr');
                var tdIsp_supplier_date = document.createElement('td');
                tdIsp_supplier_date.textContent = item.sp_supplier_date;
                var tdsupplier_invoice = document.createElement('td');
                tdsupplier_invoice.textContent = item.supplier_invoice;
                var tdinvoice_value = document.createElement('td');
                tdinvoice_value.textContent = item.invoice_value;
                var tdreceipt_no = document.createElement('td');
                tdreceipt_no.textContent = item.eceipt_no;
                var tdnotes = document.createElement('td');
                tdnotes.textContent = item.notes;
                i=i+1;
                var i_index = i;
                var tdi_index = document.createElement('td');
                tdi_index.textContent = i_index;

                tr.appendChild(tdi_index);
                tr.appendChild(tdIsp_supplier_date);
                tr.appendChild(tdsupplier_invoice);
                tr.appendChild(tdinvoice_value);
                tr.appendChild(tdreceipt_no);
                tr.appendChild(tdnotes);
                tableBody.appendChild(tr);
            });
            modal.show();
        }

    });
};