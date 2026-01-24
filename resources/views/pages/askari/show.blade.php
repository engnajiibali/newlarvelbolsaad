@extends('layouts.admin')

@section('title', 'View Askari')

@section('content')
<div class="container py-4">
    <a href="{{ route('askari.index') }}" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="card shadow-sm">
        <div class="card-header bg-info text-white fw-bold">{{ $askari->MagacaQofka }}</div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <img src="{{ $askari->AskariImageUrl }}" class="img-fluid rounded" alt="Askari Image">
            </div>
            <div class="col-md-8">
                <p><strong>Lambarka Ciidanka:</strong> {{ $askari->LamabrkaCiidanka }}</p>
                <p><strong>Fadhi:</strong> {{ $askari->fadhi->name ?? '-' }}</p>
                <p><strong>Darajada:</strong> {{ $askari->Darajada }}</p>
                <p><strong>Job Title:</strong> {{ $askari->JobTitle }}</p>
                <p><strong>Status:</strong> {{ $askari->Status ? 'Active' : 'Inactive' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
