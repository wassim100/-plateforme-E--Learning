@extends('admin.layouts.admin')

@section('admin')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Réponse</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.answers.index') }}">Liste des Réponses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Détails de la Réponse</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Détails de la Réponse</h5>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Texte de la réponse:</label>
                            <p>{{ $answer->answer_text }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Question Associée:</label>
                            <p>{{ $answer->question->question_text }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Est correcte:</label>
                            <p>{{ $answer->is_correct ? 'Oui' : 'Non' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Créée le:</label>
                            <p>{{ $answer->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mise à jour le:</label>
                            <p>{{ $answer->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.answers.index') }}" class="btn btn-secondary">Retour</a>
                </div>
            </div>
        </div>

    </div>
@endsection
