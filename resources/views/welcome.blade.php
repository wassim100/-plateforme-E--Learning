<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome</title>
  {{-- Use Vite if available (harmless if not running) --}}
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
      @vite(['resources/css/app.css','resources/js/app.js'])
  @endif
  <style>
    html,body{height:100%}
    body{margin:0;display:flex;align-items:center;justify-content:center;background:#fdfdfc;color:#1b1b18;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif}
    .card{padding:2rem 2.5rem;border:1px solid #e3e3e0;border-radius:.75rem;background:#fff;box-shadow:0 1px 2px rgba(0,0,0,.06)}
    .card h1{font-size:1.6rem;margin:0 0 .5rem}
    .card p{margin:0;color:#706f6c}
  </style>
</head>
<body>
  <div class="card">
    <h1>Laravel</h1>
    <p>This is a minimal welcome page. Your real home is at route('/').</p>
  </div>
</body>
</html>