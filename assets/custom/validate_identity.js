function validatePalestinianID(identityCode) {
    // Ensure the input is exactly 9 digits
    if (!/^\d{9}$/.test(identityCode)) {
        return false;
    }

    let id = identityCode;
    if (id.length !== 9 || isNaN(id)) {
        return false;
    }

    // Last digit of the ID
    const lastDigit = id % 10;

    // Initialize variables for calculations
    let j1 = 1; // division
    let j2 = 10; // modulus
    let arr = [];
    let reversedArr = [];

    // Process the first 8 digits
    for (let i = 0; i < 8; i++) {
        j1 *= 10;
        j2 *= 10;

        const t1 = id % j2;
        const t2 = Math.floor(t1 / j1);
        arr[i] = t2;
    }

    // Reverse the array of digits
    for (let i = 0, j = 7; i < 8; i++, j--) {
        reversedArr[j] = arr[i];
    }

    // Multiply and adjust digits based on position
    let odd = 1;
    for (let i = 0; i < 8; i++) {
        if (odd === 1) {
            reversedArr[i] *= 1;
            odd = 2;
        } else {
            reversedArr[i] *= 2;
            odd = 1;
        }

        // If the result is greater than 9, sum the digits
        if (reversedArr[i] > 9) {
            const temp = reversedArr[i].toString().split("");
            reversedArr[i] = Number(temp[0]) + Number(temp[1]);
        }
    }

    // Sum all the transformed digits
    let sum = 0;
    for (let i = 0; i < 8; i++) {
        sum += reversedArr[i];
    }

    // Calculate the valid check digit
    const validDigit = (10 - sum.toString().split("").pop()) % 10;

    // Check if the last digit matches the calculated valid digit
    return lastDigit === validDigit;
}





