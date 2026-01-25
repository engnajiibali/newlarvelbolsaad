@extends('layouts.admin')

@section('title', 'Add Askari')

@section('content')
<div class="container py-4">
    <a href="{{ route('askari.index') }}" class="btn btn-secondary mb-3"><i class="fa fa-arrow-left"></i> Back</a>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">Add Askari</div>
        <div class="card-body">
            <form action="{{ route('askari.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Magaca Qofka *</label>
                    <input type="text" name="MagacaQofka" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Lambarka Ciidanka *</label>
                    <input type="text" name="LamabrkaCiidanka" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Fadhi *</label>
                    <select name="FadhiId" class="form-control" required>
                        <option value="">Dooro Fadhi</option>
                        @foreach($Departments as $f)
                            <option value="{{ $f->id }}">{{ $f->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Profile Image</label>
                    <input type="file" name="AskariImage" class="form-control">
                </div>
                <button class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
