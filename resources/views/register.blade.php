<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Link CSS -->
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
  <section>
    <div class="form-box">
      <div class="form-value">
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <h2>Signup</h2>

          <!-- Name Input -->
          <div class="inputbox">
            <ion-icon name="person-outline"></ion-icon>
            <input type="text" name="name" value="{{ old('name') }}" required>
            <label for="name">Name</label>
          </div>
          @error('name')
            <p style="color: red;">{{ $message }}</p>
          @enderror

          <!-- Email Input -->
          <div class="inputbox">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label for="email">Email</label>
          </div>
          @error('email')
            <p style="color: red;">{{ $message }}</p>
          @enderror

          <!-- Password Input -->
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" name="password" id="password" required>
            <label for="password">Pass</label>
            <ion-icon name="eye-off-outline" id="toggle-password" class="toggle-password"></ion-icon>
            <small class="password-info">Password must be at least 8 characters long.</small>
          </div>
          @error('password')
            <p style="color: red;">{{ $message }}</p>
          @enderror

          <!-- Confirm Password Input -->
          <div class="inputbox">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" name="password_confirmation" id="confirm-password" required>
            <label for="password_confirmation">Confirm Pass</label>
            <ion-icon name="eye-off-outline" id="toggle-confirm-password" class="toggle-password"></ion-icon>
            <small id="confirm-password-info" class="password-info"></small>
          </div>

          <!-- Submit Button -->
          <button type="submit">Sign up</button>

          <!-- Redirect to Login -->
          <div class="register">
            <p>Already have an account? <a href="{{ route('login') }}">Login</a> here!</p>
            <p> ㅤ </p>
            <p>New Admin? <a href="{{ route('admin_register') }}">Signup</a> here!</p>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Ionicons for Icons -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

  <!-- Link to External JS -->
  <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
