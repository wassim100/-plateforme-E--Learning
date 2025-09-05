@extends('front.layouts.front')
@section('title','Home')
@section('content')
<section class="hero">
  <div class="hero-inner">
    <div class="content">
      <h1>Learn online from anywhere</h1>
      <p>Explore our courses and unleash your potential today!</p>
      <div class="actions">
        <a href="{{ route('front.courses.index') }}" class="btn">Browse Courses</a>
        <a href="{{ route('register') }}" class="option-btn">Join For Free</a>
      </div>
      <div class="features">
        <div class="feature"><i class="fas fa-video"></i><span>1000+ video lessons</span></div>
        <div class="feature"><i class="fas fa-chalkboard-teacher"></i><span>Expert instructors</span></div>
        <div class="feature"><i class="fas fa-mobile-alt"></i><span>Learn at your pace</span></div>
      </div>
    </div>
    <div class="illustration">
      <img src="{{ asset('desgin/images/student4.png') }}"
           alt="Learning illustration"
           data-fallback="{{ asset('desgin/images/hero-illustration.png') }}"
           onerror="this.onerror=null;this.src=this.dataset.fallback;">
    </div>
  </div>
</section>
<section class="popular-courses">
  <h2 class="heading">Popular Courses</h2>
  <div class="course-cards">
    <article class="course-card">
      <img src="{{ asset('desgin/images/thumb-1.png') }}" alt="Course 1">
      <h3>Web Development Basics</h3>
      <p>Start building modern websites using HTML, CSS, and JavaScript.</p>
      <a href="{{ url('/courses') }}" class="inline-btn">View More</a>
    </article>
    <article class="course-card">
      <img src="{{ asset('desgin/images/thumb-2.png') }}" alt="Course 2">
      <h3>Mastering Python</h3>
      <p>Learn Python from scratch and create real-world applications.</p>
      <a href="{{ url('/courses') }}" class="inline-btn">View More</a>
    </article>
    <article class="course-card">
      <img src="{{ asset('desgin/images/thumb-3.png') }}" alt="Course 3">
      <h3>UI/UX Design Fundamentals</h3>
      <p>Create delightful user experiences with design best practices.</p>
      <a href="{{ url('/courses') }}" class="inline-btn">View More</a>
    </article>
    <article class="course-card">
      <img src="{{ asset('desgin/images/thumb-4.png') }}" alt="Course 4">
      <h3>Data Analysis with Excel</h3>
      <p>Analyze and visualize data with Excel techniques and tips.</p>
      <a href="{{ url('/courses') }}" class="inline-btn">View More</a>
    </article>
  </div>
</section>

<section class="testimonials">
  <h2 class="heading">Student Testimonials</h2>
  <div class="testimonials-grid">
    <figure class="testimonial">
      <img src="{{ asset('desgin/images/pic-1.jpg') }}" alt="Student 1" class="avatar">
      <figcaption>
        <h4>Alex Morgan</h4>
        <p>“The courses are clear and practical. I landed my first internship thanks to these lessons.”</p>
      </figcaption>
    </figure>
    <figure class="testimonial">
      <img src="{{ asset('desgin/images/pic-2.jpg') }}" alt="Student 2" class="avatar">
      <figcaption>
        <h4>Sara Kim</h4>
        <p>“Great instructors and a friendly community. The projects helped me build a strong portfolio.”</p>
      </figcaption>
    </figure>
    <figure class="testimonial">
      <img src="{{ asset('desgin/images/pic-3.jpg') }}" alt="Student 3" class="avatar">
      <figcaption>
        <h4>Daniel Rivera</h4>
        <p>“Flexible learning from anywhere. The Python course was exactly what I needed.”</p>
      </figcaption>
    </figure>
  </div>
</section>
@endsection
