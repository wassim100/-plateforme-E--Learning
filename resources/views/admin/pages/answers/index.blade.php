@extends('admin.layouts.admin')
@section('title', 'Réponses')
@section('content')
<section class="courses-table">
    <h1 class="heading">Réponses</h1>
        <div class="header-row">
            <div class="header-left">
                <form action="{{ route('admin.answers.index') }}" method="GET" class="a-search">
                    <input type="text" name="q" value="{{ request('q','') }}" placeholder="Rechercher par texte">
                    <button type="submit" class="a-btn">Chercher</button>
                    @if(request()->filled('q'))
                        <a href="{{ route('admin.answers.index') }}" class="a-btn">Réinitialiser</a>
                    @endif
                </form>
            </div>
            <div class="header-right">
                <a href="{{ route('admin.answers.create') }}" class="a-btn a-btn-primary">Ajouter une réponse</a>
            </div>
        </div>
        <div class="table-container">
                <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Texte</th>
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
                                    <td class="actions">
                                        <a href="{{ route('admin.answers.show', $answer) }}" class="btn">Voir</a>
                                        <a href="{{ route('admin.answers.edit', $answer) }}" class="option-btn">Modifier</a>
                                        <form action="{{ route('admin.answers.destroy', $answer) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cette réponse ?');">
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

