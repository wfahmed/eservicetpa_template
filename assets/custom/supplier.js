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

document.getElementById('supply_form').addEventListener('submit', function(event) {
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

function isValidJawalNumber(phone) {
    // Remove all non-numeric characters
    phone = phone.replace(/\D/g, '');

    // Define the regular expression pattern for Saudi Jawal numbers
    const jawalPattern = /^(05\d{8}|9665\d{8})$/;

    // Test the phone number against the pattern
    return jawalPattern.test(phone);
}
$(document).ready(function() {
    $('#contact_phone').on('click', function() {
        contactValue=$('#contact_phone').val();
       res= isValidJawalNumber(contactValue)
       if(!res){
           Swal.fire({
               icon: "error",
               title:"جوال خاطيء",
           });
       }
    });

    $('#contact_email').on('input', function() {
        var contactType='بريد';
        contactValue=$('#contact_email').val();
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

});