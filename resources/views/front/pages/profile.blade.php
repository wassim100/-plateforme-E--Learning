@extends('front.layouts.front')
@section('title','Profile')
@section('content')
<section class="profile">
   <h1 class="heading">Profile Details</h1>
   <div class="details">
      <div class="user">
         <img src="{{ asset('desgin/images/pic-1.jpg') }}" alt="User avatar">
         <h3>{{ $user->name }}</h3>
         <p>{{ $user->role }}</p>
         <a href="#" class="inline-btn">Update Profile</a>
      </div>

      <div class="box-container">
         <div class="box">
            <div class="flex">
               <i class="fas fa-bookmark"></i>
               <div>
                  <span>{{ $user->enrollments->count() }}</span>
                  <p>Enrolled courses</p>
               </div>
            </div>
            <a href="{{ url('/courses') }}" class="inline-btn">View Courses</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-heart"></i>
               <div>
                  <span>33</span>
                  <p>Likes</p>
               </div>
            </div>
            <a href="#" class="inline-btn">View Liked</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <span>12</span>
                  <p>Comments</p>
               </div>
            </div>
            <a href="#" class="inline-btn">View Comments</a>
         </div>
      </div>
   </div>
</section>
@endsection
