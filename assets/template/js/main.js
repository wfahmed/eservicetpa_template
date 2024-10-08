$('#dataTable').DataTable({
    "paging": true,
    "searching": true
});
// sustom upload file
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
});
function expandPage(){
    var $content = $('#content');
    if ($content.css('width') === '100%') {
        $content.css({'width': '', 'height': ''});
    } else {
        $content.css({'width': '100%', 'height': '100vh'});
    }
}
// ajax role
$('.form-check-input').on('click', function() {
    const menuId = $(this).data('menu');
    const roleId = $(this).data('role');
    if(roleId) {
        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function () {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });
    }
});
$(document).ready(function() {
    $(function () {
        var date = new Date();
        date.setDate(date.getDate());
        // console.log('in datepicker'+date.getDate());
        $(".datepicker").datepicker({
            // startDate: date,
            format: 'dd-mm-YYYY',
            autoclose: true,
            todayHighlight: true,
        });
    });
});