<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login to G-Hub</title>
  
  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <!-- Font Awesome -->
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
        <p>G-Hub</p>
      </div>
    </div>
  </header>

  <!-- Login Form Section -->
  <section>
    <div class="container">
      <div class="form-box">
        <div class="form-value">
          <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <h2>Admin Login</h2>

            <!-- Email -->
            <div class="inputbox">
              <ion-icon name="mail-outline"></ion-icon>
              <input type="email" name="email" required>
              <label>Email</label>
            </div>
            @error('email')
              <p class="error-msg">{{ $message }}</p>
            @enderror

            <!-- Password -->
            <div class="inputbox">
              <ion-icon name="lock-closed-outline"></ion-icon>
              <input type="password" name="password" id="password" required>
              <label>Password</label>
              <ion-icon name="eye-off-outline" class="toggle-password" id="toggle-password"></ion-icon>
            </div>
            @error('password')
              <p class="error-msg">{{ $message }}</p>
            @enderror

            <!-- Submit -->
            <button type="submit">Login</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Error Message Display -->
    @if ($errors->any())
      <div class="error-container">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </section>

  <!-- Ionicons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <!-- Toggle Password Script -->
  <script>
    const togglePassword = document.getElementById('toggle-password');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      togglePassword.setAttribute('name', type === 'password' ? 'eye-off-outline' : 'eye-outline');
    });
  </script>
</body>
</html>
