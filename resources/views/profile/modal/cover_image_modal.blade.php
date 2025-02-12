<div id="coverImageModal" class="modal">
    <div class="modal-content">
        <div class="close">
            <button type="button"
                onclick="closeModal('coverImageModal', 'coverImagePreview', '{{ asset($user->cover_image ?? 'path/to/default/cover.png') }}')" aria-label="close the modal" title="close"></button>
        </div>

        <form id="coverImageForm" action="{{ route('profile.uploadCover') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="file" name="cover_image" id="coverImageInput" class="file-input" required>
        <label for="coverImageInput" class="file-label"> <i class="fas fa-camera"></i> Choose image </label>
        <img id="coverImagePreview" src="{{ asset($user->cover_image ?? 'path/to/default/cover.png') }}"
            class="image-preview" alt="Cover-image">

            <div class="save_cancel">
                <button type="submit" class="save"><i class="fa fa-check"></i> Save</button>
                <button class="delete" type="button" onclick="removeImage({{ $user->id }},'cover')">
                    <i style="color: white" class="fa fa-times-circle"></i> delete</button>
            </div>
        </form>
    </div>
</div>
