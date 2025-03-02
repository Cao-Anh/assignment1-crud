
function validateRegister() {
    let isValid = true;

    // Username Validation
    let usernameElement = document.getElementById("username");
    let usernameErrorElement = document.getElementById("usernameError");
    if (usernameElement && usernameErrorElement) {
        let username = usernameElement.value;
        if (username.length < 3 || username.length > 8) {
            usernameErrorElement.textContent = "Username yêu cầu từ 3-8 ký tự, vui lòng nhập lại!";
            isValid = false;
        } else {
            usernameErrorElement.textContent = "";
        }
    }

    // Password Validation
    let passwordElement = document.getElementById("password");
    let passwordErrorElement = document.getElementById("passwordError");
    if (passwordElement && passwordErrorElement) {
        let password = passwordElement.value;
        let uppercaseRegex = /[A-Z]/;
        if (password.length < 5 || password.length > 9) {
            passwordErrorElement.textContent = "Mật khẩu phải từ 5-9 ký tự.";
            isValid = false;
        } else if (!uppercaseRegex.test(password)) {
            passwordErrorElement.textContent = "Mật khẩu phải chứa ít nhất 1 chữ cái in hoa (A-Z).";
            isValid = false;
        } else {
            passwordErrorElement.textContent = "";
        }
    }

    // Confirm Password Validation
    let confirmPasswordElement = document.getElementById("confirm_password");
    let confirmPasswordErrorElement = document.getElementById("confirmPasswordError");
    if (passwordElement && confirmPasswordElement && confirmPasswordErrorElement) {
        let password = passwordElement.value;
        let confirmPassword = confirmPasswordElement.value;
        if (password !== confirmPassword) {
            confirmPasswordErrorElement.textContent = "Mật khẩu nhập lại không khớp.";
            isValid = false;
        } else {
            confirmPasswordErrorElement.textContent = "";
        }
    }

    // Email Validation
    let emailElement = document.getElementById("email");
    let emailErrorElement = document.getElementById("emailError");
    if (emailElement && emailErrorElement) {
        let email = emailElement.value;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailErrorElement.textContent = "Email không hợp lệ, vui lòng nhập lại!";
            isValid = false;
        } else {
            emailErrorElement.textContent = "";
        }
    }
    return isValid;
}
function validateChangePassword() {
    let isValid = true;


   

    // Password Validation
    let passwordElement = document.getElementById("password");
    let passwordErrorElement = document.getElementById("passwordError");
    if (passwordElement && passwordErrorElement) {
        let password = passwordElement.value;
        let uppercaseRegex = /[A-Z]/;
        if (password.length < 5 || password.length > 9) {
            passwordErrorElement.textContent = "Mật khẩu phải từ 5-9 ký tự.";
            isValid = false;
        } else if (!uppercaseRegex.test(password)) {
            passwordErrorElement.textContent = "Mật khẩu phải chứa ít nhất 1 chữ cái in hoa (A-Z).";
            isValid = false;
        } else {
            passwordErrorElement.textContent = "";
        }
    }

    // Confirm Password Validation
    let confirmPasswordElement = document.getElementById("confirm_password");
    let confirmPasswordErrorElement = document.getElementById("confirmPasswordError");
    if (passwordElement && confirmPasswordElement && confirmPasswordErrorElement) {
        let password = passwordElement.value;
        let confirmPassword = confirmPasswordElement.value;
        if (password !== confirmPassword) {
            confirmPasswordErrorElement.textContent = "Mật khẩu nhập lại không khớp.";
            isValid = false;
        } else {
            confirmPasswordErrorElement.textContent = "";
        }
    }

    // Email Validation
    let emailElement = document.getElementById("email");
    let emailErrorElement = document.getElementById("emailError");
    if (emailElement && emailErrorElement) {
        let email = emailElement.value;
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            emailErrorElement.textContent = "Email không hợp lệ, vui lòng nhập lại!";
            isValid = false;
        } else {
            emailErrorElement.textContent = "";
        }
    }
    return isValid;
}
