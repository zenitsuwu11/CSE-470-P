<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
    <title>Admin Dashboard</title>
</head>
<body>
  <header>
    <!-- Top Row: Logo and User Area -->
    <div class="header-top">
      <div class="logo">
        G-Hub
      </div>
      <div class="right-section">
        <div class="user_area">
          <span class="username">{{ auth()->user()->name }}</span>
          <!-- Updated profile link: now uses route 'admin.profile.show' -->
          <a class="profile_link" href="{{ route('admin.profile.show') }}">Profile</a>
          <form action="{{ route('admin_logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
        </div>
      </div>
    </div>
    <!-- Bottom Row: Secondary Navigation -->
    <div class="header-bottom">
      <nav class="secondary-nav">
        <ul>
          <li><a href="">G-Credit</a></li>
          <li><a href="{{ route('admin.users') }}">Tusers</a></li>
        </ul>
      </nav>
    </div>
  </header>
 
  <main class="admin-container">
    <!-- Left Column: Game Addition Form -->
    <div class="form-container">
      <h3>Add New Game</h3>
      @if(session('success'))
        <p class="flash-message">{{ session('success') }}</p>
      @endif
      <form method="POST" action="{{ route('admin.games.store') }}">
        @csrf
        <div class="form-group">
          <label for="category">Category</label>
          <select name="category" id="category" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>
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
   
    <!-- Right Column: Game List Table -->
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Category</th>
            <th>Game Name</th>
            <th>Details</th>
            <th>Price ($)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($games as $index => $game)
            <tr>
              <td>{{ $index + 1 }}</td>
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
  </main>
</body>
</html>
