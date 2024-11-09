<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="{{asset('login.css')}}">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="logo.png"/>
            <form method="POST" action="{{ route('register') }}">
                @csrf
               <input type="text" id="name" name="name" placeholder="Name"  required>
               <x-input-error :messages="$errors->get('name')" class="mt-2" />
                <input type="email" id="username" name="email"   autocomplete= "off" placeholder="Email" required>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <input type="password" id="password" name="password" placeholder="Password"  autocomplete="new-password"  required>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <input type="password" id="password" name="password_confirmation" placeholder="password_confirmation"  required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />


                <div class="button">
                  <button type="submit">Register</button>
                </div>
                 <div class="button">
                 <a href="{{route('login')}}">have an account already?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
