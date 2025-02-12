$(document).ready(function() {
    $('#CommentsForm').on('submit', function(event) {
        event.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');
        let formData = new FormData(this);
        $('#loading-spinner').show();
        $.ajax({
            url: url,
            type: method,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response)
             {
                let postId = $('#post_id_input').val();
                fetchComments(postId);
                $.ajax({
                    url: `/webposts/${postId}/comment-count`,
                    method: 'GET',
                    success: function(data) {
                        $(`#comment-count-${postId}`).text(`${data.count} comments`);
                    },
                    error: function(xhr, status, error) {
                        console.log('Failed to fetch comment count.');
                    }
                });
                form.trigger("reset");
                $('#loading-spinner').hide();
            },
            error: function(xhr, status, error) {
                alert('Failed to create comment.');
                $('#loading-spinner').hide();
            }
        });
    });
});

