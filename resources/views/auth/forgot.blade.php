@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="container-fuild">
    <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
        <div class="row">
            <div class="col-lg-5">
                <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
                    <div>
                        <img src="{{ asset('assets/img/bg/authentication-bg-04.svg') }}" alt="Img">
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                    <div class="col-md-7 mx-auto vh-100">
                        <form method="POST" action="{{ route('password.email') }}" class="vh-100">
                            @csrf
                            <div class="vh-100 d-flex flex-column justify-content-between p-4 pb-0">

                                <!-- ✅ LOGO -->
                                <div class="mx-auto mb-5 text-center">
                                    <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                                </div>

                                <!-- ✅ SHOW STATUS OR ERROR MESSAGES -->
                                @if (session('status'))
                                    <div class="alert alert-success text-center">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger text-center">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif

                                <div class="">
                                    <div class="text-center mb-3">
                                        <h2 class="mb-2">Forgot Password?</h2>
                                        <p class="mb-0">
                                            If you forgot your password, we’ll email you instructions to reset it.
                                        </p>
                                    </div>

                                    <!-- ✅ EMAIL INPUT -->
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <input type="email" name="email" placeholder="Email" required
                                                class="form-control border-end-0 @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}">
                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-mail"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- ✅ SUBMIT BUTTON -->
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div>

                                    <!-- ✅ LINK BACK TO LOGIN -->
                                    <div class="text-center">
                                        <h6 class="fw-normal text-dark mb-0">
                                            Return to
                                            <a href="{{ route('login') }}" class="hover-a">Sign In</a>
                                        </h6>
                                    </div>
                                </div>

                                <div class="mt-5 pb-4 text-center">
                                    <p class="mb-0 text-gray-9">Copyright &copy; 2024 - Smarthr</p>
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
