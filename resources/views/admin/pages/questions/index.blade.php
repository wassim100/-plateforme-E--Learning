@extends('admin.layouts.admin')

@section('title', 'Gestion des Questions')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Liste des questions</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.questions.create') }}" class="btn btn-success">Ajouter une question</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Texte de la question</th>
                                    <th>Quiz</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $question)
                                    <tr>
                                        <td>{{ $question->id }}</td>
                                        <td>{{ $question->text }}</td>
                                        <td>{{ $question->quiz->title ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.questions.show', $question) }}" class="btn btn-info btn-sm">Voir</a>
                                            <a href="{{ route('admin.questions.edit', $question) }}" class="btn btn-primary btn-sm">Modifier</a>
                                            <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

