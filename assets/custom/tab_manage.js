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
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('show');
    });
});

document.getElementById('contactForm').addEventListener('submit', function(event) {
    // Get form values
    var contactValue = document.getElementById('contact_value').value;
    var selectElement = document.getElementById('contact_type');
    var contactType = document.getElementById('contact_type').options[selectElement.selectedIndex].text;

    // Perform validation based on contact type
    var isValid = validateContact(contactValue, contactType);
    msg='';
    if (!isValid) {
        switch(contactType) {
            case 'جوال':
                // Validate phone number (simple example for 10-15 digits)
                msg = '05998888632';
                break;
            case 'بريد':
                // Validate phone number (simple example for 10-15 digits)
                msg = 'a@a.com';
                break;
            case 'واتس':
                // Validate address (simple non-empty check, customize as needed)
                msg = '+9725998888632';
                break;
            default:
                return false; // Unknown type
        }
        event.preventDefault(); // Stop form submission if validation fails
        Swal.fire({
            icon: "error",
            title:"مثال" +'<pre>'+msg+'</pre>',
            text: "أدخل قيمة صحيحة لل!     "+ contactType,
        });
    }
});

function validateContact(value, type) {
    var regex;

    if (type === 'جوال') {
        // Validate phone number (simple example for 10-15 digits)
        regex = /\d{10}$/;
    } else if (type === 'بريد') {
        // Validate email address
        regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    } else if (type === 'واتس') {
        // Validate address (simple non-empty check, customize as needed)
        regex = /^\+?\d{10,15}$/;
    } else {
        return false; // Unknown type
    }

    return regex.test(value);
}

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
    $('#'+tabId+'_tab').click();
});

document.getElementById('dwelling_form').addEventListener('submit', function(event) {
    var form = event.target;

    // تحقق من كل الحقول المطلوبة
    var requiredFields = form.querySelectorAll('[required]');
    console.log(requiredFields);
    var isValid = true;

    requiredFields.forEach(function(field) {
        if (!field.value) {
            isValid = false;
            field.setCustomValidity('هذا الحقل مطلوب');
        } else {
            field.setCustomValidity(''); // إزالة الرسالة المخصصة عند ملء الحقل
        }
    });

    if (!isValid) {
        event.preventDefault(); // منع إرسال النموذج إذا كان هناك خطأ
        form.reportValidity(); // عرض رسائل الخطأ المخصصة
    }
});
