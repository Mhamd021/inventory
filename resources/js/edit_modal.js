function editModal(modalId) {
    $('#' + modalId).css('display', 'flex');
}

function closeModal(modalId, previewElementId, originalImageSrc) {

    $('#' + modalId).css('display', 'none');
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
    errorDiv.innerHTML = '';
    errorDiv.style.display = 'none';
    document.getElementById('current_password').value = '';
    document.getElementById('password').value = '';
    document.getElementById('password_confirmation').value = '';
}
window.editModal = editModal;
window.closeModal = closeModal;
window.validateForm = validateForm;
