@extends('layouts.app')
@section('content')
@vite(['resources/js/app.js', 'resources/css/app.css'])

<form action="{{route('webPosts.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="create">
        <input type="file" name="post_image" id="CreateProfileImage" style="display: none;">
        <label  class="image-lable" for="CreateProfileImage">choose your image</label>
    <input class="form-input" type="text" name="post_info" required>
    <img class="post_image-preview "  id="CreateImagePreview" src="" alt="profile image" style="display: none;">
    <div class="save_cancel">
        <button class="save" type="submit">create</button>
        <a href="{{route('dashboard')}}"><button type="button" class="cancel">cancel </button></a>
    </div>
    </div>
</form>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
