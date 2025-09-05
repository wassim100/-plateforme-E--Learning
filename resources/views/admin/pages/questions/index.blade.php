@extends('admin.layouts.admin')
@section('title', 'Questions')
@section('content')
<section class="courses-table">
    <h1 class="heading">Questions</h1>
        <div class="header-row">
            <div class="header-left">
                <form action="{{ route('admin.questions.index') }}" method="GET" class="a-search">
                    <input type="text" name="q" value="{{ request('q','') }}" placeholder="Rechercher par texte">
                    <button type="submit" class="a-btn">Chercher</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.questions.index') }}" class="a-btn">Réinitialiser</a>
                    @endif
                </form>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.questions.create') }}" class="a-btn a-btn-primary">Ajouter une question</a>
            </div>
        </div>
        <div class="table-container">
                <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Texte</th>
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
                                    <td class="actions">
                                        <a href="{{ route('admin.questions.show', $question) }}" class="btn">Voir</a>
                                        <a href="{{ route('admin.questions.edit', $question) }}" class="option-btn">Modifier</a>
                                        <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cette question ?');">
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

