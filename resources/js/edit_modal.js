function editModal(modalId) {
    let modal = $('#' + modalId);
    modal.css('display', 'flex').removeClass('fade-out').addClass('fade-in');
}

function closeModal(modalId, previewElementId, originalImageSrc) {

    let modal = $('#' + modalId);
    modal.removeClass('fade-in').addClass('fade-out');
    setTimeout(function() {
        modal.css('display', 'none').removeClass('fade-out');
    }, 300);

    const $previewElement = $('#' + previewElementId);
    $previewElement.attr('src', originalImageSrc);
    $previewElement.css('display', originalImageSrc ? 'block' : 'none');
    clearErrorMessages();

}

function validateForm() {
    var currentPassword = document.getElementById('current_password').value;
    var newPassword = document.getElementById('password').value;
    var confirmPassword = document.getElementById('password_confirmation').value;
    var errorMessage = '';

    if (!currentPassword) {
        errorMessage += 'Current password is required.<br>';
    }
    if (!newPassword) {
        errorMessage += 'New password is required.<br>';
    } else if (newPassword.length < 8) {
        errorMessage += 'New password must be at least 8 characters long.<br>';
    }
    if (newPassword !== confirmPassword) {
        errorMessage += 'Password confirmation does not match.<br>';
    }

    if (errorMessage) {
        var errorDiv = document.getElementById('error_message');
        errorDiv.innerHTML = errorMessage;
        errorDiv.style.display = 'block';
        return false;
    }

    return true;
}

function clearErrorMessages() {
    var errorDiv = document.getElementById('error_message');
    if (errorDiv) {
        errorDiv.innerHTML = '';
        errorDiv.style.display = 'none';
    }

    var currentPasswordInput = document.getElementById('current_password');
    if (currentPasswordInput) {
        currentPasswordInput.value = '';
    }

    var passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.value = '';
    }

    var passwordConfirmationInput = document.getElementById('password_confirmation');
    if (passwordConfirmationInput) {
        passwordConfirmationInput.value = '';
    }
}
window.editModal = editModal;
window.closeModal = closeModal;
window.validateForm = validateForm;
