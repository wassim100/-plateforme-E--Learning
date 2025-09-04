@extends('admin.layouts.admin')

@section('title', 'Gestion des Réponses')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Liste des réponses</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.answers.create') }}" class="btn btn-success">Ajouter une réponse</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Texte de la réponse</th>
                                    <th>Question</th>
                                    <th>Correcte</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($answers as $answer)
                                    <tr>
                                        <td>{{ $answer->id }}</td>
                                        <td>{{ $answer->text }}</td>
                                        <td>{{ $answer->question->text ?? 'N/A' }}</td>
                                        <td>{{ $answer->is_correct ? 'Oui' : 'Non' }}</td>
                                        <td>
                                            <a href="{{ route('admin.answers.show', $answer) }}" class="btn btn-info btn-sm">Voir</a>
                                            <a href="{{ route('admin.answers.edit', $answer) }}" class="btn btn-primary btn-sm">Modifier</a>
                                            <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" style="display:inline-block;">
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

