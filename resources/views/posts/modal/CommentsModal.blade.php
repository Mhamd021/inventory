<div id="CommentsModal" class="modal">
    <div class="Comments-content">
        <div class="close">
            <button type="button"
                onclick="closeModal('CommentsModal')" aria-label="close the modal" title="close"></button>
        </div>
        <div class="comments_section">

        </div>
        <hr>
        <div class="sticky-footer">
            <form id="CommentsForm" action="{{ route('webComments.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="create_comment">
                    <div class="">
                        <input type="hidden" id="post_id_input" name="post_id">
                    <input type="text" placeholder="comment" title="write your comment" name="comment_info" required>
                    <button type="submit" style="padding: 10px;"><i class="fas fa-paper-plane"></i></button>
                    </div>

                </div>
            </form>
        </div>

    </div>
    <div id="loading-spinner" style="display: none;">
        <div class="spinner"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
