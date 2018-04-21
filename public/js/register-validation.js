var usernameField = document.getElementById('username');
var emailField = document.getElementById('email');
var passwordField = document.getElementById('password');
var confirmPasswordField = document.getElementById('confirm_password');

function validateRegisterInput()
{
    var validationErrors = {};
    console.log(validationErrors);
    
    // VALIDATE FIELDS ARE NOT EMPTY
    if (usernameField.value === '') {        
        validationErrors.username_empty = 'Username cannot be empty.';
        
        document.getElementById('username-error-span').textContent = validationErrors.username_empty;
        document.getElementById('username-error-span').style.display = 'block';
        
        document.getElementById('username').style.border = '1px solid #dc3545';
    } else {
        document.getElementById('username-error-span').textContent = '';
        document.getElementById('username-error-span').style.display = 'none';
        
        document.getElementById('username').style.border = '1px solid #ced4da';
    }
    
    if (emailField.value === '') {        
        validationErrors.email_empty = 'Email cannot be empty.';
        
        document.getElementById('email-error-span').textContent = validationErrors.email_empty;
        document.getElementById('email-error-span').style.display = 'block';
        
        document.getElementById('email').style.border = '1px solid #dc3545';
    } else {
        document.getElementById('email-error-span').textContent = '';
        document.getElementById('email-error-span').style.display = 'none';
        
        document.getElementById('email').style.border = '1px solid #ced4da';
    }
    
    if (passwordField.value === '') {
        validationErrors.password_empty = 'Password cannot be empty.';
        
        document.getElementById('password-error-span').textContent = validationErrors.password_empty;
        document.getElementById('password-error-span').style.display = 'block';
        
        document.getElementById('password').style.border = '1px solid #dc3545';
    } else {
        document.getElementById('password-error-span').textContent = '';
        document.getElementById('password-error-span').style.display = 'none';
        
        document.getElementById('password').style.border = '1px solid #ced4da';
    }
    
    if (confirmPasswordField.value === '') {
        validationErrors.confirm_password_empty = 'Please confirm your password.';
        
        document.getElementById('confirm-password-error-span').textContent = validationErrors.confirm_password_empty;
        document.getElementById('confirm-password-error-span').style.display = 'block';
        
        document.getElementById('confirm_password').style.border = '1px solid #dc3545';
    } else {
        document.getElementById('confirm-password-error-span').textContent = '';
        document.getElementById('confirm-password-error-span').style.display = 'none';
        
        document.getElementById('confirm_password').style.border = '1px solid #ced4da';
    }
    
    // VALIDATE EMAIL FORMAT
    if (emailField.value !== '' && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailField.value))
    {
        validationErrors.email_invalid_format = 'Please enter a valid email.';
        
        document.getElementById('email-error-span').textContent = validationErrors.email_invalid_format;
        document.getElementById('email-error-span').style.display = 'block';
        
        document.getElementById('email').style.border = '1px solid #dc3545';
    } 

    // VALIDATE PASSWORD MATCHES CONFIRM PASSWORD
    if 
    (
        passwordField.value !== '' &&
        confirmPasswordField.value !== '' &&
        passwordField.value !== confirmPasswordField.value
    ) 
    {
        validationErrors.password_mismatch = 
            'Passwords don\'t match, please verify you entered the correct password.';
        
        document.getElementById('password-error-span').textContent = validationErrors.password_mismatch;
        document.getElementById('password-error-span').style.display = 'block';
        
        document.getElementById('password').style.border = '1px solid #dc3545';
        
        document.getElementById('confirm-password-error-span').textContent = validationErrors.password_mismatch;
        document.getElementById('confirm-password-error-span').style.display = 'block';
        
        document.getElementById('confirm_password').style.border = '1px solid #dc3545';
    }
    
    console.log(validationErrors);
    
    if (Object.keys(validationErrors).length === 0) {
        return true;    
    } else {
        return false;
    }
}