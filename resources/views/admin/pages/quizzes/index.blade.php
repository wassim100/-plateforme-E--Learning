@extends('admin.layouts.admin')

@section('title', 'Gestion des Quizzes')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Liste des quizzes</h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-success">Ajouter un quiz</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Cours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->id }}</td>
                                        <td>{{ $quiz->title }}</td>
                                        <td>{{ $quiz->course->title ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn btn-info btn-sm">Voir</a>
                                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="btn btn-primary btn-sm">Modifier</a>
                                            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" style="display:inline-block;">
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
