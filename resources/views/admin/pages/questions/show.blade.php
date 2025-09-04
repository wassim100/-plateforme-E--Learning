@extends('admin.layouts.admin')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Question</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.questions.index') }}">Liste des Questions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails de la Question</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Détails de la Question</h5>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Texte de la question:</label>
                            <p>{{ $question->question_text }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quiz Associé:</label>
                            <p>{{ $question->quiz->title }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Créée le:</label>
                            <p>{{ $question->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mise à jour le:</label>
                            <p>{{ $question->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>

    </div>
@endsection
