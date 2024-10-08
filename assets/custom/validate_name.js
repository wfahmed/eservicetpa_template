function validateName(testname) {
    var regex = /^[\u0621-\u064A\s]+$/; // Regex for Arabic letters and spaces

    if (!regex.test(testname)) {
        return false;
    } else {
        return true;
    }
}