@extends('admin.layouts.admin')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Cours</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Liste des Cours</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Modifier le Cours</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

    <div class="card" style="max-width: 820px; margin: 0 auto;">
            <div class="card-body">
                <h5 class="card-title">Modifier le Cours</h5>
                <hr/>
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="form-vertical">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Nom du cours *</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $course->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="6" style="resize: vertical; min-height: 120px;">{{ $course->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ $course->price }}" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie *</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if($course->image)
                            <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="img-thumbnail mt-2" style="width: 150px;">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
@endsection
