@extends('front.layouts.front')
@section('title','Profile')
@section('content')
@extends('front.layouts.front')
@section('title','Profil')
@section('content')
<section class="profile">

   <h1 class="heading">Détails du profil</h1>

   <div class="details">

      <div class="user">
         <img src="{{ asset('desgin/images/pic-1.jpg') }}" alt="">
         <h3>{{ $user->name }}</h3>
         <p>{{ $user->role }}</p>
         <a href="#" class="inline-btn">Mettre à jour le profil</a>
      </div>

      <div class="box-container">

         <div class="box">
            <div class="flex">
               <i class="fas fa-bookmark"></i>
               <div>
                  <span>{{ $user->enrollments->count() }}</span>
                  <p>Cours inscrits</p>
               </div>
            </div>
            <a href="#" class="inline-btn">Voir les cours</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-heart"></i>
               <div>
                  <span>33</span>
                  <p>likes</p>
               </div>
            </div>
            <a href="#" class="inline-btn">view liked</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <span>12</span>
                  <p>comments</p>
               </div>
            </div>
            <a href="#" class="inline-btn">view comments</a>
         </div>

      </div>

   </div>

</section>
@endsection

@endsection
