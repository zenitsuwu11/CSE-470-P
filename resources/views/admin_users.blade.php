<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/admin_users.css') }}">
    <title>All Users</title>
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
          <a class="profile_link" href="{{ route('profile.show') }}">Profile</a>
          <form action="{{ route('admin_logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout_button">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </header>
  
  <main>
    <h2>All Users</h2>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $index => $user)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
