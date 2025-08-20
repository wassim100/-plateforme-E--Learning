<div class="side-bar">
  <div id="close-btn"><i class="fas fa-times"></i></div>
  <div class="profile">
  <img src="{{ asset('desgin/images/pic-1.jpg') }}" class="image" alt="">
    <h3 class="name">shaikh anas</h3>
    <p class="role">student</p>
  <a href="{{ url('/profile') }}" class="btn">view profile</a>
  </div>
  <nav class="navbar">
  <a href="{{ url('/') }}"><i class="fas fa-home"></i><span>home</span></a>
  <a href="{{ url('/about') }}"><i class="fas fa-question"></i><span>about</span></a>
  <a href="{{ url('/courses') }}"><i class="fas fa-graduation-cap"></i><span>courses</span></a>
  <a href="{{ url('/teachers') }}"><i class="fas fa-chalkboard-user"></i><span>teachers</span></a>
  <a href="{{ url('/contact') }}"><i class="fas fa-headset"></i><span>contact us</span></a>
  </nav>
</div>
