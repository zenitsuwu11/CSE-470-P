<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G-Hub</title>
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <button class="hamburger-btn"><i class="fas fa-bars"></i></button>
            <div class="logo footer-logo">
                <i class="fas fa-gamepad"></i>
                <h1>G-Hub</h1>
            </div>
        </header>

        <!-- Sidebar -->
        <div class="sidebar">
            <ul class="sidebar-nav">
                @auth
                    <li><a href="{{ url('/dashboard') }}" class="active">DASHBOARD</a></li>
                @else
                    @if (Route::has('login'))
                        <li><a href="{{ route('login') }}">LOGIN</a></li>
                    @endif
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">REGISTER</a></li>
                    @endif
                @endauth
            </ul>
        </div>

        <div class="content-wrapper">
            <div class="content-desc">
                <h1>THE GAMING WORLD NOW IN YOUR HAND</h1>
                @auth
                    <a href="{{ url('/dashboard') }}" id="btn2">Go to Dashboard</a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" id="btn2">Join G-Hub Now</a>
                    @endif
                @endauth
            </div>
            <div class="rakuto"></div>
        </div>
    </div>

    <div class="logo-section">
        <i class="fas fa-gamepad"></i>
        <h1>The Gaming Hub</h1>
    </div>

    <div class="game-categories">
        <h1>GAME CATEGORIES</h1>
        <div class="game-wrapper">
            <a href="#"><div class="gw gw-1"></div></a>
            <a href="#"><div class="gw gw-2"></div></a>
            <a href="#"><div class="gw gw-3"></div></a>
            <a href="#"><div class="gw gw-4"></div></a>
            <a href="#"><div class="gw gw-5"></div></a>
        </div>
        <div class="game-wrapper left">
            <a href="#"><div class="gw gw-6"></div></a>
            <a href="#"><div class="gw gw-7"></div></a>
            <a href="#"><div class="gw gw-8"></div></a>
            <a href="#"><div class="gw gw-9"></div></a>
            <a href="#"><div class="gw gw-10"></div></a>
        </div>
    </div>

    <section class="section-2">
        <h1>Popular Games</h1>
        <div class="gaming-carousel">
            <div class="carousel-slides">
                <div class="slide" style="background-image: url('https://www.riotgames.com/darkroom/1440/d0807e131a84f2e42c7a303bda672789:3d02afa7e0bfb75f645d97467765b24c/valorant-offwhitelaunch-keyart.jpg')"></div>
                <div class="slide" style="background-image: url('https://images8.alphacoders.com/132/1329760.jpeg')"></div>
                <div class="slide" style="background-image: url('https://images6.alphacoders.com/135/thumbbig-1358385.webp')"></div>
                <div class="slide" style="background-image: url('https://wallpapers.com/images/featured/gta-5-qpjtjdxwbwrk4gyj.jpg')"></div>
            </div>
        </div>
    </section>

    <div class="section-3">
        <h1>What People say About us</h1>
        <div class="section-3-wrapper">
            <div class="feedback"></div>
            <div class="feedback-desc">
                <p>G Hub is a fantastic platform that combines sleek design with intuitive functionality. Its modern interface and responsive features make navigation effortless, offering a cool and immersive experience that keeps users coming back.</p>
                <br>
                <i class="far fa-grin-squint-tears"></i><br>
                <h4>OSCAR</h4>
            </div>
            <div class="feedback f-img-2"></div>
            <div class="feedback-desc">
                <p>G Hub stands out with its innovative approach and user-friendly design. It's not only visually appealing but also packed with smart features that enhance the overall gaming experience, making it a must-have hub for every enthusiast.!</p>
                <br>
                <i class="far fa-grin-beam-sweat"></i><br>
                <h4>MARIO</h4>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-body">
            <div class="logo footer-logo">
                <i class="fas fa-gamepad"></i>
                <h1>G-Hub</h1>
            </div>
            <ul>
                <h3>Short Links</h3>
                <li><a href="https://www.facebook.com/Zenitsu101">Git-Hub</a></li>
                <li><a href="#">War Zone</a></li>
                <li><a href="#">Fifa Game</a></li>
                <li><a href="#">Pes 2020</a></li>
                <li><a href="#">Xbox Game</a></li>
            </ul>
            <ul>
                <h3>Get In Touch</h3>
                <li><a href="https://www.facebook.com/Zenitsu101"><i class="fab fa-facebook"></i>Facebook</a></li>
                <li><a href="https://www.instagram.com/tendyboy02/"><i class="fab fa-instagram"></i>Instagram</a></li>
            </ul>
        </div>
    </footer>

    <script>
        // Toggle sidebar
        document.querySelector('.hamburger-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const hamburgerBtn = document.querySelector('.hamburger-btn');
            if (!sidebar.contains(event.target) && !hamburgerBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>
