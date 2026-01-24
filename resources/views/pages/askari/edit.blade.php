@extends('layouts.admin')

@section('title', 'Edit Askari')

@section('content')
<div class="container py-4">
    <a href="{{ route('askari.index') }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Back
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Edit Askari: {{ $askari->MagacaQofka }}
        </div>
        <div class="card-body">
            <form action="{{ route('askari.update', $askari->AskariId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Magaca Qofka *</label>
                        <input type="text" name="MagacaQofka" class="form-control" value="{{ old('MagacaQofka', $askari->MagacaQofka) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Lambarka Ciidanka *</label>
                        <input type="text" name="LamabrkaCiidanka" class="form-control" value="{{ old('LamabrkaCiidanka', $askari->LamabrkaCiidanka) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Fadhi *</label>
                        <select name="FadhiId" class="form-control" required>
                            <option value="">Dooro Fadhi</option>
                            @foreach($fadhis as $f)
                                <option value="{{ $f->id }}" {{ $askari->FadhiId == $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Darajada</label>
                        <input type="text" name="Darajada" class="form-control" value="{{ old('Darajada', $askari->Darajada) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Job Title</label>
                        <input type="text" name="JobTitle" class="form-control" value="{{ old('JobTitle', $askari->JobTitle) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="Status" class="form-control">
                            <option value="1" {{ $askari->Status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$askari->Status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Profile Image</label>
                        <input type="file" name="AskariImage" class="form-control mb-2">
                        @if($askari->AskariImage)
                            <img src="{{ $askari->AskariImageUrl }}" alt="Askari Image" class="img-thumbnail" style="max-height:150px;">
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary fw-bold">Update Askari</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
