<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Admin Login</title>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form method="POST" action="{{ route('admin_login') }}">
                    @csrf
                    <h2>Admin-Login</h2>
                    
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
                        <input type="password" name="password" required>
                        <label>Password</label>
                        <ion-icon name="eye-off-outline" class="toggle-password"></ion-icon>
                    </div>
                    @error('password')
                        <p style="color: red; text-align: center;">{{ $message }}</p>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit">Login</button>

                    <!-- Navigation Links -->
          
                </form>
            </div>
        </div>
    </section>

    <!-- Ionicons Script -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Toggle Password Visibility Script -->
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