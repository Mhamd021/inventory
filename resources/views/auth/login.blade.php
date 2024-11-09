<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('login.css')}}">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <img src="logo.png" />
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" id="username" name="email" placeholder="Email" required>
                <input type="password" id="password" name="password" placeholder="Password" aria-describedby="passwordHelp" required>
                <div class="button">
                  <button type="submit">Login</button>
                </div>
                 <div class="button">
                 <a href="{{route('register')}}">Don't have an account?</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


