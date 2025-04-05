<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaming Hub Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <style>
    /* Ensure text is rendered normally (not italic) */
    body, h1, h2, h3, p, a, span, li, div {
      font-style: normal !important;
    }
  </style>
</head>
<body>
  <header>
    <!-- Header with Two Rows: Logo, Search, and User Area -->
    <div class="header-top">
      <div class="logo">
        G-Hub
      </div>
      <div class="right-section">
        <div class="search-box">
          <input type="text" id="search-box" placeholder="Search games...">
          <button id="search-btn">🔍</button>
        </div>
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
    <!-- Secondary Navigation -->
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="#">Store</a></li>
          <li><a href="#">Library</a></li>
          <li><a href="#">Community</a></li>
          <li><a href="#">Support</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <!-- Display Games Grouped by Category -->
    @foreach($groupedGames as $category => $games)
      <section class="game-category">
        <h2>{{ $category }}</h2>
        <div class="game-grid">
          @foreach($games as $game)
            <div class="game">
              <img src="{{ $game->image }}" alt="{{ $game->name }}">
              <h3>{{ $game->name }}</h3>
              <p>{{ $game->details }}</p>
              <div class="price">${{ number_format($game->price, 2) }}</div>
              <button class="buy-btn">Buy Now</button>
            </div>
          @endforeach
        </div>
      </section>
    @endforeach
  </main>

  <!-- Include your search JS if needed -->
  <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
