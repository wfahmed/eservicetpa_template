function getUrlSegment(index) {
    var path = window.location.pathname;
    var segments = path.replace(/^\/|\/$/g, '').split('/');
    return segments[index] || null;
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded and parsed'); // Check if script is loaded

    // Helper function to get URL segment

    // Get tab ID from the URL (4th segment)
    var tabId = getUrlSegment(4);

    // Set the default tab or the tab based on URL
    if (tabId) {
        activateTab('t' + tabId + '_tab'); // Activate tab dynamically based on URL segment
    } else {
        activateTab('t1_tab'); // Default tab if no tabId is found
    }

    // Function to activate a tab by its ID
    function activateTab(tabId) {
        // Deactivate all tabs
        document.querySelectorAll('.tab-links div').forEach(tab => {
            tab.classList.remove('active-tab');
        });

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('show');
        });

        // Find and activate the tab
        const activeTab = document.getElementById(tabId);
        if (activeTab) {
            activeTab.classList.add('active-tab'); // Activate the clicked tab

            // Show the corresponding tab content
            const tabContentId = 'tab' + activeTab.getAttribute('data-tab');
            document.getElementById(tabContentId).classList.add('show');
        } else {
            console.error('Tab with ID "' + tabId + '" not found.');
        }
    }

    // Add event listeners to all tab links
    document.querySelectorAll('.tab-links div').forEach(tab => {
        tab.addEventListener('click', function() {
            activateTab(this.id); // Pass the clicked tab's ID to activate it
        });
    });
});



/*
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


document.addEventListener('DOMContentLoaded', function () {

    var tabId = getUrlSegment(4);

    if (tabId) {
        $('#t'+tabId+'_tab').click(); // Click the tab dynamically
    } else {
        $('#t1_tab').click(); // Default tab if no tabId is found
    }
});


*/