@extends('admin.layouts.admin')
@section('title','Inscrire un Étudiant')
@section('content')
<section class="form-container">
    <h1 class="heading">Inscrire un Étudiant à un Cours</h1>
    <form action="{{ route('admin.enrollments.store') }}" method="POST">
        @csrf
        <p>Étudiant<span>*</span></p>
        <select name="user_id" class="box" required>
            <option value="" disabled selected>-- Choisir un étudiant --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>

        <p>Cours<span>*</span></p>
        <select name="course_id" class="box" required>
            <option value="" disabled selected>-- Choisir un cours --</option>
            @foreach ($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>

        <input type="submit" value="Inscrire" name="submit" class="btn">
    </form>
</section>
@endsection
