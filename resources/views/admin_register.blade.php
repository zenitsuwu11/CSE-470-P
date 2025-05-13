<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            <p>G-Hub</p>
        </div>
    </div>
</header>

<!-- Signup Form Section -->
<section>
    <div class="container">
        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="{{ route('admin.register') }}">
                    @csrf
                    <h2>Admin-Signup</h2>

                    <!-- Name -->
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                        <label>Name</label>
                    </div>
                    @error('name')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Email -->
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                        <label>Email</label>
                    </div>
                    @error('email')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Password -->
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" id="password" required>
                        <label>Pass</label>
                        <ion-icon name="eye-off-outline" class="toggle-password"></ion-icon>
                        <small class="password-info">Password must be at least 8 characters long.</small>
                    </div>
                    @error('password')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password -->
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password_confirmation" id="confirm-password" required>
                        <label>Confirm Pass</label>
                        <ion-icon name="eye-off-outline" class="toggle-password"></ion-icon>
                        <small id="confirm-password-info" class="password-info"></small>
                    </div>
                    @error('password_confirmation')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Secret Pin -->
                    <div class="inputbox">
                        <ion-icon name="key-outline"></ion-icon>
                        <input type="text" name="secret_pin" value="{{ old('secret_pin') }}" required>
                        <label>Secret Pin</label>
                    </div>
                    @error('secret_pin')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Submit -->
                    <button type="submit">Signup</button>

                    <!-- Navigation Links -->
                    <div class="register">
                        <p>Already an admin? <a href="{{ route('admin.login') }}">Login here</a></p>
                        <p>Not an admin? <a href="{{ route('register') }}">Signup as user</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Ionicons Script -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<!-- Password Toggle Script -->
<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function () {
            const passwordField = this.parentElement.querySelector('input');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.setAttribute('name', type === 'password' ? 'eye-off-outline' : 'eye-outline');
        });
    });
</script>

</body>
</html>
