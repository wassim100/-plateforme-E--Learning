@extends('admin.layouts.admin')
@section('title','Catégories')
@section('content')
<section class="dashboard">
  <h1 class="heading">Catégories</h1>
  @if(session('status'))
    <p class="success" style="margin-bottom:1rem;color:var(--green);">{{ session('status') }}</p>
  @endif
  <div class="card">
    <div class="card-header header-row">
      <div class="header-left">
        <h3>Liste</h3>
        <form method="get" action="" class="a-search">
          @if(isset($perPage))<input type="hidden" name="per" value="{{ (int)$perPage }}">@endif
          <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher..." maxlength="100" aria-label="Rechercher">
          <button type="submit" class="a-btn a-btn-sm a-btn-icon" title="Rechercher" aria-label="Rechercher">
            <i class="fas fa-search"></i>
          </button>
        </form>
        <div class="toolbar-counters">
          <span class="kpi-pill total" title="Total catégories">Total: {{ $total ?? $categories->total() }}</span>
          <span class="kpi-pill ok" title="Actives">Actives: {{ $activeCount ?? 0 }}</span>
          <span class="kpi-pill no" title="Inactives">Inactives: {{ $inactiveCount ?? 0 }}</span>
        </div>
      </div>
      <div class="header-right">
        <form method="get" class="per-page">
          @if(!empty($q))<input type="hidden" name="q" value="{{ $q }}">@endif
          <label for="per" class="per-label">Par page</label>
          <select id="per" name="per" onchange="this.form.submit()">
            @foreach([10,15,20,30,50] as $opt)
              <option value="{{ $opt }}" {{ (int)($perPage ?? 15) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
          </select>
        </form>
        <a href="{{ route('admin.categories.create') }}" class="a-btn a-btn-primary">
          <i class="fas fa-plus"></i>
          <span>Nouvelle Catégorie</span>
        </a>
      </div>
    </div>
    <div class="card-body table-wrap">
      <div class="table-meta">
        @if($categories->total() > 0)
          <span>Affichage <strong>{{ $categories->firstItem() }}</strong>–<strong>{{ $categories->lastItem() }}</strong> sur <strong>{{ $categories->total() }}</strong> résultats</span>
        @else
          <span>Aucun résultat</span>
        @endif
      </div>
      <table class="table">
        <thead><tr><th style="width:80px">ID</th><th>Nom</th><th>Slug</th><th>Active</th><th class="col-actions">Actions</th></tr></thead>
        <tbody>
          @forelse($categories as $cat)
            <tr>
              <td>{{ $cat->id }}</td>
              <td>{{ $cat->name }}</td>
              <td>{{ $cat->slug }}</td>
              <td>
                @if($cat->is_active)
                  <span class="a-badge a-badge-success">Oui</span>
                @else
                  <span class="a-badge a-badge-danger">Non</span>
                @endif
              </td>
              <td class="a-actions">
                <a class="a-btn a-btn-sm" href="{{ route('admin.categories.edit',$cat) }}" title="Modifier" aria-label="Modifier">
                  <i class="fas fa-pen"></i><span class="hide-sm">&nbsp;Modifier</span>
                </a>
                <form method="post" action="{{ route('admin.categories.destroy',$cat) }}" onsubmit="return confirm('Supprimer cette catégorie ?');" style="display:inline-block;">
                  @csrf
                  @method('delete')
                  <button class="a-btn a-btn-sm a-btn-danger" title="Supprimer" aria-label="Supprimer">
                    <i class="fas fa-trash"></i><span class="hide-sm">&nbsp;Supprimer</span>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5">Aucune catégorie.</td></tr>
          @endforelse
        </tbody>
      </table>
      <div class="pagination-wrap">{{ $categories->links() }}</div>
    </div>
  </div>
</section>
@endsection
