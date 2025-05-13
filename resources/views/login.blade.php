<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login to G-Hub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-left"></div>

        <div class="header-center">
            <ul>
                <li><a href="{{ route('welcome') }}">Welcome Page</a></li>
            </ul>
        </div>

        <div class="header-right">
            <div class="logo footer-logo">
                <i class="fas fa-gamepad"></i>
                <h1>G-Hub</h1>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <div class="container">
        <section>
            <div class="form-box">
                <div class="form-value">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h2>Login</h2>
                        <div class="inputbox">
                            <ion-icon name="mail-outline"></ion-icon>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                            <label>Email</label>
                        </div>
                        <div class="inputbox">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                            <input type="password" name="password" id="password" required>
                            <label>Password</label>
                            <ion-icon name="eye-off-outline" id="toggle-password" class="toggle-password"></ion-icon>
                        </div>
                        @error('email')
                            <p style="color: red; text-align: center;">{{ $message }}</p>
                        @enderror
                        @error('password')
                            <p style="color: red; text-align: center;">{{ $message }}</p>
                        @enderror
                        <button type="submit">Log in</button>
                        <div class="register">
                            <p>Admins <a href="{{ route('admin.login') }}">Login</a> here!</p>
                            <p> ㅤ </p>
                            <p>Don't have an account? <a href="{{ route('register') }}">Signup</a> now!</p>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Toggle password visibility
        const passwordField = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.setAttribute('name', type === 'password' ? 'eye-off-outline' : 'eye-outline');
        });
    </script>
</body>
</html>
