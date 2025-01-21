<div id="deleteAccountModal" class="modal">
    <div class="modal-personal-contact">
        <div class="close">
            <button type="button" onclick="closeModal('deleteAccountModal')" aria-label="close the modal"
                title="close"></button>
        </div>
        <center>
            <h2>Enter Your Password To Complete The Delete</h2>
        </center><br>
        <form id="deleteAccountForm" action="{{ route('profile.destroy') }}" method="POST"
            enctype="multipart/form-data" >
            @method('DELETE')
            @csrf
            <input  title="type in your current password" placeholder="current password"
                type="text" name="deletePassword" style="-webkit-text-security: disc;" required>
            <div class="save_cancel">
                <button type="submit" class="delete">Delete</button>
                <button class="cancel" type="button" onclick="closeModal('deleteAccountModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

