document.querySelectorAll('.tab-links div').forEach(tab => {
    tab.addEventListener('click', function() {
        // Ensure only one tab is active at a time
        document.querySelectorAll('.tab-links div').forEach(tabLink => {
            tabLink.classList.remove('active-tab');
        });

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('show');
        });

        // Add active class to the clicked tab
        this.classList.add('active-tab');

        // Show the corresponding tab content
        const tabId = 'tab'+this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('show');
    });
});

function getUrlSegment(index) {
    // Get the full URL path
    var path = window.location.pathname;

    // Remove leading and trailing slashes and split the path into segments
    var segments = path.replace(/^\/|\/$/g, '').split('/');

    // Return the segment at the specified index
    return segments[index] || null; // Returns null if index is out of range
}

document.addEventListener('DOMContentLoaded', function () {
    var tabId = getUrlSegment(4);

    if (tabId) {
        $('#t'+tabId+'_tab').click(); // Click the tab dynamically
    } else {
        $('#t1_tab').click(); // Default tab if no tabId is found
        $('#death_reason').select2({
            placeholder: 'Select an option',
            allowClear: true
        });
    }


});

