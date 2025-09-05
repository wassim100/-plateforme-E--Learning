@extends('admin.layouts.admin')

@section('title', 'Ajouter une Question')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ajouter une question</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.questions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="text">Texte de la question</label>
                                <textarea name="text" id="text" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="quiz_id">Sélectionner le quiz</label>
                                <select name="quiz_id" id="quiz_id" class="form-control" required>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
