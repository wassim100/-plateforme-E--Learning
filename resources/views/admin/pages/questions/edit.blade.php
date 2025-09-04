@extends('admin.layouts.admin')

@section('title', 'Modifier la Question')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Modifier la question</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.questions.update', $question) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="text">Texte de la question</label>
                                <textarea name="text" id="text" class="form-control" required>{{ old('text', $question->text) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="quiz_id">Sélectionner le quiz</label>
                                <select name="quiz_id" id="quiz_id" class="form-control" required>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}" {{ $question->quiz_id == $quiz->id ? 'selected' : '' }}>
                                            {{ $quiz->title }}
                                        </option>
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
