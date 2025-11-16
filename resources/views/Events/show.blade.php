<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $event->name }}</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f9f9f9; }
        .container { max-width: 800px; margin: 2em auto; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { padding: 2em; border-bottom: 1px solid #ddd; }
        .header h1 { margin: 0; font-size: 2.5em; }
        .header p { margin: 0.5em 0 0; font-size: 1.2em; color: #555; }
        .content { padding: 2em; }
        .content h3 { border-bottom: 1px solid #eee; padding-bottom: 0.5em; }
        .content p { line-height: 1.6; }
        .buy-button {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 1em 2em;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 1.5em;
            text-align: center;
            border: none;
            cursor: pointer;
            font-size: 1em;
        }
        .form-group { margin-top: 1.5em; }
        .form-group label { display: block; margin-bottom: 0.5em; font-weight: bold; }
        .form-group input { width: 80px; padding: 0.5em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $event->name }}</h1>
            <p><strong>Lokasi:</strong> {{ $event->location }}</p>
            <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="content">
            <h3>Deskripsi Event</h3>
            <p style="white-space: pre-wrap;">{{ $event->description }}</p>

            <h3>Tiket</h3>
            <p><strong>Harga:</strong> Rp {{ number_format($event->price, 0, ',', '.') }}</p>
            <p><strong>Sisa Kuota:</strong> {{ $event->ticket_quota }} tiket</p>

            <form action="/booking/{{ $event->id }}" method="POST">
                @csrf <!-- Token keamanan Laravel -->

                <div class="form-group">
                    <label for="quantity">Jumlah Tiket:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $event->ticket_quota }}">
                </div>

                <button type="submit" class="buy-button">Beli Tiket Sekarang</button>
            </form>

        </div>
    </div>
</body>
</html>