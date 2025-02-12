<!DOCTYPE html>
<html lang="en">

<head>
    <title>Journeys</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/applayout.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    @php
        $notifications = Auth::user()->notifications;
        $unreadNotifications = Auth::user()->unreadNotifications;
@endphp
    <div class="navbar">
        <div class="left">
            <a class="open-sidebar">☰</a>
            <a title="dashboard" aria-label="this is dashboard link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
            @if (Auth::check() && Auth::user()->is_admin === 1)
                <div class="dropdown" onclick="toggleDropdown(this)">
                    <a aria-label="this is Journeys drop list " href="javascript:void(0)" class="dropbtn">Journeys</a>
                    <div class="dropdown-content dropdown-content-left">
                        <a aria-label="this is Journeys Create page link" href="{{ route('journey.create') }}">Create </a>
                        <a aria-label="this is all Journeys page link" href="{{ route('journey.index')}}">Journeys </a>
                        <a aria-label="this is all Trashed Journeys page link" href="{{ route('journey.trash')}}">Trashed </a>
                    </div>
                </div>
                <a href="{{ route('profile.index') }}">Users</a>
            @endif
            <div class="dropdown" onclick="toggleDropdown(this)">
                <a aria-label="this is Journeys drop list " href="javascript:void(0)" class="dropbtn">Posts</a>
                <div class="dropdown-content dropdown-content-left">
                    <a href="{{route('webPosts.create')}}">Create</a>
                    <a aria-label="this is all Journeys page link" href="{{ route('webPosts.index')}}">My Posts </a>
                    <a aria-label="this is all Journeys page link" href="{{ route('webPosts.index')}}">Feeds </a>
                </div>
            </div>
            <a href="{{route('profile.index')}}">users</a>
        </div>
        <div class="right">
            <a href=""><i class="fa fa-user-friends"></i></a>
            @if (auth()->check())
            <div class="dropdown notifications-dropdown" onclick="toggleDropdown(this)">
                <a aria-label="this is user notifications drop list" href="javascript:void(0)" class="dropbtn">
                    <i class="fas fa-bell"></i>
                    @if ($unreadNotifications->count() != 0)
                    <span class="badge">{{ $unreadNotifications->count() }}</span>
                    @endif
                </a>
                <div class="dropdown-content dropdown-content-right">
                    @if ($notifications->count() == null)
                    <a href=""> there are no notifications !</a>
                    @elseif ($notifications->count() != null)
                    @foreach ($notifications as $notification)

                    @if (Auth::user()->is_admin === 1)
                    @if ($notification->type === 'App\Notifications\NewUserNotification')
                    <a href="{{route('profile.index')}}">{{ $notification->data['name'] }} registered to our website!</a>
                    @endif
                    @endif
                        @if ($notification->type === 'App\Notifications\PostCreatedNotification')
                            <a >{{ $notification->data['user_name'] }} created a post at: {{ \Carbon\Carbon::parse($notification->data['created_at'])->format('Y-m-d H:i:s') }}</a>
                        @elseif ($notification->type === 'App\Notifications\CommentOnPostNotification')
                            <a href="">{{ $notification->data['user_name'] }} commented on your post at: {{ \Carbon\Carbon::parse($notification->data['created_at'])->format('Y-m-d H:i:s') }}</a>
                        @elseif ($notification->type === 'App\Notifications\JourneyCreatedNotification')
                            <a href="">{{ $notification->data['headline'] }} created at: {{ \Carbon\Carbon::parse($notification->data['created_at'])->format('Y-m-d H:i:s') }}</a>
                            @elseif ($notification->type === 'App\Notifications\JourneyEditedNotification')
                            <a href="">{{ $notification->data['headline'] }} created at: {{ \Carbon\Carbon::parse($notification->data['updated_at'])->format('Y-m-d H:i:s') }}</a>
                        @endif
                    @endforeach

                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button class="button" type="submit" class="btn btn-primary">Mark All As Read</button>
                    </form>
                    @endif
                </div>
            </div>

                <div class="dropdown" onclick="toggleDropdown(this)">
                    <a aria-label="this is user profile drop list" href="javascript:void(0)" class="dropbtn"><i class="fas fa-user"></i></a>
                    <div class="dropdown-content dropdown-content-right">
                        <a href="{{ route('profile.edit', Auth::user()) }}">{{ Auth::user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="button"  type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endif
        </div>
    </div>
    <main>
        @yield('content')
    </main>

    <script>

        function toggleDropdown(element)
        {
            element.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>
