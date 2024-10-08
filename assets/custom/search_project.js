function refresh_debts() {
    axios.get(base_url + 'search_project/refresh_debts', {
        params: {
            userId: 1
        }
    })
        .then(function (response) {
            console.log('Filtered data:', response.data);
        })
        .catch(function (error) {
            console.error('There was an error fetching the data:', error);
        });
}

$(document).ready(function() {
    var table = $('#search_projectDT').DataTable({
        "processing": true, // Enable the processing indicator
        "serverSide": true, // Enable server-side processing
        "ajax": {
            "url": base_url + 'search_project/view',
            "type":"post",
            "data": function(d) {
                d.support_id = $('#support_id').val();
                d.support_type_id = $('#support_type_id').val();
                d.supplier_id = $('#supplier_id').val();
            },
            "dataSrc": function(json) {
                console.log(json);
                if (json === null || json.length === 0) {
                    $('#search_projectDT').DataTable().clear().draw();
                    $('#noRecordsMessage').show(); // Show no records message
                    return [];
                } else {
                    $('#noRecordsMessage').hide(); // Hide no records message
                    var processedData = json.data.map(function(res) {

                        return {
                            "support_name": res.support_name,
                            "approved_date": res.approved_date,
                            "approved_value": res.approved_value,
                            "approved_amount": res.approved_amount,
                            "received_from_sponsor": res.received_from_sponsor,
                            "remain": res.approved_amount - res.received_from_sponsor,
                            "support_type_name": res.support_type_name + ' [' + res.unit_amount + ']',
                            "supplier_name": res.supplier_name,
                            "supplier_paid_amount": res.supplier_paid_amount,
                            "supplier_recieved_mony": res.supplier_recieved_mony,
                            "supplier_remain_mony": res.supplier_remain_mony,
                            "procedure": '<a class="badge badge-success" href="' + base_url + 'supplier/debts_supplier/' + res.supplier_id + '">مديونية</a>',
                        };
                });

                // Update the draw, recordsTotal, and recordsFiltered if needed
                json.draw = json.draw || 1; // Ensure draw is always defined
                json.recordsTotal = json.recordsTotal || processedData.length;
                json.recordsFiltered = json.recordsFiltered || processedData.length;

                return processedData;
            }
            }
        },
        "columns": [
            { "data": "support_name" },
            { "data": "approved_date" },
            { "data": "approved_value" },
            { "data": "approved_amount" },
            { "data": "received_from_sponsor" },
            { "data": "remain" },
            { "data": "support_type_name" },
            { "data": "supplier_name" },
            { "data": "supplier_paid_amount" },
            { "data": "supplier_recieved_mony" },
            { "data": "supplier_remain_mony" },
            { "data": "procedure" },
        ],
        "responsive": true,
        "paging": true,
        "ordering": true,
        "info": true,
        "searching": true,
        "lengthMenu": [10, 50, 75, 100, 300],
        "pageLength": 20
    });
// Trigger a refresh of the table data when the form is submitted
    $('#project_form_search').on('submit', function(e) {
        e.preventDefault();
        table.ajax.reload(null, false); // Reload data without resetting the paging
    });
    // Optionally, handle the message or UI changes here
    $('#noRecordsMessage').hide(); // Hide message initially

    // Automatically refresh table every 30 seconds
    setInterval(function() {
        table.ajax.reload();
    }, 30000); // 30000 milliseconds = 30 seconds
});

document.addEventListener('DOMContentLoaded', function() {
    const toggleCardBtn = document.getElementById('toggleCardBtn');
    const cardBody = document.querySelector('.card-body');
    const arrow = document.getElementById('arrow');

    // Initialize card state
    let isMinimized = false;

    // Toggle minimize/maximize
    toggleCardBtn.addEventListener('click', function() {
        if (isMinimized) {
            cardBody.classList.remove('minimized');
            arrow.classList.remove('up');
            arrow.innerHTML = '&#9660;'; // Down arrow
        } else {
            cardBody.classList.add('minimized');
            arrow.classList.add('up');
            arrow.innerHTML = '&#9650;'; // Up arrow
        }
        isMinimized = !isMinimized;
    });

});
