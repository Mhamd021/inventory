<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{asset('applayout.css')}}" type="text/css" media="all" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
</head>
<body>

<div class="navbar">
  <div class="left">
    <a class="open-sidebar" onclick="toggleSidebar()" >☰</a>
    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
     <div class="dropdown">
    <a href="javascript:void(0)" class="dropbtn" id="folded">Journeys</a>
      <div class="dropdown-content">
       <a href="{{route('journey.create')}}">create   <i class="fas fa-plus-circle icon"></i></a>
    <a href="{{route('journey.index')}}">journeys  <i class="fas fa-location icon"></i></a>
    <a href="{{route('journey.trash')}}">trashed  <i class="fas fa-trash icon"></i></a>
    </div>
     </div>
      <a href="#services" id="folded">Contact</a>
  </div>
  @if (auth()->check())
  <div class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">{{Auth::user()->name}}</a>
    <div class="dropdown-content">
      <a href="{{route('profile.edit')}}">Profile</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
      <button type="submit">Logout </button>

      </form>

    </div>
  </div>
  @else
  <a href="{{route('login')}}">Login</a>

  @endif
</div>
<main>
@yield('content')
</main>
</body>

</html>



{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>

</html> --}}
