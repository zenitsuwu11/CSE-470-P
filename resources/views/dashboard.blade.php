<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaming Hub Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
  <header>
    <!-- Header with Two Rows: Logo, Search, and User Area -->
    <div class="header-top">
      <div class="logo">
        G-Hub(Store)
      </div>
      <div class="right-section">
        <div class="search-box" style="position: relative;">
          <input type="text" id="search-box" placeholder="Search games...">
          <button id="search-btn">🔍</button>
          <!-- Dropdown container for search results -->
          <div id="dropdown-results" class="dropdown-results" style="display:none;"></div>
        </div>
        <div class="user_area">
          <!--<span class="username">{{ auth()->user()->name }}</span> -->
          <a class="profile_link" href="{{ route('profile.show') }}">Profile</a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
          <!-- Balance Box -->
          <div class="balance-box">
            <div class="balance-info">
              <div class="balance-username">{{ auth()->user()->name }}</div>
              <div class="balance-amount">
                <a href="{{ route('balance.index') }}">
                  ${{ number_format(auth()->user()->balance->amount ?? 0, 2) }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Secondary Navigation -->
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="{{ route('library') }}">Library</a></li>
          <li><a href="#">Community</a></li>
          <li><a href="{{ route('support.create') }}">Support</a></li>
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
              <img src="{{ $game->image }}" alt="{{ $game->name }}"/>
              <h3>{{ $game->name }}</h3>
              <p>{{ $game->details }}</p>
              <div class="price">${{ number_format($game->price, 2) }}</div>
              <!-- Update the Buy Now button to redirect to the invoice page -->
              <form action="{{ route('games.invoice', $game->id) }}" method="GET">
                @csrf
                <button type="submit" class="buy-btn">Buy Now</button>
              </form>
            </div>
          @endforeach
        </div>
      </section>
    @endforeach
  </main>

  <!-- Include the search JavaScript -->
  <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>
