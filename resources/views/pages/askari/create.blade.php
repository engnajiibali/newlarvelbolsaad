@extends('layouts.admin')

@section('title', 'Add Askari')

@section('content')
<div class="container py-4">

    <a href="{{ route('askari.index') }}" class="btn btn-secondary mb-3">
        <i class="fa fa-arrow-left"></i> Back
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            Add Askari
        </div>

        <div class="card-body">
            <form action="{{ route('askari.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Row 1 -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Magaca Qofka *</label>
                        <input type="text" name="MagacaQofka" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lambarka Ciidanka *</label>
                        <input type="text" name="LamabrkaCiidanka" class="form-control" required>
                    </div>
                </div>

                <!-- Row 2 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Darajada</label>
                        <input type="text" name="Darajada" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="Gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="Lab">Male</option>
                            <option value="Dhedig">Female</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Telefoon Lambar</label>
                        <input type="text" name="TalefanLambar" class="form-control">
                    </div>
                </div>

                <!-- Row 3 -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="JobTitle" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payroll</label>
                        <input type="text" name="Payrol" class="form-control">
                    </div>
                </div>

                <!-- Row 4 -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Shirkadaha</label>
                        <input type="text" name="Shirkadaha" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Askari Address</label>
                        <textarea name="AskariAddress" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <!-- Row 5 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fadhi *</label>
                        <select name="FadhiId" class="form-control" required>
                            <option value="">Dooro Fadhi</option>
                            @foreach($Departments as $f)
                                <option value="{{ $f->id }}">{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Finish Date</label>
                        <input type="date" name="FinishDate" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="Status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Row 6 -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Accon</label>
                        <input type="text" name="Accon" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">AP</label>
                        <input type="text" name="AP" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="AskariImage" class="form-control">
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Save
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
