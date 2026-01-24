@extends('layouts.admin')

@section('content')
<div class="container">
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#employeeModal" id="addEmployeeBtn">Add Employee</button>

    <table class="table" id="employeeTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
                <tr id="employee-{{ $emp->id }}">
                    <td>{{ $emp->id }}</td>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->phone }}</td>
                    <td>{{ $emp->designation }}</td>
                    <td>
                        <button class="btn btn-sm btn-info edit-btn" data-id="{{ $emp->id }}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $emp->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="employeeForm">
            @csrf
            <input type="hidden" name="_method" id="method" value="POST">
            <input type="hidden" id="employee_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                        <span class="text-danger error-text phone_error"></span>
                    </div>
                    <div class="mb-3">
                        <label>Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation">
                        <span class="text-danger error-text designation_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/employees.js') }}"></script>
@endpush
