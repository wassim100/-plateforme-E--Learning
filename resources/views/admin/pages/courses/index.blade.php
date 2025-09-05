@extends('admin.layouts.admin')
@section('title','Courses')
@section('content')
<section class="courses-table">
    <h1 class="heading">Liste Des Cours</h1>
    <div class="header-row">
        <div class="header-left">
            <form action="{{ route('admin.courses.index') }}" method="GET" class="a-search">
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher par nom de cours">
                <button type="submit" class="a-btn">Chercher</button>
                @if(($q ?? '') !== '')
                    <a href="{{ route('admin.courses.index') }}" class="a-btn">Réinitialiser</a>
                @endif
            </form>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.courses.create') }}" class="a-btn a-btn-primary">Ajouter un cours</a>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Nom du cours</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>
                            @if($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" style="width: 100px; height: auto; object-fit: cover; border-radius: 5px;">
                            @else
                            <span>Pas d'image</span>
                            @endif
                        </td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->price ? $course->price . ' €' : 'Gratuit' }}</td>
                        <td>{{ $course->category->name }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn">Voir</a>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="option-btn">Modifier</a>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Aucun cours trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection

