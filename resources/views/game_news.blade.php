<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game News</title>
  <link rel="stylesheet" href="{{ asset('css/gamenews.css') }}">
  <style>
    /* Simple star styling */
    .stars {
      color: #f1c40f;
      font-size: 1.2em;
    }
  </style>
</head>
<body>

  <button class="hamburger" onclick="toggleSidebar()">☰</button>

  <div class="sidebar" id="sidebar">
    <h2>G-Hub</h2>
    <nav>
        <ul>
            <a href="{{ route('profile.show') }}">Profile</a>
            <a href="{{ route('library') }}">Library</a>
            <a href="{{ route('support.create') }}">Support</a>
            <a href="{{ route('reviews.index') }}">Submit Reviews</a>
            <a href="{{ route('patch.index') }}">Patchupdate</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </ul>
    </nav>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit">Logout</button>
    </form>
  </div>

  <div class="main-content" id="main">
    <h1>Latest Game News</h1>

    <!-- News Carousel -->
    <div class="news-container" id="news-container">
      @foreach($newsItems as $news)
        <div class="news-card">
          <h2>{{ $news->title }}</h2>
          <p><strong>{{ $news->game->name ?? 'Unknown Game' }}</strong></p>
          <p>{{ $news->content }}</p>
          <p><em>{{ $news->release_date 
              ? \Carbon\Carbon::parse($news->release_date)->diffForHumans() 
              : '' }}
          </em></p>
        </div>
      @endforeach
    </div>

    <!-- News Pagination -->
    <div class="pagination">
      {{ $newsItems->links() }}
    </div>

    <!-- Reviews Section (Independent) -->
    <h1>User Reviews</h1>
    <div class="reviews-container" id="reviews-container">
      @forelse($reviews as $review)
        <div class="review-card">
          <!-- Show the review title -->
          <h3>{{ $review->title }}</h3>

          <!-- Render stars -->
          <div class="stars">
            @for($i = 1; $i <= 5; $i++)
              {!! $i <= $review->rating ? '★' : '☆' !!}
            @endfor
          </div>

          <!-- Reviewer name -->
          <p><strong>{{ $review->user->name }}</strong></p>
          <p>{{ $review->comment }}</p>
          <p><em>{{ $review->created_at->diffForHumans() }}</em></p>
        </div>
      @empty
        <p>No reviews available.</p>
      @endforelse
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('hidden');
      document.getElementById('main').classList.toggle('expanded');
    }

    // Auto-scroll for news
    let nIdx = 0,
        nCon = document.getElementById('news-container'),
        nCards = document.querySelectorAll('.news-card');
    setInterval(() => {
      if (!nCards.length) return;
      if (nIdx >= nCards.length) { nIdx = 0; nCon.scrollLeft = 0; }
      nCon.scrollBy({ left: nCards[nIdx].offsetWidth + 10, behavior: 'smooth' });
      nIdx++;
    }, 5000);

    // Auto-scroll for reviews
    let rIdx = 0,
        rCon = document.getElementById('reviews-container'),
        rCards = document.querySelectorAll('.review-card');
    setInterval(() => {
      if (!rCards.length) return;
      if (rIdx >= rCards.length) { rIdx = 0; rCon.scrollLeft = 0; }
      rCon.scrollBy({ left: rCards[rIdx].offsetWidth + 10, behavior: 'smooth' });
      rIdx++;
    }, 5000);
  </script>

</body>
</html>
