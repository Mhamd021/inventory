function updateImagePreview(inputElement, previewElementId) {
    const file = inputElement.files[0];
    const $previewElement = $('#' + previewElementId);
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $previewElement.attr('src', e.target.result);
            $previewElement.css('display', 'block');
        };
        reader.readAsDataURL(file);
    } else {
        $previewElement.css('display', 'none');
    }
}
$('#profileImageInput').on('change', function() {
    updateImagePreview(this, 'profileImagePreview');
});

$('#coverImageInput').on('change', function() {
    updateImagePreview(this, 'coverImagePreview');
});

$('#CreateProfileImage').on('change',function()
{
    updateImagePreview(this,'CreateImagePreview');
});
window.updateImagePreview = updateImagePreview;
