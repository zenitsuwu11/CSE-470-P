<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login – G‑Hub</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

  <!-- Header Start -->
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
        <h1>G-Hub Admin</h1>
      </div>

      @auth('admin')
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit">Logout</button>
        </form>
      @endauth
    </div>
  </header>
  <!-- Header End -->

  <section>
    <div class="container">
      <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <h2>Admin Login</h2>

        <div class="inputbox">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="email" name="email" value="{{ old('email') }}" required>
          <label>Email</label>
        </div>
        @error('email') <p class="error-msg">{{ $message }}</p> @enderror

        <div class="inputbox">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input type="password" name="password" id="password" required>
          <label>Password</label>
          <ion-icon name="eye-off-outline" class="toggle-password" id="toggle-password"></ion-icon>
        </div>
        @error('password') <p class="error-msg">{{ $message }}</p> @enderror

        <button type="submit">Login</button>
      </form>

      @if($errors->any())
      <div class="error-container">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
    </div>
  </section>

  <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js" type="module"></script>
  <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js" nomodule></script>
  <script>
    const toggle = document.getElementById('toggle-password'),
          pwd    = document.getElementById('password');
    toggle.addEventListener('click', () => {
      const t = pwd.type === 'password' ? 'text' : 'password';
      pwd.type = t;
      toggle.name = t === 'password' ? 'eye-off-outline' : 'eye-outline';
    });
  </script>
</body>
</html>
