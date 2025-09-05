@extends('admin.layouts.admin')

@section('title', 'Ajouter une Réponse')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Ajouter une réponse</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.answers.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="text">Texte de la réponse</label>
                                <input type="text" name="text" id="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="question_id">Sélectionner la question</label>
                                <select name="question_id" id="question_id" class="form-control" required>
                                    @foreach ($questions as $question)
                                        <option value="{{ $question->id }}">{{ $question->text }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_correct">Est-ce correct ?</label>
                                <select name="is_correct" id="is_correct" class="form-control" required>
                                    <option value="1">Oui</option>
                                    <option value="0">Non</option>
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
