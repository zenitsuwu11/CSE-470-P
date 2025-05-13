<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Reviews</title>
  <link rel="stylesheet" href="{{ asset('css/review.css') }}">
</head>
<body>

  <!-- Header -->
  <div class="header">
    <div></div> <!-- Optional space for logo -->

    <div class="nav-links">
          <a href="{{ route('profile.show') }}">Profile</a>
          <a href="{{ route('library') }}">Library</a>
          <a href="{{ route('gamenews.index') }}">News & Reviews</a>
          <a href="{{ route('support.create') }}">Support</a>
          <a href="{{ route('patch.index') }}">Patchupdate</a>
          <a href="{{ route('dashboard') }}">Dashboard</a>
          <a href="{{ route('social.index') }}">Social Chat</a>
    </div>

    @auth
      <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit">Logout</button>
      </form>
    @endauth
  </div>

  <!-- Review Section -->
  <div class="review-container">
    <h2>Submit & View Reviews</h2>

    @if(session('success'))
      <p class="success-message">{{ session('success') }}</p>
    @endif

    <!-- Review Form -->
    <form action="{{ route('reviews.store') }}" method="POST" class="review-form">
      @csrf

      <label for="title">Title:</label>
      <input 
        type="text" 
        name="title" 
        id="title" 
        value="{{ old('title') }}" 
        required 
        maxlength="255"
      >

      <label for="comment">Your Review:</label>
      <textarea 
        name="comment" 
        id="comment" 
        required
      >{{ old('comment') }}</textarea>

      <label for="rating">Rating:</label>
      <select name="rating" id="rating" required>
        @for($i = 1; $i <= 5; $i++)
          <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
          </option>
        @endfor
      </select>

      <button type="submit">Submit Review</button>
    </form>
  </div>

</body>
</html>
