<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
    <title>Admin Dashboard</title>
</head>
<body>
  <header>
    <div class="header-top">
      <div class="logo">G‑Hub(Admin)</div>
      <div class="right-section">
        <span class="username">{{ auth()->user()->name }}</span>
        <a class="profile_link" href="{{ route('admin.profile.show') }}">Profile</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="logout_button">Logout</button>
        </form>
      </div>
    </div>

    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="{{ route('admin.recommended') }}">GamesDetails</a></li>
          <li><a href="{{ route('admin.users') }}">Tusers</a></li>
          <li><a href="{{ route('admin.balance.requests') }}">User Balance Requests</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="admin-container">
    <div class="top-section">
      {{-- Game Addition Form --}}
      <div class="form-container">
        <h3>Add New Game</h3>

        {{-- Flash Message --}}
        @if(session('success'))
          <p class="flash-message">{{ session('success') }}</p>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
          <div class="validation-errors">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('admin.games.store') }}">

          @csrf

          <div class="form-group">
            <label for="category-select">Category</label>
            <select id="category-select" name="category" onchange="handleCategoryChange()" required>
              <option value="">Select Category</option>
              <option value="Featured Games">Featured Games</option>
              <option value="More to Discover">More to Discover</option>
              <option value="RPG">RPG</option>
              <option value="FPS">FPS</option>
              <option value="Action">Action</option>
              <option value="Puzzle">Puzzle</option>
              <option value="Adventure">Adventure</option>
              <option value="Horrors">Horrors</option>
              <option value="Simulation">Simulation</option>
              <option value="custom">-- Custom Category --</option>
            </select>
            <input
              type="text"
              id="custom-category"
              name="custom_category"
              placeholder="Enter custom category"
              style="display:none; margin-top:10px;"
            >
          </div>

          <div class="form-group">
            <label for="image">Image URL</label>
            <input type="url" name="image" id="image" placeholder="Enter image URL" required>
          </div>

          <div class="form-group">
            <label for="name">Game Name</label>
            <input type="text" name="name" id="name" placeholder="Enter game name" required>
          </div>

          <div class="form-group">
            <label for="details">Game Details</label>
            <textarea name="details" id="details" placeholder="Enter game details" required></textarea>
          </div>

          <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" step="0.01" name="price" id="price" placeholder="Enter price" required>
          </div>

          <button type="submit" class="add-game-btn">Add Game</button>
        </form>
      </div>

      {{-- Games List --}}
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Category</th>
              <th>Name</th>
              <th>Details</th>
              <th>Price ($)</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($games as $i => $game)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $game->category }}</td>
                <td>{{ $game->name }}</td>
                <td>{{ $game->details }}</td>
                <td>{{ number_format($game->price, 2) }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.games.destroy', $game->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    {{-- Support Messages --}}
    <div class="table-container">
      <h3>Support Messages</h3>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>User Email</th>
            <th>Message</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($supports as $i => $support)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $support->user_email }}</td>
              <td>{{ $support->message }}</td>
              <td>
                <form method="POST" action="{{ route('admin.supports.destroy', $support->id) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="delete-btn">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4">No support messages found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

  <script>
    function handleCategoryChange() {
      const sel = document.getElementById('category-select');
      const custom = document.getElementById('custom-category');

      if (sel.value === 'custom') {
        custom.style.display = 'block';
        custom.setAttribute('required', 'required');
      } else {
        custom.style.display = 'none';
        custom.removeAttribute('required');
        custom.value = '';
      }
    }
  </script>
</body>
</html>
