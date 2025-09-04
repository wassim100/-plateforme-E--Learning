@extends('admin.layouts.admin')

@section('title', 'Modifier le Quiz')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Modifier le quiz</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Titre du quiz*</label>
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $quiz->title) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description (facultatif)</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $quiz->description) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="course_id">Cours associé*</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ $quiz->course_id == $course->id ? 'selected' : '' }}>
                                            {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour le quiz</button>
                            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
