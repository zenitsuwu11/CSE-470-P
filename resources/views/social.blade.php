<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Social & Chat</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/social.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>

  <!-- Header -->
  <header>
    <div class="inner" style="justify-content: center; position: relative;">
      <h1><i class="fas fa-gamepad"></i> G-Hub</h1>
      <form method="POST" action="{{ route('logout') }}" style="position: absolute; right: 20px;">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </div>
  </header>

  <!-- Navigation -->
  <nav>
    <div class="inner">
      <ul>
        <li><a href="{{ route('dashboard') }}">Home</a></li>
        <li><a href="{{ route('profile.show') }}">Profile</a></li>
        <li><a href="{{ route('library') }}">Library</a></li>
        <li><a href="{{ route('gamenews.index') }}">News & Reviews</a></li>
        <li><a href="{{ route('support.create') }}">Support</a></li>
        <li><a href="{{ route('patch.index') }}">Patchupdate</a></li>
    </div>
      </ul>
    </div>
  </nav>

  <!-- Main Layout -->
  <div class="container">
    <!-- Sidebar -->
    <aside>
      <h2>Users & Requests</h2>
      <ul id="users-list">
        @php $me = auth()->user(); @endphp
        @foreach($users as $u)
          <li data-user-id="{{ $u->id }}">
            <strong>{{ $u->name }}</strong>
            @php
              $rel = \App\Models\Friendship::where(function($q) use($me, $u){
                        $q->where('requester_id', $me->id)
                          ->where('requested_id', $u->id);
                    })->orWhere(function($q) use($me, $u){
                        $q->where('requester_id', $u->id)
                          ->where('requested_id', $me->id);
                    })->first();
            @endphp

            @if(!$rel)
              <button class="btn btn-send-request" data-id="{{ $u->id }}">Send Request</button>
            @elseif($rel->status === 'pending')
              @if($rel->requester_id === $me->id)
                <span>Request Sent</span>
                <button class="btn btn-cancel-request" data-id="{{ $u->id }}">Cancel</button>
              @else
                <button class="btn btn-accept" data-id="{{ $u->id }}">Accept</button>
                <button class="btn btn-decline" data-id="{{ $u->id }}">Decline</button>
              @endif
            @else
              <button class="btn friend-item" data-id="{{ $u->id }}">Chat ▶</button>
            @endif
          </li>
        @endforeach
      </ul>
    </aside>

    <!-- Chat Area -->
    <div class="chat-area">
      <header id="chat-with" style="padding:10px; background:#34495e; border-radius: 6px; margin-bottom: 10px;">
        Select a friend to chat
      </header>
      <div id="chat-window"><em>No chat selected</em></div>
      <textarea id="chat-input" rows="2" placeholder="Type your message…"></textarea>
      <button id="send-btn" class="btn">Send</button>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    const meId = {{ auth()->id() }};
    const baseUrl = "{{ url('') }}";  
    let selectedFriend = null;

    async function post(url, data = {}) {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(data)
      });
      return res.json();
    }

    async function loadMessages() {
      if (!selectedFriend) return;
      const url = `${baseUrl}/social/chat/fetch/${selectedFriend}`;
      const res = await fetch(url);
      const msgs = await res.json();
      const win = document.getElementById('chat-window');
      win.innerHTML = msgs.map(m => `
        <div class="chat-msg ${m.from_user_id===meId?'right':'left'}">
          <div class="chat-bubble ${m.from_user_id===meId?'right':''}">${m.body}</div>
          <div class="chat-time">${new Date(m.created_at).toLocaleTimeString()}</div>
        </div>
      `).join('');
      win.scrollTop = win.scrollHeight;
    }

    document.getElementById('users-list').addEventListener('click', async e => {
      const btn = e.target.closest('button'),
            li  = btn && btn.closest('li'),
            id  = li?.dataset.userId;
      if (!btn || !id) return;

      if (btn.classList.contains('friend-item')) {
        selectedFriend = id;
        document.getElementById('chat-with').innerText = 'Chat with ' + li.querySelector('strong').innerText;
        return loadMessages();
      }

      if (btn.classList.contains('btn-send-request')) {
        await post(`${baseUrl}/social/friends/send/${id}`);
        return location.reload();
      }
      if (btn.classList.contains('btn-cancel-request')) {
        await post(`${baseUrl}/social/friends/cancel/${id}`);
        return location.reload();
      }
      if (btn.classList.contains('btn-accept')) {
        await post(`${baseUrl}/social/friends/accept/${id}`);
        return location.reload();
      }
      if (btn.classList.contains('btn-decline')) {
        await post(`${baseUrl}/social/friends/decline/${id}`);
        return location.reload();
      }
    });

    document.getElementById('send-btn').addEventListener('click', async () => {
      const body = document.getElementById('chat-input').value.trim();
      if (!body || !selectedFriend) return;
      await post(`${baseUrl}/social/chat/send/${selectedFriend}`, { body });
      document.getElementById('chat-input').value = '';
      loadMessages();
    });

    setInterval(loadMessages, 5000);
  </script>
</body>
</html>
