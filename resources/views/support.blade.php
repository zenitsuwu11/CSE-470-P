<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Support</title>
  <link rel="stylesheet" href="{{ asset('css/support.css') }}">
</head>
<body>
  <header>
    <!-- A simple header with logo and navigation -->
    <div class="header-top">
      <div class="logo">G-Hub(Store)</div>
      <div class="right-section">
        <div class="user_area">
          <span class="username">{{ auth()->user()->name }}</span>
          <a class="profile_link" href="{{ route('profile.show') }}">Profile</a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
        </div>
      </div>
    </div>
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="{{ route('profile.show') }}">Profile</a></li>
          <li><a href="{{ route('social.index') }}">Social & Chat</a></li>
          <li><a href="{{ route('library') }}">Library</a></li>
          <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li><a href="{{ route('gamenews.index') }}">News & Reviews</a></li>
          <li><a href="{{ route('patch.index') }}">Patch Updates</a></li>
          <li><a href="{{ route('reviews.index') }}">Submit Reviews</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="support-container">
    <h1>Support</h1>
    @if(session('success'))
      <p class="flash-message">{{ session('success') }}</p>
    @endif
    <form action="{{ route('support.store') }}" method="POST">
      @csrf
      <div class="form-group">
         <label for="user-name">Your Name</label>
         <input type="text" id="user-name" value="{{ auth()->user()->name }}" disabled>
      </div>
      <div class="form-group">
         <label for="user-email">Your Email</label>
         <input type="email" id="user-email" value="{{ auth()->user()->email }}" disabled>
      </div>
      <div class="form-group">
         <label for="message">Your Message</label>
         <textarea name="message" id="message" placeholder="Write your message here..." required></textarea>
      </div>
      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </main>
</body>
</html>
