<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaming Hub Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<!-- Put this just before </body> -->
<script src="{{ asset('js/carousel.js') }}"></script>

<body>
  <header>
    <!-- Header Top -->
    <div class="header-top">
      <div class="logo">G-Hub(Store)</div>
      <div class="right-section">
        <div class="search-box">
          <input type="text" id="search-box" placeholder="Search games...">
          <button id="search-btn">🔍</button>
          <div id="dropdown-results" class="dropdown-results"></div>
        </div>
        <div class="user_area">
          <a class="profile_link" href="{{ route('profile.show') }}">Profile</a>
          <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
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
    <!-- Header Bottom -->
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="{{ route('library') }}">Library</a></li>
          <li><a href="{{ route('gamenews.index') }}">News & Reviews</a></li>
          <li><a href="{{ route('support.create') }}">Support</a></li>
          <li><a href="{{ route('reviews.index') }}">Submit Reviews</a><li>
          <li><a href="{{ route('patch.index') }}">Patchupdate</a><li>
          <li><a href="{{ route('social.index') }}">Social & Chat</a><li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Recommended Carousel -->
  <section class="recommended-section">
    <h2>Recommended for you</h2>
    <div class="carousel-wrapper">
      <button class="carousel-arrow left-arrow" aria-label="Previous">&lt;</button>
      <div class="carousel-viewport">
        <div class="recommended-grid carousel-track">
          @foreach($recommendedGames as $game)
            <div class="game-card">
              @if($game->is_sold_out)
                <span class="badge sold-out">Sold out</span>
              @endif
              <img src="{{ $game->image }}" alt="{{ $game->name }}">
              <h3>{{ $game->name }}</h3>
              
              <div class="price">
                @if(isset($game->min_price) && isset($game->max_price) && $game->min_price != $game->max_price)
                  ${{ number_format($game->min_price, 2) }} – ${{ number_format($game->max_price, 2) }}
                @else
                  ${{ number_format($game->price, 2) }}
                @endif
              </div>
              <form action="{{ route('games.invoice', $game->id) }}" method="GET">
                @csrf
                <button type="submit" class="buy-btn" {{ $game->is_sold_out ? 'disabled' : '' }}>
                  {{ $game->is_sold_out ? 'Unavailable' : 'Buy Now' }}
                </button>
              </form>
            </div>
          @endforeach
        </div>
      </div>
      <button class="carousel-arrow right-arrow" aria-label="Next">&gt;</button>
    </div>
  </section>

  <!-- All Games Section -->
  <section class="all-games-section">
    <h2>All Games</h2>
    <div class="game-grid">
      @foreach($allGames as $game)
        <div class="game">
          <img src="{{ $game->image }}" alt="{{ $game->name }}">
          <h3>{{ $game->name }}</h3>
          
          <div class="price">${{ number_format($game->price, 2) }}</div>
          <form action="{{ route('games.invoice', $game->id) }}" method="GET">
            @csrf
            <button type="submit" class="buy-btn">Buy Now</button>
          </form>
        </div>
      @endforeach
    </div>
  </section>

  <!-- Main Content: Games by Category -->
  <main>
  <h2>Games By Category</h2>
    @foreach($groupedGames as $category => $games)
      <section class="game-category">
        <h2>{{ $category }}</h2>
        <div class="game-grid">
          @foreach($games as $game)
            <div class="game">
              <img src="{{ $game->image }}" alt="{{ $game->name }}">
              <h3>{{ $game->name }}</h3>
              
              <div class="price">${{ number_format($game->price, 2) }}</div>
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

  <!-- Scripts -->
  <script src="{{ asset('js/search.js') }}"></script>
  <script src="{{ asset('js/carousel.js') }}"></script>
</body>
</html>
