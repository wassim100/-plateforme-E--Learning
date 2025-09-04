@extends('admin.layouts.admin')

@section('title', 'Ajouter un Quiz')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ajouter un quiz</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.quizzes.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Titre du quiz*</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description (facultatif)</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="course_id">Cours associé*</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
