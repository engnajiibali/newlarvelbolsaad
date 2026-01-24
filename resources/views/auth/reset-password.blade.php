@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="container-fuild">
    <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
        <div class="row">
            <!-- Left Side Image -->
            <div class="col-lg-5">
                <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
                    <div>
                        <img src="{{ asset('assets/img/bg/authentication-bg-06.svg') }}" alt="Img">
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                    <div class="col-md-7 mx-auto vh-100">

                        <!-- ✅ Success / Error Alerts -->
                        @if(session('status'))
                            <div class="alert alert-success text-center">{{ session('status') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger text-center">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <!-- ✅ Reset Form -->
                        <form method="POST" action="{{ route('password.update') }}" class="vh-100">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token ?? '' }}">

                            <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">
                                <!-- Logo -->
                                <div class="mx-auto mb-5 text-center">
                                    <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                                </div>

                                <div>
                                    <div class="text-center mb-3">
                                        <h2 class="mb-2">Reset Password</h2>
                                        <p class="mb-0">Your new password must be different from previously used passwords.</p>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" name="email"
                                                class="form-control border-end-0 @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" placeholder="Email" required>
                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-mail"></i>
                                            </span>
                                        </div>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <div class="pass-group">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="New Password" required>
                                            <span class="ti toggle-password ti-eye-off"></span>
                                        </div>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="pass-group">
                                            <input type="password" name="password_confirmation"
                                                class="form-control" placeholder="Confirm Password" required>
                                            <span class="ti toggle-passwords ti-eye-off"></span>
                                        </div>
                                    </div>

                                    <!-- Submit -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                    </div>

                                    <!-- Back to Login -->
                                    <div class="text-center">
                                        <h6 class="fw-normal text-dark mb-0">
                                            Return to
                                            <a href="{{ route('login') }}" class="hover-a">Sign In</a>
                                        </h6>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-5 pb-4 text-center">
                                    <p class="mb-0 text-gray-9">Copyright &copy; {{ date('Y') }} - Smarthr</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
