@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h2>Assignments of Fadhi</h2>
        <a href="" class="btn btn-primary">Create New Assignment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Askari Name</th>
                <th>Fadhi (Department)</th>
                <th>Assign Date</th>
                <th>Update Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->assignfadhiId }}</td>
                    <td>{{ $assignment->askari->MagacaQofka ?? 'N/A' }}</td>
                    <td>{{ $assignment->fadhi->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment->assignFadhiDate)->format('Y-m-d') }}</td>
                    <td>{{ $assignment->AssignFadhiUpdateDate ? \Carbon\Carbon::parse($assignment->AssignFadhiUpdateDate)->format('Y-m-d') : '-' }}</td>
                    <td>
                        @if($assignment->Status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="" class="btn btn-sm btn-info">View</a>
                        <a href="" class="btn btn-sm btn-warning">Edit</a>
                        <form action="" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No assignments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $assignments->links() }}
    </div>
</div>
@endsection
