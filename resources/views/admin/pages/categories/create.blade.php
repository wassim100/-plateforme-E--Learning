@extends('admin.layouts.admin')
@section('title','Créer catégorie')
@section('content')
<section class="dashboard">
  <h1 class="heading">Créer une catégorie</h1>
  <div class="card"><div class="card-body">
    <form method="post" action="{{ route('admin.categories.store') }}" class="form form-vertical">
      @csrf
      <div class="box"><label>Nom</label><input type="text" name="name" value="{{ old('name') }}" required>@error('name')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box"><label>Slug</label><input type="text" name="slug" value="{{ old('slug') }}" required>@error('slug')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box"><label>Description</label><textarea name="description" rows="4">{{ old('description') }}</textarea>@error('description')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box switch"><input type="checkbox" id="is_active_create" name="is_active" value="1" {{ old('is_active',1)?'checked':'' }}> <label for="is_active_create">Active</label></div>
  <div class="box actions"><button class="a-btn a-btn-primary a-btn-sm">Enregistrer</button><a href="{{ route('admin.categories.index') }}" class="a-btn a-btn-sm">Annuler</a></div>
    </form>
  </div></div>
</section>
@endsection
