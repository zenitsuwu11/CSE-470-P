<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Admin Signup</title>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="{{ route('admin_register') }}">
                    @csrf
                    <h2>Admin-Signup</h2>

                    <!-- Name Input -->
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input type="text" name="name" required>
                        <label>Name</label>
                    </div>
                    @error('name')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Email Input -->
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    @error('email')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Password Input -->
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" id="password" required>
                        <label>Pass</label>
                        <ion-icon name="eye-off-outline" class="toggle-password"></ion-icon>
                    </div>
                    @error('password')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Confirm Password Input -->
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password_confirmation" id="confirm-password" required>
                        <label>Confirm Pass</label>
                        <ion-icon name="eye-off-outline" class="toggle-password"></ion-icon>
                    </div>
                    @error('password_confirmation')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Secret Pin Input -->
                    <div class="inputbox">
                        <ion-icon name="key-outline"></ion-icon>
                        <input type="text" name="secret_pin" required>
                        <label>Secret Pin</label>
                    </div>
                    @error('secret_pin')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <button type="submit">Signup</button>

                    <!-- Enhanced Navigation Links -->
                    <div class="register">
                        <p>Already an admin? <a href="{{ route('admin_login') }}">Login here</a></p>
                        <p>User registration? <a href="{{ route('register') }}">Signup here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Ionicons Script -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Password Toggle Script -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const passwordField = this.parentElement.querySelector('input');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.setAttribute('name', type === 'password' ? 'eye-off-outline' : 'eye-outline');
            });
        });
    </script>
</body>
</html>