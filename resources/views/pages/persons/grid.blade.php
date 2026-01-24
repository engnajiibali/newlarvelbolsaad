@extends('layouts.admin')
@section('content')
<div class="content">
    <!-- Breadcrumb -->
    <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
        <div class="my-auto mb-2">
            <h2 class="mb-1">{{$pageTitle}}</h2>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="index.html"><i class="ti ti-smart-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">{{$pageTitle}}</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$subTitle}}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap">
            <div class="me-2 mb-2">
                <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                    <a href="{{route('persons.index')}}" class="btn btn-icon btn-sm active bg-primary text-white me-1">
                        <i class="ti ti-list-tree"></i>
                    </a>
                    <a href="{{route('person.grid')}}" class="btn btn-icon btn-sm">
                        <i class="ti ti-layout-grid"></i>
                    </a>
                </div>
            </div>
            <div class="me-2 mb-2">
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center" data-bs-toggle="dropdown">
                        <i class="ti ti-file-export me-1"></i>Export
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end p-3">
                        <li data-bs-toggle="modal" data-bs-target="#import-model">
                            <a href="javascript:void(0);" class="dropdown-item rounded-1">
                                <i class="ti ti-file-type-pdf me-1"></i>Import as Excel
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('persons.export') }}" class="dropdown-item rounded-1">
                                <i class="ti ti-file-type-xls me-1"></i>Export as Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mb-2">
                <a href="{{route('persons.create')}}" class="btn btn-primary d-flex align-items-center">
                    <i class="ti ti-circle-plus me-2"></i>Add Police
                </a>
            </div>
            <div class="head-icons ms-2">
                <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
                    <i class="ti ti-chevrons-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <!-- Alerts -->
    <div>
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <h4><i class="icon fa fa-check"></i> {{Session::get('success')}}</h4>
            </div>
        @endif
        @if (Session::has('fail'))
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <h4><i class="icon fa fa-exclamation"></i> {{Session::get('fail')}}</h4>
            </div>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 d-flex">
            <div class="card flex-fill stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-dark rounded-circle me-3">
                            <i class="ti ti-users"></i>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1">Total Police</p>
                            <h4 class="mb-0">{{$AllPersons}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
            <div class="card flex-fill stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-success rounded-circle me-3">
                            <i class="ti ti-user-share"></i>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1">Active</p>
                            <h4 class="mb-0">{{$ActivePersons}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
            <div class="card flex-fill stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-danger rounded-circle me-3">
                            <i class="ti ti-user-pause"></i>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1">InActive</p>
                            <h4 class="mb-0">{{$inActivePersons}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
            <div class="card flex-fill stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg bg-info rounded-circle me-3">
                            <i class="ti ti-user-plus"></i>
                        </div>
                        <div>
                            <p class="fs-12 fw-medium mb-1">New Joiners</p>
                            <h4 class="mb-0">{{$NewJoiners}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card search-card mb-4">
        <div class="card-body p-3">
            <form action="{{ route('persons.search') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <input type="text" name="name" placeholder="Search By Name" class="form-control" value="{{ old('name') }}">
                </div>
                <div class="col-md-2">
                    <input type="email" name="email" placeholder="Search By email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="phone" placeholder="Search By phone" class="form-control" value="{{ old('phone') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Select Status</option>
                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-search me-1"></i>Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Clients Grid -->
    <div class="row">
        @foreach($persons as $person)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <!-- Status Badge - Moved to top left -->
                        <div class="status-badge">
                            @if ($person->status == "t")
                                <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                    <i class="ti ti-point-filled me-1"></i>Active
                                </span>
                            @else
                                <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                    <i class="ti ti-point-filled me-1"></i>Inactive
                                </span>
                            @endif
                        </div>
                        
<!-- Profile Image - Centered -->
<div class="mx-auto" style="width: 120px; height: 120px;">
    <a href="{{ route('persons.show', $person->id) }}" class="d-block">
        <img src="{{ $person->picture 
                    ? asset('https://spf-hr.com/media/'.$person->picture) 
                    : asset('upload/personImg/male.jpeg') }}" 
             class="rounded-circle object-fit-cover" 
             alt="{{ $person->FullName }}"
             style="width: 120px; height: 120px; border: 3px solid #e0e0e0;">
    </a>
</div>

                        
                        <!-- Dropdown Menu - Top right -->
                        <div class="dropdown">
                            <button class="btn btn-icon btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li>
                                    <a class="dropdown-item rounded-1" href="{{ route('persons.edit', $person->id) }}">
                                        <i class="ti ti-edit me-1"></i>Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('persons.destroy', $person->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger rounded-1" onclick="return confirm('Are you sure?')">
                                            <i class="ti ti-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Name and Gender -->
                    <div class="text-center mb-3">
                        <h5 class="mb-1"><a href="{{ route('persons.show', $person->id) }}" class="text-dark">{{ $person->first_name . ' ' . $person->middle_name }}</a></h5>
                        <span class="badge bg-pink-transparent fs-10 fw-medium">
                            @if($person->sex == 'Lab')
                                <i class="ti ti-mars text-primary"></i> Male
                            @elseif($person->sex == 'Dheddig')
                                <i class="ti ti-venus text-danger"></i> Female
                            @else
                                {{ $person->Gender }}
                            @endif
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-3">
                                <span class="text-muted fs-12 d-block">DOB </span>
                                <h6 class="fw-medium">{{ \Carbon\Carbon::parse($person->dob)->format('d M Y') }}</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <span class="text-muted fs-12 d-block">Phone</span>
                                <h6 class="fw-medium">{{ $person->phone ?: 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
<ul class="pull-right pagination">{{ $persons->links() }}</ul>
    <!-- [Rest of your code remains the same] -->
</div>

<style>
    /* Additional custom styling */
    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 1;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .dropdown-toggle::after {
        display: none;
    }
</style>

<!-- [Your existing modal and scripts] -->
@endsection