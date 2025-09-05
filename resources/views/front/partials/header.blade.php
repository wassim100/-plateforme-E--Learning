<header class="header">
  <section class="flex">
    <a href="{{ url('/') }}" class="logo">
  <img src="{{ asset('desgin/images/logo.png') }}"
       alt="EducA" class="logo-img"
       data-fallback="{{ asset('desgin/images/about-img.svg') }}"
       onerror="this.onerror=null;this.src=this.dataset.fallback;">
    </a>

    <form action="{{ url('/search') }}" class="search-form">
      <input type="text" name="q" placeholder="search courses..." maxlength="100">
      <button type="submit" class="fas fa-search"></button>
    </form>

    <nav class="main-nav">
  <a href="{{ url('/') }}">Home</a>
  <a href="{{ url('/courses') }}">Courses</a>
  <a href="{{ url('/about') }}">About</a>
  <a href="{{ url('/contact') }}">Contact</a>
    </nav>


    <div class="icons">
      <div id="menu-btn" class="fas fa-bars" role="button" aria-haspopup="true" aria-controls="user-menu" aria-expanded="false" tabindex="0"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
    </div>
    <div class="profile" id="user-menu" role="menu" aria-hidden="true">
      @auth
        <div class="name" style="margin-bottom:.5rem;">{{ Auth::user()->name }}</div>
        <a href="{{ route('profile.show') }}" class="btn" role="menuitem">Profile</a>
        <a href="{{ url('/courses') }}" class="option-btn" role="menuitem">My Courses</a>
        <a href="{{ route('profile.show') }}" class="option-btn" role="menuitem">Settings</a>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:.5rem;">
          @csrf
          <button class="delete-btn" type="submit" role="menuitem">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="option-btn" role="menuitem">Login</a>
        <a href="{{ route('register') }}" class="btn" role="menuitem" style="margin-top:.5rem;">Sign Up</a>
      @endauth
    </div>
  </section>
</header>
