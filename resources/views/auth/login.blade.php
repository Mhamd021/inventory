<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="login-box"> <img src="logo.png" alt="Logo" />
            <form method="POST" action="{{ route('login') }}"> @csrf
                <div class="input-group">
                 <i class="fas fa-envelope icon"></i>
                 <input title="Enter your email" type="email" id="username" name="email"placeholder=" Enter your email" required>
                </div>
                <div class="input-group"> <i class="fas fa-lock icon"></i> <input type="password" id="password" title="Enter your password"
                        name="password" placeholder="Enter your password" aria-describedby="passwordHelp" required>
                </div>
                <div class="button"> <button type="submit"  >Login</button> </div>
                <div class="button"> <a href="{{ route('register') }}" id="registerLink">Don't have an account?</a> </div>
            </form>
        </div>
    </div>
</body>

<script>
document.getElementById('registerLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.body.classList.add('fade-out');
    setTimeout(function()
    {
        window.location.href = event.target.href;
    },
     500
    );
});


</script>
</html>
