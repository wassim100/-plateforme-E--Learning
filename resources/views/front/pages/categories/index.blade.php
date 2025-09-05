@extends('front.layouts.front')
@section('title','Catégories')

@section('content')
<section class="courses">
   <h1 class="heading">Catégories</h1>
   <div class="box-container">
      @forelse($categories as $cat)
         <div class="box">
            <h3 class="title">{{ $cat->name }}</h3>
            <p style="color: var(--light-color); margin: .5rem 0 1rem;">{{ Str::limit($cat->description, 90) }}</p>
            <div class="flex" style="justify-content: space-between; align-items: center;">
               <span>{{ $cat->courses_count }} cours</span>
               <a href="{{ url('/courses?category='.$cat->id) }}" class="inline-btn">Voir</a>
            </div>
         </div>
      @empty
         <div class="box">
            <p>Aucune catégorie disponible.</p>
         </div>
      @endforelse
   </div>
</section>
@endsection
