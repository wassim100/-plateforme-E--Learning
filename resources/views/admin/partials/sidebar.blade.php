<div class="side-bar">
  <div id="close-btn"><i class="fas fa-times"></i></div>
  <div class="profile">
  <img src="{{ asset('desgin/images/pic-1.jpg') }}" class="image" alt="">
    <h3 class="name">Admin</h3>
    <p class="role">administrator</p>
  <a href="{{ url('/admin') }}" class="btn">Dashboard</a>
  </div>
  <nav class="navbar">
  <a href="{{ url('/admin') }}"><i class="fas fa-gauge"></i><span>Dashboard</span></a>
  <a href="{{ url('/admin/users') }}"><i class="fas fa-users"></i><span>Utilisateurs</span></a>
  <a href="{{ url('/admin/categories') }}"><i class="fas fa-layer-group"></i><span>Catégories</span></a>
  <a href="{{ url('/admin/courses') }}"><i class="fas fa-book"></i><span>Courses</span></a>
  <a href="{{ url('/admin/enrollments') }}"><i class="fas fa-ticket"></i><span>Enrollments</span></a>
  <a href="{{ url('/admin/quizzes') }}"><i class="fas fa-question"></i><span>Quizzes</span></a>
  <a href="{{ url('/admin/questions') }}"><i class="fas fa-list"></i><span>Questions</span></a>
  <a href="{{ url('/admin/answers') }}"><i class="fas fa-check"></i><span>Réponses</span></a>
  <a href="{{ url('/') }}"><i class="fas fa-globe"></i><span>Site (Front)</span></a>
  </nav>
</div>
