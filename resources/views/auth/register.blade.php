<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="login-box"> <img src="logo.png" alt="Logo" />
            <form method="POST" action="{{ route('register') }}"> @csrf <div class="input-group"> <i
                        class="fas fa-user icon"></i> <input type="text" id="name" name="name"
                        placeholder="Enter your Name" required>
                </div>
                <div class="input-group"> <i class="fas fa-envelope icon"></i> <input type="email" id="email"
                        name="email" placeholder=" Enter your Email" autocomplete="off" required>
                     </div>

                <div class="input-group"> <i class="fas fa-lock icon"></i> <input type="password" id="password"
                        name="password" placeholder=" Enter your Password" autocomplete="new-password" required>
                    </div>
                <div class="input-group"> <i class="fas fa-lock icon"></i> <input type="password"
                        id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                <div class="button"> <button type="submit">Register</button> </div>
                <div class="button"> <a href="{{ route('login') }}" id="registerLink">Have an account already?</a> </div>
            </form>
        </div>
    </div>

</body>
<script>
document.getElementById('registerLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.body.classList.add('fade-out');
    setTimeout(function() {
        window.location.href = event.target.href;
    }, 500);
});


    </script>
</html>
