<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="responsive">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G-Hub Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body class="responsive_page">
    <div class="responsive_page_frame with_header">
        <!-- Global Header (Navigation Bar) -->
        <div id="global_header">
            <div class="header_container">
                <!-- Logo Section -->
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <!-- Replace the image below with your G-Hub logo -->
                        <img src="{{ asset('images/ghub_logo.png') }}" alt="G-Hub Logo">
                    </a>
                </div>
                <!-- Navigation Menu -->
                <div class="nav_menu">
                    <ul class="menu">
                        <li><a href="#">STORE</a></li>
                        <li><a href="#">COMMUNITY</a></li>
                        <li><a href="#">ABOUT</a></li>
                        <li><a href="#">SUPPORT</a></li>
                    </ul>
                </div>
                <!-- User Area -->
                <div class="user_area">
                    <span class="username">{{ auth()->user()->name }}</span>
                    <a class="profile_link" href="#">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout_button">Logout</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div id="content">
            <h1>Welcome to G-Hub Dashboard</h1>
            <p>Enjoy your stay at G-Hub. Explore our games, community, and more!</p>
            <!-- You can add more dashboard widgets or content here -->
        </div>
    </div>
    <!-- Dashboard JavaScript (if any) -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
