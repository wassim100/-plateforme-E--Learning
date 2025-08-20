<header class="header">
  <section class="flex">
    <a href="{{ url('/admin') }}" class="logo">Educa Admin</a>
    <form class="search-form" onsubmit="return false;">
      <input type="text" placeholder="Rechercher..." maxlength="100">
      <button type="button" class="fas fa-search"></button>
    </form>
    <div class="icons">
      <div id="menu-btn" class="fas fa-bars"></div>
      <div id="search-btn" class="fas fa-search"></div>
      <div id="user-btn" class="fas fa-user"></div>
      <div id="toggle-btn" class="fas fa-sun"></div>
    </div>
    <div class="profile">
      <img src="{{ asset('desgin/images/pic-1.jpg') }}" class="image" alt="">
      <h3 class="name">Admin</h3>
      <p class="role">administrator</p>
      <a href="{{ url('/admin') }}" class="btn">Dashboard</a>
    </div>
  </section>
</header>
