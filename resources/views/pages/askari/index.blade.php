@extends('layouts.admin')
@section('content')

<div class="content">

    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">{{ $pageTitle ?? 'Assignments' }}</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">{{ $pageTitle ?? 'Assignments' }}</li>
                    <li class="breadcrumb-item active">{{ $subTitle ?? 'Askari – Fadhi' }}</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('askari.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-2"></i>New Assignment
            </a>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4><i class="icon fa fa-check"></i> {{ session('success') }}</h4>
        </div>
    @endif

    <!-- Cards -->
    <div class="row mb-4">

        <div class="col-lg-3 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <span class="avatar avatar-lg bg-info rounded-circle">
                            <i class="ti ti-users"></i>
                        </span>
                        <div class="ms-2">
                            <p class="fs-12 mb-1">Total Assignments</p>
                            <h4>{{ $assignments->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Cards -->

    <!-- Table -->
    <div class="card">
        <div class="card-header">
            <h5>{{ $subTitle ?? 'Assignments List' }}</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Askari</th>
                            <th>Fadhi</th>
                            <th>Assign Date</th>
                            <th>Update Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->assignfadhiId }}</td>

                                <td>{{ $assignment->askari->MagacaQofka ?? 'N/A' }}</td>

                                <td>{{ $assignment->fadhi->name ?? 'N/A' }}</td>

                                <td>{{ \Carbon\Carbon::parse($assignment->assignFadhiDate)->format('Y-m-d') }}</td>

                                <td>
                                    {{ $assignment->AssignFadhiUpdateDate
                                        ? \Carbon\Carbon::parse($assignment->AssignFadhiUpdateDate)->format('Y-m-d')
                                        : '-' }}
                                </td>

                                <td>
                                    @if($assignment->Status)
                                        <span class="badge badge-success">
                                            <i class="ti ti-point-filled me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="ti ti-point-filled me-1"></i>Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-icon d-inline-flex align-items-center">

                                        <a href="{{ route('askari.show', $assignment->assignfadhiId) }}"
                                           class="btn btn-sm btn-light me-1" title="View">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        <a href="{{ route('askari.edit', $assignment->assignfadhiId) }}"
                                           class="btn btn-sm btn-light me-1" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('askari.destroy', $assignment->assignfadhiId) }}"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-light"
                                                    title="Delete"
                                                    onclick="return confirm('Delete this assignment?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No assignments found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row px-3 pb-3">
                <div class="col-md-6">
                    Showing {{ $assignments->firstItem() ?? 0 }} to {{ $assignments->lastItem() ?? 0 }}
                    of {{ $assignments->total() }} entries
                </div>
                <div class="col-md-6 text-end">
                    {{ $assignments->links() }}
                </div>
            </div>

        </div>
    </div>
    <!-- /Table -->

</div>
@endsection
