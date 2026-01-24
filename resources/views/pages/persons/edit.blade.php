@extends('layouts.admin')
@section('content')
<div class="content">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row">
			<div class="col">
				<h3 class="page-title">Edit Person</h3>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
	<div>
		@if (Session::has('success'))
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> {{ Session::get('success') }}</h4>
		</div>
		@endif
		@if (Session::has('fail'))
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> {{ Session::get('fail') }}</h4>
		</div>
		@endif
	</div>
	<br>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h5 class="card-title">Edit Person</h5>
				</div>
				<div class="card-body">
					<!-- Edit Form Start -->
					<form id="pForm" method="post" action="{{ route('persons.update', $person->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex align-items-center flex-wrap bg-light w-100 rounded p-3 mb-4">
									<div class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0">
										<img src="{{ asset('upload/personImg/' .$person->image) }}" alt="Profile Image" class="rounded-circle">
									</div>
									<div class="profile-upload">
										<h6 class="mb-1">Change Profile Image</h6>
										<p class="fs-12">Image should be below 4MB</p>
										<div class="profile-uploader d-flex align-items-center">
											<div class="drag-upload-btn btn btn-sm btn-primary me-2">
												Upload
												<input type="file" name="personImd" class="form-control">
											</div>
											<a href="javascript:void(0);" class="btn btn-light btn-sm">Cancel</a>
										</div>
										<span class="text-danger">@error('personImd') {{ $message }} @enderror</span>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Full Name</label>
									<input class="form-control" type="text" id="fullName" name="fullName" placeholder="Full Name" value="{{ old('fullName', $person->FullName) }}">
									<span class="text-danger">@error('fullName') {{ $message }} @enderror</span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Gender</label>
									<div>
										<label class="me-3">
											<input type="radio" name="gender" value="Male" {{ old('gender', $person->Gender) == 'Male' ? 'checked' : '' }}> Male
										</label>
										<label>
											<input type="radio" name="gender" value="Female" {{ old('gender', $person->Gender) == 'Female' ? 'checked' : '' }}> Female
										</label>
									</div>
									<span class="text-danger">@error('gender') {{ $message }} @enderror</span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Email</label>
									<input class="form-control" type="text" id="email" name="email" placeholder="email@example.com" value="{{ old('email', $person->Email) }}">
									<span class="text-danger">@error('email') {{ $message }} @enderror</span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Phone</label>
									<input class="form-control" type="text" id="phone" name="phone" placeholder="+252 xxxxxxxxx" value="{{ old('phone', $person->Phone) }}">
									<span class="text-danger">@error('phone') {{ $message }} @enderror</span>
								</div>
							</div>
						</div>
						<hr><br>
						<div class="d-flex align-items-center justify-content-end">
							<a href="{{ route('persons.index') }}" type="button" class="btn btn-outline-light border me-3">Cancel</a>
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
					</form>
					<!-- Edit Form End -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
