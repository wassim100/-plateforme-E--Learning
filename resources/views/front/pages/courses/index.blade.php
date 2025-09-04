@extends('front.layouts.front')
@section('title','Courses')
@section('content')
<section class="courses">
  <h1 class="heading">Courses @if($activeCategory) — {{ $activeCategory->name }} @endif</h1>

  @if(isset($courses) && $courses->count())
  <div class="box-container">
    @foreach ($courses as $course)
      <div class="box">
        <div class="tutor">
          <img src="{{ asset('desgin/images/pic-1.jpg') }}" alt="">
          <div>
            <h3>{{ $course->category?->name ?? 'Sans catégorie' }}</h3>
            <span>Catégorie</span>
          </div>
        </div>
        <div class="thumb">
          <span>{{ $course->quizzes()->count() }} quiz</span>
          <img src="{{ $course->image ? asset('storage/'.$course->image) : asset('desgin/images/thumb-1.png') }}" alt="{{ $course->title }}">
        </div>
        <h3 class="title">{{ $course->title }}</h3>
        <a href="#" class="inline-btn">voir le cours</a>
      </div>
    @endforeach
  </div>

  <div style="margin-top:2rem;">{{ $courses->links() }}</div>
  @else
    <div class="box"><p>Aucun cours trouvé.</p></div>
  @endif
</section>
@endsection
