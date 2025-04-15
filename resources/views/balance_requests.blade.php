<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Balance Requests</title>
    <link rel="stylesheet" href="{{ asset('css/admin_dashboard.css') }}">
</head>
<body>

<header>
    <div class="header-top">
        <div class="logo">G-Hub(Admin)</div>
        <div class="right-section">
            <div class="user_area">
                <span class="username">
                    {{ auth()->check() ? auth()->user()->name : 'Guest' }}
                </span>
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
                <li><a href="{{ route('admin_dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users') }}">TUsers</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="admin-container">
    <h2>User Balance Requests</h2>

    @if(session('success'))
        <p class="flash-message" style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p class="flash-message" style="color: red;">{{ session('error') }}</p>
    @endif

    @if($requests->isEmpty())
        <p>No balance requests found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $index => $request)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($request->user)
                                {{ $request->user->name }}<br>
                            @else
                                <em>User not found</em>
                            @endif
                        </td>
                        <td>${{ number_format($request->amount, 2) }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            @if($request->status === 'pending')
                                <form method="POST" action="{{ route('admin.balance.requests.approve', $request->id) }}" style="display:inline;">
                                    @csrf
                                    <button class="approve-btn" type="submit">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.balance.requests.disapprove', $request->id) }}" style="display:inline;">
                                    @csrf
                                    <button class="disapprove-btn" type="submit">Disapprove</button>
                                </form>
                            @else
                                <em>{{ ucfirst($request->status) }}</em>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</main>

</body>
</html>
