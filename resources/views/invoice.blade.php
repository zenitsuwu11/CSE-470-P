<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice - {{ $game->name }}</title>
  <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
</head>
<body>

  <header>
    <div class="header-top">
      <div class="logo">G-Hub</div>
      <div class="user_area">
        <span class="username">{{ auth()->user()->name }}</span>
        <a class="profile_link" href="{{ route('profile.show') }}">Profile</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="logout_button">Logout</button>
        </form>
      </div>
    </div>
  </header>

  <main>
    <div class="invoice-container">
      <h1>Invoice for {{ $game->name }}</h1>
      
      <!-- Game details -->
      <p><strong>Game Name:</strong> {{ $game->name }}</p>
      <p><strong>Category:</strong> {{ $game->category }}</p>
      <p><strong>Description:</strong> {{ $game->details }}</p>
      <p><strong>Price:</strong> ${{ number_format($game->price, 2) }}</p>

      <!-- Confirm Purchase form -->
      <form action="{{ route('game.confirmPurchase', $game->id) }}" method="POST">
        @csrf
        <button type="submit" class="confirm-btn">Confirm Purchase</button>
      </form>

      <!-- Cancel button to go back to dashboard -->
      <a href="{{ route('dashboard') }}" class="cancel-btn">Cancel</a>
    </div>
  </main>

</body>
</html>
