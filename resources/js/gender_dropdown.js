function handleGenderDropdownChange() {
    var genderDropdown = document.getElementById('genderDropdown');
    if(genderDropdown)
        {
            var customGenderInput = document.getElementById('customGenderInput');
            if (genderDropdown.value === 'Other') {
                customGenderInput.style.display = 'block';
            } else {
                customGenderInput.value = genderDropdown.value;
                customGenderInput.style.display = 'none';
            }
        }

}
document.addEventListener('DOMContentLoaded', (event) => {
    handleGenderDropdownChange();
});
window.handleGenderDropdownChange = handleGenderDropdownChange;
