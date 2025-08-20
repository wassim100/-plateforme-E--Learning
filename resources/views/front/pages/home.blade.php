@extends('front.layouts.front')
@section('title','Home')
@section('content')
<section class="home-grid">
  <h1 class="heading">Quick options</h1>
  <div class="box-container">
    <div class="box">
      <h3 class="title">likes & comments</h3>
      <p>total likes on your videos</p>
      <a href="#" class="inline-btn">view likes</a>
      <p>total comments on your videos</p>
      <a href="#" class="inline-btn">view comments</a>
      <p>total views on your videos</p>
      <a href="#" class="inline-btn">view views</a>
    </div>
  </div>
</section>
@endsection
