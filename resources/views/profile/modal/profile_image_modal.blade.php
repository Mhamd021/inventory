<div id="profileImageModal" class="modal">
    <div class="modal-content">
        <div class="close">
            <button type="button"
                onclick="closeModal('profileImageModal', 'profileImagePreview', '{{ asset($user->user_image ?? 'path/to/default/profile.png') }}')" aria-label="close the modal" title="close"></button>
        </div>
        <p>Choose your profile image</p>
        <br>
        <img id="profileImagePreview" src="{{ asset($user->user_image ?? 'path/to/default/profile.png') }}" class="image-preview" alt="Profile-image">
        <form id="profileImageForm" action="{{ route('profile.uploadImage') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="save_cancel">
                <button type="submit"><i class="fa fa-check"></i> Save</button>
                <input type="file" name="profile_image" id="profileImageInput" class="file-input" required>
                <label for="profileImageInput" class="file-label"><i class="fas fa-camera"></i> Choose a file</label>
                <button class="delete" type="button" onclick="removeImage({{ $user->id }},'profile')">
                    <i style="color: white" class="fas fa-times-circle"></i> delete</button>
            </div>
        </form>
    </div>
</div>
