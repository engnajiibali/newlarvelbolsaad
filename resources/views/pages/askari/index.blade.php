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
                <div class="card-body d-flex align-items-center">
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

    <!-- Search / Filter -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-white fw-bold">Raadinta / Shaandhaynta</div>
        <div class="card-body">
            <form method="GET" action="{{ route('askari.index') }}" class="row g-3">

                <div class="col-md-3">
                    <input type="text" name="darajada" class="form-control"
                        placeholder="Darajada" value="{{ request('darajada') }}">
                </div>

                <div class="col-md-3">
                    <input type="text" name="lambar_ciidan" class="form-control"
                        placeholder="Lambar Ciidan" value="{{ request('lambar_ciidan') }}">
                </div>

                <div class="col-md-3">
                    <input type="text" name="magaca" class="form-control"
                        placeholder="Magaca Askari" value="{{ request('magaca') }}">
                </div>

                <div class="col-md-2">
                    <select name="fadhi_id" class="form-select select2">
                        <option value="">-- Fadhi --</option>
                        @foreach ($fadhiyada as $f)
                            <option value="{{ $f->id }}"
                                {{ request('fadhi_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-grid">
                    <button class="btn btn-primary">
                        <i class="ti ti-search"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

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
                            <th>Darajada</th>
                            <th>Lambar Ciidan</th>
                            <th>Magaca</th>
                            <th>Fadhi</th>
                            <th>Assign Date</th>
                            <th>Update Date</th>
                            <th>Qoryaha</th>
                            <th>Qori Numbers</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($assignments as $assignment)
                            <tr>
                                <td>{{ $assignment->assignfadhiId }}</td>
                                <td>{{ $assignment->askari->Darajada ?? 'N/A' }}</td>
                                <td>{{ $assignment->askari->LamabrkaCiidanka ?? 'N/A' }}</td>
                                <td>{{ $assignment->askari->MagacaQofka ?? 'N/A' }}</td>
                                <td>{{ $assignment->fadhi->name ?? 'N/A' }}</td>

                                <td>{{ \Carbon\Carbon::parse($assignment->assignFadhiDate)->format('Y-m-d') }}</td>

                                <td>
                                    {{ $assignment->AssignFadhiUpdateDate
                                        ? \Carbon\Carbon::parse($assignment->AssignFadhiUpdateDate)->format('Y-m-d')
                                        : '-' }}
                                </td>

                                <!-- Qoryaha count -->
                                <td>{{ $assignment->qori_count ?? 0 }}</td>

                                <!-- Qori numbers -->
                                <td>
                                    @forelse($assignment->assignhubs->where('Status', 0) as $qori)
                                        <span class="badge bg-info mb-1">
                                            {{ $qori->QoriNumber }}
                                        </span>
                                    @empty
                                        <span class="text-muted">No Qori</span>
                                    @endforelse
                                </td>

                                <td>
                                    @if($assignment->Status == 0)
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
                                           class="btn btn-sm btn-light me-1">
                                            <i class="ti ti-eye"></i>
                                        </a>

                                        <a href="{{ route('askari.edit', $assignment->assignfadhiId) }}"
                                           class="btn btn-sm btn-light me-1">
                                            <i class="ti ti-edit"></i>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('askari.destroy', $assignment->assignfadhiId) }}"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-light"
                                                    onclick="return confirm('Delete this assignment?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    No assignments found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="row px-3 pb-3">
                <div class="col-md-6"></div>
                <div class="col-md-6 text-end">
                    {{ $assignments->links() }}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
