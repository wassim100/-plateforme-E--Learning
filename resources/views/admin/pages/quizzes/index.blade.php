@extends('admin.layouts.admin')
@section('title', 'Quizzes')
@section('content')
<section class="courses-table">
    <h1 class="heading">Quizzes</h1>
        <div class="header-row">
            <div class="header-left">
                <form action="{{ route('admin.quizzes.index') }}" method="GET" class="a-search">
                    <input type="text" name="q" value="{{ request('q','') }}" placeholder="Rechercher par titre">
                    <button type="submit" class="a-btn">Chercher</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.quizzes.index') }}" class="a-btn">Réinitialiser</a>
                    @endif
                </form>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.quizzes.create') }}" class="a-btn a-btn-primary">Ajouter un quiz</a>
            </div>
        </div>
        <div class="table-container">
                <table>
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
                                    <td class="actions">
                                        <a href="{{ route('admin.quizzes.show', $quiz) }}" class="btn">Voir</a>
                                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="option-btn">Modifier</a>
                                        <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer ce quiz ?');">
                                @csrf
                                @method('DELETE')
                                            <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
