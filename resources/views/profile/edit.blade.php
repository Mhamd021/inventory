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
            <div class="edit_cover" onclick="editModal('coverImageModal')">
                <i class="fas fa-camera"></i>
            </div>
        </div>
        <div class="user_information">
            <div class="name_image">
                @if ($user->user_image != null)
                    <img id="p_image" src="{{ asset($user->user_image) }}" alt="Profile Image" class="profile-image">
                @else
                    <img id="p_image" src="{{ asset('css/user.png') }}" alt=" Choose Profile Image" class="profile-image">
                @endif
                <div class="edit_button" onclick="editModal('profileImageModal')">
                    <i class="fas fa-camera"></i>
                </div>
                <div class="name">
                    <h3 class="uppercase">{{ $user->name }}</h3>
                    @if ($friends != null)
                        <h4>{{ $friends }} friends</h4>
                    @endif

                </div>
            </div>
            <div class="">
                <button class="edit_personal" onclick="editModal('personalInformationModal')">Edit Personal Informatoin <i
                        class="fas fa-edit"></i></button>
                <button class="edit_personal" style="background-color: #3c8eb4c3"
                    onclick="editModal('passwordChangeModal')">Edit Password <i class="fas fa-lock"></i></button>
                    <button class="edit_personal" style="background-color: rgb(208, 61, 103)"
                    onclick="editModal('deleteAccountModal')">Delete Account <i class="fas fa-times-circle"></i></button>
            </div>
            <div class="empty"></div>
        </div>
    </div>
        @if ($errors->has('current_password'))
        <div id="ShowingMessagesModal" class="message_modal" >
            <div class="message-modal-content" >
                <div class="close">
                    <button type="button"
                        onclick="closeModal('ShowingMessagesModal')" aria-label="close the modal" title="close" ></button>
                </div>
                <div class="space">
                    <label style="font-size: 40px">Error</label>
                    <i class="fas fa-warning" style="size: 40px; color:yellow"></i>
                </div>
                <div class="label"><label style="font-weight:bold" for="error">{{ $errors->first('current_password') }}!</label> <label>please try again or <a style="color: yellow">resset</a> your password</label></div>
                <div class="save_cancel">
                    <button class="cancel"  style="background-color: transparent"    onclick="editModal('passwordChangeModal'); closeModal('ShowingMessagesModal')">try again</button>
                    <button class="delete"  style="background-color: transparent"   onclick="editModal('passwordChangeModal'); closeModal('ShowingMessagesModal')">cancel</button>

                </div>
            </div>
        </div>
    @endif
    @if ($errors->has('deleteError'))
    <div id="ShowingMessagesModal" class="message_modal" >
        <div class="message-modal-content">
            <div class="close">
                <button type="button"
                    onclick="closeModal('ShowingMessagesModal')" aria-label="close the modal" title="close" ></button>
            </div>
            <div class="space">
                <label style="font-size: 40px">Error</label>
                <i class="fas fa-warning" style="size: 40px; color:yellow"></i>
            </div>
            <div class="label"><label style=" font-weight:bold" for="error">{{ $errors->first('deleteError') }}!</label> <label>please try again or <a style="color: yellow">resset</a> your password</label></div>
            <div class="save_cancel">
                <button class="cancel" style="background-color: transparent"   onclick="editModal('deleteAccountModal'); closeModal('ShowingMessagesModal')">try again</button>
                <button class="delete" style="background-color: transparent"  onclick="editModal('passwordChangeModal'); closeModal('ShowingMessagesModal')">cancel</button>
            </div>

        </div>
    </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        @include('profile.modal.delete_account_modal')
        @include('profile.modal.cover_image_modal')
        @include('profile.modal.profile_image_modal')
        @include('profile.modal.password_change_modal')
        @include('profile.modal.personal_information_modal')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection




