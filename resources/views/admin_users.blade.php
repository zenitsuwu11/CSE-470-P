<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
</head>
<body>

<header>
    <div class="header-top">
        <div class="logo">G-Hub(Admin)</div>
        <div class="right-section">
            <div class="user_area">
                <span class="username">{{ auth()->user()->name }}</span>
                <a class="profile_link" href="{{ route('admin.profile.show') }}">Profile</a>
                <form action="{{ route('admin_logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout_button">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="header-bottom">
        <nav class="secondary-nav">
            <ul>
                <li><a href="{{ route('admin_dashboard') }}" class="{{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.balance.requests') }}" class="{{ request()->routeIs('admin.balance.requests') ? 'active' : '' }}">User Balance Requests</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="admin-container">
    <h2>All Users</h2>

    @if(session('success'))
        <p class="flash-message" style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="flash-message" style="color: red;">{{ session('error') }}</p>
    @endif

    @if($users->isEmpty())
        <p>No users found.</p>
    @else
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
    @endif
</main>

</body>
</html>
