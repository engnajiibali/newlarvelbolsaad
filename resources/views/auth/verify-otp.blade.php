@extends('layouts.auth')

@section('title', 'Login')

@push('styles')
@endpush

@section('content')
<div class="container-fuild">
    <div class="w-100 overflow-hidden position-relative flex-wrap d-block vh-100">
        <div class="row">
            <div class="col-lg-5">
                <div class="d-lg-flex align-items-center justify-content-center d-none flex-wrap vh-100 bg-primary-transparent">
                    <div>
                        <img src="{{ asset('ChatGPT Image Aug 9, 2025, 11_07_50 PM.png') }}" alt="Img">
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 col-sm-12">
                <div class="row justify-content-center align-items-center vh-100 overflow-auto flex-wrap">
                    <div class="col-md-7 mx-auto p-4">

                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        <form method="POST" action="{{ route('otp.verify') }}" class="digit-group">
                            @csrf
                            <div>
                                <div class="mx-auto  text-center">
                                    <img src="{{ asset('/assets/img/pologo.png') }}" class="img-fluid" alt="Logo">
                                </div>

                                <div class="">
                                    <div class="text-center mb-3">
                                        <h2 class="mb-2">2 Step Verification</h2>
                                        <p class="mb-0">
                                            Please enter the OTP received to confirm your account ownership.
                                            A code has been sent to your Email
                                        </p>
                                    </div>

                                    <!-- ✅ OTP INPUTS (6 digits) -->
                                    <div class="text-center otp-input">
                                        <div class="d-flex align-items-center mb-3">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3"
                                                   id="digit-1" name="digit-1" data-next="digit-2" maxlength="1">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3"
                                                   id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3"
                                                   id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3"
                                                   id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold me-3"
                                                   id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1">
                                            <input type="text" class="rounded w-100 py-sm-3 py-2 text-center fs-26 fw-bold"
                                                   id="digit-6" name="digit-6" data-previous="digit-5" maxlength="1">
                                        </div>

                                        <!-- ✅ TIMER + RESEND -->
                                        <div>
                                            <div class="badge bg-danger-transparent mb-3">
                                                <p class="d-flex align-items-center mb-0">
                                                    <i class="ti ti-clock me-1"></i>
                                                    <span id="otp-timer">05:00</span>
                                                </p>
                                            </div>

                                            <div class="mb-3 d-flex justify-content-center">
                                                <p class="text-gray-9 mb-0">
                                                    Didn't get the OTP?
                                                </p>
                                            </div>

                                            <!-- Resend Form -->
                                            <form method="POST" action="{{ route('otp.resend') }}" class="mt-2 text-center">
                                                @csrf
                                                <button type="submit" id="resendBtn" class="btn btn-secondary w-100" disabled>Resend Code</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- ✅ Submit -->
                                    <div class="mb-3 mt-4">
                                        <button type="submit" class="btn btn-primary w-100">Verify & Proceed</button>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
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

@push('scripts')
<script src="{{ asset('assets/js/otp.js') }}"></script>

<!-- ✅ Countdown Timer (5 minutes) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let timeLeft = 300; // 5 minutes = 300 seconds
    const timerElement = document.getElementById('otp-timer');
    const resendBtn = document.getElementById('resendBtn');

    const timer = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        timerElement.textContent =
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 0) {
            clearInterval(timer);
            timerElement.textContent = "Expired";
            timerElement.classList.add('text-danger', 'fw-bold');
            resendBtn.removeAttribute('disabled'); // enable resend
        }

        timeLeft--;
    }, 1000);
});
</script>
@endpush
