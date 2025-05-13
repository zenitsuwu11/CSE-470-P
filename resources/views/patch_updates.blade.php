<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patch Updates</title>
    <link rel="stylesheet" href="{{ asset('css/patch.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<header>
    <div class="header-top">
        <div class="logo">G-Hub Store</div>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</header>

<div class="layout">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <button id="sidebarToggle" class="toggle-btn">&lt;&lt;&lt;</button>
        <ul class="sidebar-nav">
            <li><a href="{{ route('profile.show') }}">Profile</a></li>
            <li><a href="{{ route('social.index') }}">Social</a></li>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('library') }}">Library</a></li>
            <li><a href="{{ route('gamenews.index') }}">News</a></li>
            <li><a href="{{ route('patch.index') }}" class="active">Patch Updates</a></li>
            <li><a href="{{ route('support.create') }}">Support</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="news-section">
            <h1 class="section-title">Patch Updates</h1>
            <div class="news-slider">
                @foreach($patchUpdates as $update)
                    <div class="news-card" data-update-id="{{ $update->id }}">
                        <div class="news-header">
                            <h2 class="news-title">{{ $update->title }}</h2>
                            <p class="news-meta">
                                PATCH <span>
                                    {{ $update->created_at ? \Carbon\Carbon::parse($update->created_at)->diffForHumans() : 'Date not available' }}
                                </span>
                            </p>
                        </div>

                        <!-- New fields for Description and Notes -->
                        <div class="news-description">
                            <h3>Description:</h3>
                            <p>{{ $update->description }}</p>
                        </div>

                        <div class="news-notes">
                            <h3>Notes:</h3>
                            <p>{{ $update->notes }}</p>
                        </div>


                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $patchUpdates->links() }}
            </div>
        </div>
    </main>

</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        toggleBtn.textContent = sidebar.classList.contains('collapsed') ? '>>>' : '<<<';
    });
</script>

</body>
</html>
