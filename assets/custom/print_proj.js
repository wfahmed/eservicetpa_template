document.addEventListener('DOMContentLoaded', function() {
    const toggleCardBtn = document.getElementById('toggleCardBtn');
    const toggleSupportCardBtn = document.getElementById('toggleSupportCardBtn');
    const toggleStageCardBtn = document.getElementById('toggleStageCardBtn');
    const toggleSupplierCardBtn = document.getElementById('toggleSupplierCardBtn');


    // Initialize card state
    let isMinimized = false;

    // Toggle minimize/maximize
    toggleCardBtn.addEventListener('click', function() {
        var $cardBody = document.querySelector('.card-body');
        var $arrow = document.getElementById('arrow');
        if (isMinimized) {
            $cardBody.classList.remove('minimized');
            $arrow.classList.remove('up');
            $arrow.innerHTML = '&#9660;'; // Down arrow
        } else {
            $cardBody.classList.add('minimized');
            $arrow.classList.add('up');
            $arrow.innerHTML = '&#9650;'; // Up arrow
        }
        isMinimized = !isMinimized;
    });

    toggleSupportCardBtn.addEventListener('click', function() {
        var Minimized =  $('#collapseBody').hasClass('minimized');
        if (Minimized) {
            $('#collapseBody').removeClass('minimized');
            $('#Supportarrow').removeClass('up');
            $('#Supportarrow').html('&#9660'); // Down arrow
        } else {
            $('#collapseBody').addClass('minimized');
            $('#Supportarrow').addClass('up');
            $('#Supportarrow').html('&#9650'); // Up arrow
        }
    });

    toggleStageCardBtn.addEventListener('click', function() {
        var Minimized = $('#collapseStageBody').hasClass('minimized');
        if (Minimized) {
            $('#collapseStageBody').removeClass('minimized');
            $('#Stagearrow').removeClass('up');
            $('#Stagearrow').html('&#9660'); // Down arrow
        } else {
            $('#collapseStageBody').addClass('minimized');
            $('#Stagearrow').addClass('up');
            $('#Stagearrow').html('&#9650'); // Up arrow
        }
    });

    toggleSupplierCardBtn.addEventListener('click', function() {
        var MinimizedStage = $('#collapseSupplierBody').hasClass('minimized');
        if (MinimizedStage) {
            $('#collapseSupplierBody').removeClass('minimized');
            $('#Supplierarrow').removeClass('up');
            $('#Supplierarrow').html('&#9660'); // Down arrow
        } else {
            $('#collapseSupplierBody').addClass('minimized');
            $('#Supplierarrow').addClass('up');
            $('#Supplierarrow').html('&#9650'); // Up arrow
        }
    });

});