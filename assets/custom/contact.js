function updateValidation(contactType, input) {
    // Remove all existing event listeners
    input.removeEventListener('keypress', keypressHandler);
    input.removeEventListener('paste', pasteHandler);
    input.removeEventListener('input', inputHandler);

    switch (parseInt(contactType)) {
        case 116: // Phone numbers
            input.setAttribute('type', 'tel');
            input.setAttribute('pattern', '[0-9]{10}');
            input.setAttribute('maxlength', '10');
            input.placeholder = "ادخل رقم الجوال من 10 خانات";
            input.addEventListener('keypress', keypressHandler);
            input.addEventListener('paste', pasteHandler);
            input.addEventListener('input', inputHandler);
            break;
        case 117: // WhatsApp
            input.setAttribute('type', 'tel');
            input.setAttribute('pattern', '(\\+970|\\+972)?[0-9]{9}');
            input.setAttribute('maxlength', '13');
            input.placeholder = "+970 او +972 ثم ادخل 9 خانات";
            input.addEventListener('keypress', whatsappKeypressHandler);
            input.addEventListener('paste', whatsappPasteHandler);
            input.addEventListener('input', whatsappInputHandler);
            break;
        case 118: // Email
            input.setAttribute('type', 'email');
            input.setAttribute('pattern', '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$');
            input.removeAttribute('maxlength');
            input.placeholder = "أدخل ايميل صحيح";
            break;
        default:
            input.removeAttribute('pattern');
            input.removeAttribute('maxlength');
            input.setAttribute('type', 'text');
            input.placeholder = "";
    }
}

function keypressHandler(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault();
    }
}

function pasteHandler(e) {
    e.preventDefault();
    var pastedText = (e.clipboardData || window.clipboardData).getData('text');
    if (pastedText.match(/^[0-9]+$/)) {
        this.value = pastedText.slice(0, 10); // Limit to 10 digits
    }
}

function inputHandler(e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 10); // Remove non-digits and limit to 10 digits
}

function whatsappKeypressHandler(e) {
    var charCode = (e.which) ? e.which : e.keyCode;
    if (charCode === 43) { // Allow + sign
        if (this.value.includes('+')) {
            e.preventDefault(); // Prevent multiple + signs
        }
    } else if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        e.preventDefault(); // Prevent non-digit characters
    }
}

function whatsappPasteHandler(e) {
    e.preventDefault();
    var pastedText = (e.clipboardData || window.clipboardData).getData('text');
    var cleaned = pastedText.replace(/[^\d+]/g, ''); // Remove all non-digit characters except +
    if (cleaned.startsWith('+970') || cleaned.startsWith('+972')) {
        this.value = cleaned.slice(0, 13); // +970 or +972 followed by 9 digits
    } else if (cleaned.startsWith('970') || cleaned.startsWith('972')) {
        this.value = '+' + cleaned.slice(0, 12); // Add + if missing, then country code and 9 digits
    } else {
        this.value = cleaned.slice(0, 9); // Just take the first 9 digits
    }
}

function whatsappInputHandler(e) {
    var cleaned = this.value.replace(/[^\d+]/g, ''); // Remove all non-digit characters except +
    if (cleaned.startsWith('+970') || cleaned.startsWith('+972')) {
        this.value = cleaned.slice(0, 13); // +970 or +972 followed by 9 digits
    } else if (cleaned.startsWith('970') || cleaned.startsWith('972')) {
        this.value = '+' + cleaned.slice(0, 12); // Add + if missing, then country code and 9 digits
    } else if (cleaned.startsWith('+')) {
        this.value = '+' + cleaned.slice(1, 13).replace(/^\+/, ''); // Ensure only one + at the start
    } else {
        this.value = cleaned.slice(0, 9); // Just take the first 9 digits
    }
}