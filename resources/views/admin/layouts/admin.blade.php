<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Admin')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('desgin/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('desgin/admin/css/admin.css') }}">
</head>
<body class="admin">
  @include('admin.partials.header')
  @include('admin.partials.sidebar')
  <main class="container">
    @yield('content')
  </main>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js" defer></script>
  <script src="{{ asset('desgin/js/script.js') }}" defer></script>
  <script src="{{ asset('desgin/admin/js/admin.js') }}" defer></script>
</body>
</html>
