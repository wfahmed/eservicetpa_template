function deleteConfirm(url){
    $('#btn-delete').attr('href', url);
    $('#deleteContactModal').modal();
}
$(document).ready(function() {
    $('#search_query, searchForm').off('blur').on('blur', function() {
        var searchQuery = $('#search_query').val();
        var child_user_id = $('#child_id').val();
        $.ajax({
            url: base_url+'agent/search_query', // Replace with your URL
            type: 'POST',
            dataType: 'json',
            data: {
                search_query: searchQuery ,
                child_user_id:child_user_id},
        success: function(response) {
            if(response.status==1) {
                $('#fname, searchForm').val(response.response.fname);
                $('#sname, searchForm').val(response.response.sname);
                $('#tname, searchForm').val(response.response.tname);
                $('#lname, searchForm').val(response.response.lname);
                $('#user_id, searchForm').val(response.response.id);
            }else{
                $('#fname, searchForm').val('');
                $('#sname, searchForm').val('');
                $('#tname, searchForm').val('');
                $('#lname, searchForm').val('');
                $('#user_id, searchForm').val(0);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
    });
});
