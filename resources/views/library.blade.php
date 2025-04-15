<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Game Library</title>
  <link rel="stylesheet" href="{{ asset('css/library.css') }}">
</head>
<body>
  <header>
    <!-- Header Top: Logo and User Area -->
    <div class="header-top">
      <div class="logo">G-Hub</div>
      <div class="right-section">
        <div class="user_area">
          @auth
            <span class="username">{{ auth()->user()->name }}</span>
            <!-- Profile as a normal link -->
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
          @else
            <a href="{{ route('login') }}" class="header-link">Login</a>
            <a href="{{ route('register') }}" class="header-link">Signup</a>
          @endauth
        </div>
      </div>
    </div>

    <!-- Header Bottom: Secondary Navigation -->
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

  <!-- Library Section -->
  <div class="library-container">
    <h2>Your Game Library</h2>
    @forelse($purchasedGames->groupBy('category') as $category => $games)
      <div class="category-section">
        <h3 class="category-title">{{ $category }}</h3>
        <div class="library-grid">
          @foreach($games as $purchase)
            @php
              $game = $purchase->game;
            @endphp
            <div class="game-container">
              <div class="game-details">
                <img src="{{ asset($game->image) }}" alt="Cover" class="game-cover">
                <h3>{{ $game?->name ?? 'N/A' }}</h3>
                <p>{{ $game?->category ?? 'N/A' }}</p>
                <p class="price">${{ number_format($purchase->amount_spent, 2) }}</p>
                <p>Purchased on: {{ $purchase->created_at->format('M d, Y') }}</p>
                <!-- Play button -->
                <a href="{{ route('library.game', $game->name) }}" class="game-btn" {{ $game ? '' : 'disabled' }}>Play</a>
                <!-- Delete Game Form -->
                <form action="{{ route('game.delete', $purchase->id) }}" method="POST" style="display:inline;">
                  @csrf
                  <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to remove this game from your library?');">Delete</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <p style="color: #ccc;">You haven't purchased any games yet.</p>
    @endforelse
  </div>
</body>
</html>
