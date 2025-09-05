@extends('admin.layouts.admin')

@section('title', 'Modifier la Réponse')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Modifier la réponse</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.answers.update', $answer) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="text">Texte de la réponse</label>
                                <input type="text" name="text" id="text" class="form-control" value="{{ old('text', $answer->text) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="question_id">Sélectionner la question</label>
                                <select name="question_id" id="question_id" class="form-control" required>
                                    @foreach ($questions as $question)
                                        <option value="{{ $question->id }}" {{ $answer->question_id == $question->id ? 'selected' : '' }}>
                                            {{ $question->text }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_correct">Est-ce correct ?</label>
                                <select name="is_correct" id="is_correct" class="form-control" required>
                                    <option value="1" {{ $answer->is_correct ? 'selected' : '' }}>Oui</option>
                                    <option value="0" {{ !$answer->is_correct ? 'selected' : '' }}>Non</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Enregistrer</button>
                            <a href="{{ route('admin.answers.index') }}" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
