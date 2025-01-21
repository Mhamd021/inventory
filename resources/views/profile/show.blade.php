@extends('layouts.app')
@section('content')
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    @if ($user->cover_image != null)
        <link rel="preload" href="{{ asset($user->cover_image) }}" as="image">
    @else
        <link rel="preload" href="{{ asset('j5.jpg') }}" as="image">
    @endif
    <div class="profile_header">
        <div class="cover">
            @if ($user->cover_image != null)
                <img src="{{ asset($user->cover_image) }}" alt="Cover Photo" class="cover-image">
            @else
                <img src="{{ asset('j5.jpg') }}" alt="Choose Cover Image" class="cover-image">
            @endif
        </div>
        <div class="user_information">
            <div class="name_image">
                @if ($user->user_image != null)
                    <img id="p_image" src="{{ asset($user->user_image) }}" alt="Profile Image" class="profile-image">
                @else
                    <img id="p_image" src="{{ asset('css/user.png') }}" alt=" Choose Profile Image" class="profile-image">
                @endif
                <div class="name">
                    <h3 class="uppercase">{{ $user->name }}</h3>
                    @if ($friends != null)
                        <h4>{{ $friends }} friends</h4>
                    @endif
                    @if ($user->bio !=null)
                    <label for="">{{$user->bio}}</label>
                    @endif
                </div>
            </div>
          
        </div>
    </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
