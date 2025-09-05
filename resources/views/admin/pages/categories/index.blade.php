@extends('admin.layouts.admin')
@section('title','Catégories')
@section('content')
<section class="courses-table">
  <h1 class="heading">Catégories</h1>
  @if(session('status'))
    <p class="success" style="margin-bottom:1rem;color:var(--green);">{{ session('status') }}</p>
  @endif

  <div class="header-row">
    <div class="header-left">
      <form method="get" action="{{ route('admin.categories.index') }}" class="a-search">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher par nom" maxlength="100" aria-label="Rechercher">
        <button type="submit" class="a-btn">Chercher</button>
        @if(!empty($q))
          <a href="{{ route('admin.categories.index') }}" class="a-btn">Réinitialiser</a>
        @endif
      </form>
    </div>
    <div class="header-right">
      <a href="{{ route('admin.categories.create') }}" class="a-btn a-btn-primary">Ajouter une catégorie</a>
    </div>
  </div>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($categories as $cat)
          <tr>
            <td>{{ $cat->id }}</td>
            <td>{{ $cat->name }}</td>
            <td class="actions">
              <a class="option-btn" href="{{ route('admin.categories.edit',$cat) }}">Modifier</a>
              <form method="post" action="{{ route('admin.categories.destroy',$cat) }}" onsubmit="return confirm('Supprimer cette catégorie ?');" style="display:inline-block;">
                @csrf
                @method('delete')
                <button class="delete-btn">Supprimer</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3">Aucune catégorie.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if(method_exists($categories,'links'))
    <div class="pagination-wrap">{{ $categories->links() }}</div>
  @endif
</section>
@endsection
