function displayChangePasswordForm() {
    var passwordForm = document.getElementById('changePasswordForm');
    var emailForm = document.getElementById('changeEmailForm');

    if (emailForm.style.display === 'block') {
        emailForm.style.display = 'none';
    }

    if (passwordForm.style.display === 'none') {
        passwordForm.style.display = 'block';
    } else {
        passwordForm.style.display = 'none';
    }
}

function displayChangeEmailForm() {
    var passwordForm = document.getElementById('changePasswordForm');
    var emailForm = document.getElementById('changeEmailForm');

    if (passwordForm.style.display === 'block') {
        passwordForm.style.display = 'none';
    }

    if (emailForm.style.display === 'none') {
        emailForm.style.display = 'block';
    } else {
        emailForm.style.display = 'none';
    }
}


