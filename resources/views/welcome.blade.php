<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Event</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f4f4f9; color: #333; }
        .navbar {
            background-color: white;
            padding: 1em 2em;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .logo { font-size: 1.5em; font-weight: bold; }
        .navbar .nav-links a { text-decoration: none; color: #555; margin-left: 1.5em; }
        .navbar .nav-links a:hover { color: #000; }
        .container { max-width: 1200px; margin: 2em auto; padding: 0 2em; }
        .hero { text-align: center; margin-bottom: 3em; }
        .hero h1 { font-size: 2.8em; margin-bottom: 0.2em; }
        .hero p { font-size: 1.2em; color: #555; }
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2em;
        }
        .event-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
            text-decoration: none;
            color: inherit;
        }
        .event-card:hover { transform: translateY(-5px); }
        .event-card-content { padding: 1.5em; }
        .event-card-content h3 { margin-top: 0; font-size: 1.4em; }
        .event-card-content p { margin: 0.5em 0; color: #555; }
        .event-card-price {
            font-size: 1.2em;
            font-weight: bold;
            color: #0d6efd;
            margin-top: 1em;
        }
        .empty-message { text-align: center; color: #777; padding: 3em; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">TiketEvent</div>
        <div class="nav-links">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    </nav>

    <div class="container">
        <div class="hero">
            <h1>Temukan Event Favoritmu</h1>
            <p>Beli tiket untuk konser, seminar, dan acara lainnya dengan mudah.</p>
        </div>

        <h2>Event Terbaru</h2>
        <div class="event-grid">
            @forelse ($events as $event)
                <a href="/event-detail/{{ $event->id }}" class="event-card">
                    <div class="event-card-content">
                        <h3>{{ $event->name }}</h3>
                        <p>{{ \Carbon\Carbon::parse($event->start_time)->format('d F Y') }}</p>
                        <p>{{ $event->location }}</p>
                        <div class="event-card-price">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </div>
                    </div>
                </a>
            @empty
                <p class="empty-message">Belum ada event yang tersedia saat ini.</p>
            @endforelse
        </div>
    </div>

</body>
</html>