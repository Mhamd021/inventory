function fetchComments(postId) {
    $.ajax({
        url: `/webposts/${postId}/comments`,
        method: 'GET',
        success: function(comments) {
            let commentsHtml = comments.length > 0 ? '' : '<p>No comments yet. Be the first to comment!</p>';
            comments.forEach(comment => {
                const userImage = comment.user.user_image ? comment.user.user_image : '/css/user.png';
                commentsHtml += `
                    <div class="comment">
                        <div class="comment-user">
                            <img src="${userImage}" alt="${comment.user.name}">
                            <span>${comment.user.name}</span>
                        </div>
                        <div class="comment-body">
                            ${comment.comment_info}
                        </div>
                        <hr>
                    </div>`;
            });
            document.querySelector('#CommentsModal .comments_section').innerHTML = commentsHtml;
            document.getElementById('post_id_input').value = postId;
            editModal('CommentsModal');
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch comments.');
        }
    });
}
window.fetchComments = fetchComments;
