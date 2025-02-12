@extends('layouts.app')
@section('content')
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <form action="{{ route('webPosts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="posts_body">
            <div class="whatsOnYourMind">

                <input name="post_info" class="text" type="text" placeholder="whats on your mind?..." required>
                <input id="create_post" type="file" style="display: none;">
                <div class="count">
                    <label for="create_post"><i class="far fa-image"></i></label>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </form>
    @foreach ($posts as $post)
        <div class="posts_body">
            <div class="post_card">
                <div class="user_image_name">
                    <img src="{{ $post->user->user_image ? $post->user->user_image : asset('/css/user.png') }}" alt="{{ $post->user->name }}">

                    <div class="date">
                        <a style="color: black" href="{{ route('profile.show', $post->user) }}"><label
                                for="">{{ $post->user->name }}</label></a>
                        <p>{{ $post->created_at }}</p>
                    </div>
                </div>
                <label class="info" for="">{{ $post->post_info }}</label>
                @if ($post->post_image != null)
                    <img class="post_image" src="{{ $post->post_image }}" alt="post_image">
                @endif
                <hr>
                <div class="count">
                    <div class="likes">
                        <i class="far fa-thumbs-up" style="color: #1a4f72"></i>

                        <label id="like-count-{{ $post->id }}">{{ $post->likes_count }} likes</label>
                    </div>
                    <div class="comments">

                        <label id="comment-count-{{ $post->id }}" for="">{{ $post->comments_count }}
                            comments</label>
                        <i class="far fa-message"></i>
                    </div>
                </div>
                <hr>

                <div class="functions">

                        <div class="like">
                            @if (auth()->user()->hasLiked($post->id))
                                <i id="like_button_{{ $post->id }}" class="far fa-thumbs-up" style="color: #1a4f72"
                                    onclick="toggleLike({{ $post->id }})"></i>
                                <label id="like_label_{{ $post->id }}" for="" style="color: #1a4f72"
                                    onclick="toggleLike({{ $post->id }})">liked</label>
                            @else
                                <i id="like_button_{{ $post->id }}" class="far fa-thumbs-up"
                                    onclick="toggleLike({{ $post->id }})"></i>
                                <label id="like_label_{{ $post->id }}" for=""
                                    onclick="toggleLike({{ $post->id }})">like</label>
                            @endif
                        </div>


                    <div class="comment">
                        <i class="far fa-message" onclick="fetchComments({{ $post->id }})"></i>
                        <label for="">comment</label>
                    </div>
                    <div class="share">
                        <i class="fas fa-share"></i>
                        <label for="">share</label>
                    </div>

                </div>

            </div>
        </div>
    @endforeach
    @include('posts.modal.CommentsModal')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
