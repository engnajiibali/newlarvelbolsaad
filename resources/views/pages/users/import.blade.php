@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h4>Import Users</h4>
    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-success">Import</button>
        <a href="{{ route('users.export') }}" class="btn btn-primary">Export Users</a>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</div>
@endsection
