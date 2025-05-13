<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Games Review and Details</title>
  <link rel="stylesheet" href="{{ asset('css/recommended.css') }}">
</head>
<body>

  <!-- Main Header -->
  <header class="main-header">
    <div class="G-Hub">
      <a href="{{ route('admin_dashboard') }}" class="logo">G-Hub</a>
    </div>
    <div class="right-section">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
      </form>
    </div>
  </header>

  <!-- Secondary Header -->
  <header class="sub-header">
    <a href="{{ route('admin_dashboard') }}" class="dashboard-link">Dashboard</a>
    <a href="{{ route('admin.users') }}">Tusers</a>
    <a href="{{ route('admin.balance.requests') }}">User Balance Requests</a>
  </header>

  <h1 class="page-title">Games Review and Details</h1>

  @if(session('success'))
    <div class="alert">{{ session('success') }}</div>
  @endif

  <!-- Games List Table -->
  <table class="game-table">
    <thead>
      <tr>
        <th>Game Name</th>
        <th>Price</th>
        <th>Recommended</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($games as $game)
      <tr>
        <td>{{ $game->name }}</td>
        <td>${{ number_format($game->price, 2) }}</td>
        <td>{{ $game->is_recommended ? '✅ Yes' : '❌ No' }}</td>
        <td>
          <form action="{{ route('admin.recommended.toggle', $game->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="btn {{ $game->is_recommended ? 'btn-danger' : 'btn-primary' }}">
              {{ $game->is_recommended ? 'Unmark' : 'Mark as Recommended' }}
            </button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4">No games available.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <!-- Patch and News Forms -->
  <section class="form-section">
    <!-- Game Patch Form -->
    <div class="form-container">
      <h2>Create a Game Patch Notice</h2>
      <form action="{{ route('admin.patch_notice.store') }}" method="POST">
        @csrf

        <!-- Game Selection Dropdown -->
        <label for="game_id">Select Game</label>
        <select id="game_id" name="game_id" required>
          <option value="" disabled selected>-- Choose a game --</option>
          @foreach($games as $game)
            <option value="{{ $game->id }}">{{ $game->name }}</option>
          @endforeach
        </select>

        <label for="patch_title">Patch Title</label>
        <input type="text" id="patch_title" name="patch_title" required>

        <label for="patch_description">Patch Description</label>
        <textarea id="patch_description" name="patch_description" rows="5" required></textarea>

        <label for="patch_notes">Patch Notes (Optional)</label>
        <textarea id="patch_notes" name="patch_notes" rows="5"></textarea>

        <button type="submit" class="btn btn-primary">Submit Patch Notice</button>
      </form>
    </div>

    <!-- Game News Form -->
    <div class="form-container">
      <h2>Create Game News</h2>
      <form action="{{ route('admin.game_news.store') }}" method="POST">
        @csrf

        <!-- News Game Selection -->
        <label for="news_game_id">Select Game</label>
        <select id="news_game_id" name="game_id" required>
          <option value="" disabled selected>-- Choose a game --</option>
          @foreach($games as $game)
            <option value="{{ $game->id }}" data-image="{{ $game->image }}">
              {{ $game->name }}
            </option>
          @endforeach
        </select>

        <label for="news_title">News Title</label>
        <input type="text" id="news_title" name="news_title" required>

        <label for="news">News Content</label>
        <textarea id="news" name="news" rows="5" required></textarea>

        <button type="submit" class="btn btn-success">Submit Game News</button>
      </form>
    </div>
  </section>

  <!-- JavaScript to Auto-Fill Image Link -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const gameSelect = document.getElementById('news_game_id');
      const imageLinkInput = document.getElementById('image_link');

      gameSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const imageUrl = selectedOption.getAttribute('data-image');
        if (imageUrl) {
          imageLinkInput.value = imageUrl;
        } else {
          imageLinkInput.value = '';
        }
      });
    });
  </script>

</body>
</html>
