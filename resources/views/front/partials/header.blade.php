<header class="header">
  <section class="flex">
    <a href="{{ url('/') }}" class="logo">Educa</a>
    <form action="{{ url('/search') }}" class="search-form">
      <input type="text" name="q" placeholder="search courses..." maxlength="100">
      <button type="submit" class="fas fa-search"></button>
    </form>
    <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="search-btn" class="fas fa-search"></div>
      <div id="user-btn" class="fas fa-user"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
    </div>
    <div class="profile">
      <img src="{{ asset('desgin/images/pic-1.jpg') }}" class="image" alt="">
      <h3 class="name">shaikh anas</h3>
      <p class="role">student</p>
      <a href="{{ url('/profile') }}" class="btn">view profile</a>
    </div>
  </section>
</header>
