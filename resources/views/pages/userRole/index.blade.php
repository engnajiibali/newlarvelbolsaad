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
<li class="breadcrumb-item">
{{$pageTitle}}
</li>
<li class="breadcrumb-item active" aria-current="page">{{$subTitle}}</li>
</ol>
</nav>
</div>
<div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">

<div class="mb-2">
<a href="{{ route('userRole.create') }}"  class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add New</a>
</div>
<div class="ms-2 head-icons">
<a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Collapse" id="collapse-header">
<i class="ti ti-chevrons-up"></i>
</a>
</div>
</div>
</div>
<!-- /Breadcrumb -->
<div>
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-check"></i> {{Session::get('success')}}</h4>
</div>
@endif
@if (Session::has('fail'))
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<h4><i class="icon fa fa-check"></i> {{Session::get('fail')}}</h4>
</div>
@endif
</div>
<br>
<!-- Budgets list -->
<div class="card">
<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
<h5>{{$subTitle}}</h5>
<div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">


</div>
</div>
<div class="card-body p-0">
<div class="custom-datatable-filter table-responsive">
<table class="table">
         <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Role</th>
                                <th>Read</th>
                                <th>Write</th>
                                <th>Edit</th>
                                <th>Delete</th>
                              <th colspan="2">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userRole as $index => $role)
                            <tr>
                                <td>{{ $index + 1 }}</td> <!-- Dynamic index for row numbering -->
                                <td>{{ $role->Role }}</td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="Read" value="{{ $role->Read_permision }}" 
                                        class="permission-checkbox" {{ $role->Read_permision == 1 ? 'checked' : '' }} 
                                        onclick="return false;"> Read
                                    </label>

                                </td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="Write" value="{{ $role->Write_permision }}" class="permission-checkbox" {{ $role->Write_permision == 1 ? 'checked' : '' }} onclick="return false;"> Write
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="Edit" value="{{ $role->Edit_permision }}" class="permission-checkbox" {{ $role->Edit_permision == 1 ? 'checked' : '' }} onclick="return false;"> Edit
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input type="checkbox" name="Delete" value="{{ $role->Delete_permision }}" class="permission-checkbox" {{ $role->Delete_permision == 1 ? 'checked' : '' }} onclick="return false;"> Delete
                                    </label>
                                </td>
                                <td width="2.5%">
                                    <a href="{{ route('userRole.edit', $role->id) }}" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                </td>
                                <td width="2.5%">
                                    <form method="POST" action="{{ route('userRole.destroy', $role->id) }}">    
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
<div class="pull-right">{{ $userRole->links() }}</div>
</div>
</div>
</div>
<!-- /Budgets list -->

</div>

@endsection