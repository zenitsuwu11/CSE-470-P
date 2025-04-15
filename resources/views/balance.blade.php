<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Balance Details</title>
  <link rel="stylesheet" href="{{ asset('css/balance.css') }}">
</head>
<body>
  <header>
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
          <li><a href="{{ route('dashboard') }}">Home</a></li>
          <li><a href="{{ route('balance.index') }}">Balance</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="balance-container">
    <h1>Your Balance Details</h1>
    <div class="balance-summary">
      <!-- Check if balanceRecord is null and show 0.00 if true -->
      <p>Current Balance: ${{ $balanceRecord ? number_format($balanceRecord->balance, 2) : '0.00' }}</p>
    </div>
    
    <h2>Transaction History</h2>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Game</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transactions as $transaction)
          <tr>
            <td>{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
            <td>{{ ucfirst($transaction->type) }}</td>
            <td>${{ number_format($transaction->amount, 2) }}</td>
            <td>
              @if($transaction->game_id)
                @php
                  $game = \App\Models\Game::find($transaction->game_id);
                @endphp
                {{ $game ? $game->name : 'N/A' }}
              @else
                N/A
              @endif
            </td>
          </tr>
        @endforeach
        @if($transactions->isEmpty())
          <tr>
            <td colspan="4">No transactions found.</td>
          </tr>
        @endif
      </tbody>
    </table>
    
    <!-- Display balance top-up request form -->
    <h2>Request Balance Top-Up</h2>
    <form action="{{ route('balance.request') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="requested_amount">Amount to Request:</label>
        <input type="number" step="0.01" name="amount" id="requested_amount" required>
      </div>
      <button type="submit" class="submit-btn">Submit Request</button>
    </form>

    <!-- Display success or error messages -->
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif
  </main>
</body>
</html>
