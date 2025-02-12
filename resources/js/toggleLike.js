function toggleLike(postId) {
    let likeButton = $(`#like_button_${postId}`);
    let likeLabel = $(`#like_label_${postId}`);
    let likeCount = $(`#like-count-${postId}`);

    let liked = likeLabel.text().trim() === 'liked';
    let currentLikesCount = parseInt(likeCount.text().split(' ')[0]);


    if (liked) {
        likeButton.css('color', 'black');
        likeLabel.css('color', 'black').text('like');
        likeCount.text((currentLikesCount - 1) + ' likes');
    } else {
        likeButton.css('color', '#1a4f72');
        likeLabel.css('color', '#1a4f72').text('liked');
        likeCount.text((currentLikesCount + 1) + ' likes');
    }

    $.ajax({
        url: `/like/${postId}`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            if (response.liked) {
                likeButton.css('color', '#1a4f72');
                likeLabel.css('color', '#1a4f72').text('liked');
                likeCount.text(response.likes_count + ' likes');
            } else {
                likeButton.css('color', 'black');
                likeLabel.css('color', 'black').text('like');
                likeCount.text(response.likes_count + ' likes');
            }
        },
        error: function() {

            if (liked) {
                likeButton.css('color', '#1a4f72');
                likeLabel.css('color', '#1a4f72').text('liked');
                likeCount.text((currentLikesCount) + ' likes');
            } else {
                likeButton.css('color', 'black');
                likeLabel.css('color', 'black').text('like');
                likeCount.text((currentLikesCount) + ' likes');
            }
        }
    });
}
window.toggleLike = toggleLike;
