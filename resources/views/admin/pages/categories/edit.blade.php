@extends('admin.layouts.admin')
@section('title','Éditer catégorie')
@section('content')
<section class="dashboard">
  <h1 class="heading">Éditer la catégorie</h1>
  <div class="card"><div class="card-body">
    <form method="post" action="{{ route('admin.categories.update',$category) }}" class="form form-vertical">
      @csrf @method('PUT')
      <div class="box"><label>Nom</label><input type="text" name="name" value="{{ old('name',$category->name) }}" required>@error('name')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box"><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$category->slug) }}" required>@error('slug')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box"><label>Description</label><textarea name="description" rows="4">{{ old('description',$category->description) }}</textarea>@error('description')<small class="error">{{ $message }}</small>@enderror</div>
      <div class="box switch"><input type="checkbox" id="is_active_edit" name="is_active" value="1" {{ old('is_active',$category->is_active)?'checked':'' }}> <label for="is_active_edit">Active</label></div>
  <div class="box actions"><button class="a-btn a-btn-primary a-btn-sm">Mettre à jour</button><a href="{{ route('admin.categories.index') }}" class="a-btn a-btn-sm">Annuler</a></div>
    </form>
  </div></div>
</section>
@endsection
