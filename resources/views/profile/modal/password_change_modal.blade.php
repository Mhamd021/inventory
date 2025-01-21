<div id="passwordChangeModal" class="modal">
    <div class="modal-personal-contact">
        <div class="close">
            <button type="button" onclick="closeModal('passwordChangeModal')" aria-label="close the modal"
                title="close"></button>
        </div>
        <center>
            <h2>Change Your Password</h2>
        </center><br>
        <form id="PasswordChangeForm" action="{{ route('profile.changePassword') }}" method="POST"
            enctype="multipart/form-data" onsubmit="return validateForm()">
            @method('PUT')
            @csrf
            <label class="motion">Current Password</label>
            <input id="current_password" title="type in your current password" placeholder="current password"
                type="text" name="current_password" style="-webkit-text-security: disc;">
            <label class="motion">New Password</label>
            <input id="password" title="type in new password" placeholder="new password" type="text"
                name="password" style="-webkit-text-security: disc;">
            <label class="motion">Password Confirmation</label>
            <input id="password_confirmation" title="confirm password" placeholder="Confirm new password"
                type="text" name="password_confirmation" style="-webkit-text-security: disc;">
            <div id="error_message" class="error" style="display: none;"></div>
            <div class="save_cancel">
                <button type="submit" class="save">Save</button>
                <button class="cancel" type="button" onclick="closeModal('passwordChangeModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

