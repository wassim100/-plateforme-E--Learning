@extends('front.layouts.front')
@section('title','Courses')
@section('content')
<section class="courses">
  <div class="courses-header">
    <h1 class="heading">Courses @isset($activeCategory) — {{ $activeCategory->name }} @endisset</h1>
  </div>

  <div class="courses-layout">
  <aside class="filters" id="filters-panel">
      <h3>Filter by</h3>
      <form method="GET" action="{{ route('front.courses.index') }}">
        <div class="filter-group">
          <div class="filter-group-header">Category</div>
          <div class="filter-options">
            @php $selected = (int)request('category'); @endphp
            @foreach (($allCategories ?? []) as $cat)
              <label class="filter-option">
                <input type="radio" name="category" value="{{ $cat->id }}" {{ $selected === $cat->id ? 'checked' : '' }}>
                <span>{{ $cat->name }}</span>
              </label>
            @endforeach
          </div>
        </div>
        <div class="filter-actions">
          <button type="submit" class="inline-btn">Apply</button>
          <a class="inline-btn light" href="{{ route('front.courses.index') }}">Clear</a>
        </div>
      </form>
    </aside>

    @if(isset($courses) && $courses->count())
    <div class="box-container">
    @foreach ($courses as $course)
      <div class="box">
        <div class="tutor">
          <img src="{{ asset('desgin/images/pic-1.jpg') }}" alt="">
          <div>
            <h3>{{ $course->category?->name ?? 'No category' }}</h3>
            <span>Category</span>
          </div>
        </div>
        <div class="thumb">
          <span>{{ $course->quizzes_count ?? $course->quizzes()->count() }} quiz</span>
          <img src="{{ $course->image ? asset('storage/'.$course->image) : asset('desgin/images/thumb-1.png') }}" alt="{{ $course->title }}">
        </div>
        <h3 class="title">{{ $course->title }}</h3>
        <a href="#" class="inline-btn">View Course</a>
      </div>
    @endforeach
    </div>

  @if (method_exists($courses, 'links'))
    <div style="margin-top:2rem;">{{ $courses->links() }}</div>
  @endif
  @else
    <div class="box"><p>No courses found.</p></div>
  @endif
  </div> <!-- /.courses-layout -->
</section>
@endsection
