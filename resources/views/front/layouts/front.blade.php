<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Educa')</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('desgin/css/style.css') }}">
</head>
<body class="@yield('body_class')">
  @include('front.partials.header')
  @include('front.partials.sidebar')
  <main class="container">
    @yield('content')
  </main>
  @include('front.partials.footer')
  <script src="{{ asset('desgin/js/script.js') }}" defer></script>
</body>
</html>
