<header class="header">
  <section class="flex">
    <a href="{{ url('/') }}" class="logo">Educa</a>

    <form action="{{ url('/search') }}" class="search-form">
      <input type="text" name="q" placeholder="search courses..." maxlength="100">
      <button type="submit" class="fas fa-search"></button>
    </form>

    <nav class="main-nav">
      <a href="{{ url('/') }}">home</a>
      <a href="{{ url('/categories') }}">categorie</a>
      <a href="{{ url('/courses') }}">courses</a>
      <a href="{{ url('/about') }}">about</a>
      <a href="{{ url('/contact') }}">contact us</a>
    </nav>

    <div class="auth-actions">
      @auth
        <span class="welcome">{{ Auth::user()->name }}</span>
        <a href="{{ route('profile.show') }}" class="inline-btn">Profil</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button class="inline-delete-btn" style="margin-left:.5rem;">Déconnexion</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="option-btn">Connexion</a>
        <a href="{{ route('register') }}" class="btn" style="margin-left:.5rem;">S'inscrire</a>
      @endauth
    </div>

    <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
    </div>
  </section>
</header>
