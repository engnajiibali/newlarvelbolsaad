@extends('layouts.auth')

@section('title', 'Login - Hoggaanka Saadka Booliska Soomaaliyeed')

@section('content')
<div class="container-fluid">
    <div class="row vh-100">

        <!-- LEFT SIDE (Logo, Slogan, Description) -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-white text-black position-relative" style="border-right: 4px solid #0f3b70;">

            <!-- Background Watermark -->
            <img src="{{ asset('20251009_125745-removebg-preview.png') }}"
                 alt="Watermark"
                 class="position-absolute"
                 style="top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        opacity: 0.08;
                        max-width: 90%;
                        z-index: 0;
                        pointer-events: none;">

            <!-- Foreground Content -->
            <div class="text-center px-5 position-relative" style="z-index: 1; font-family: 'Poppins', sans-serif;">
                <!-- Logo -->
                <img src="{{ asset('20251009_125745-removebg-preview.png') }}" alt="Logo" class="mb-3" style="width: 150px;">

                <!-- Header -->
                <h2 class="fw-bold mb-3" style="color: #0f3b70;">Hoggaanka Saadka Booliska Soomaaliyeed</h2>

                <!-- Slogan -->
                <h4 class="fw-semibold mb-4" style="color: #1a5aa3;">Xakameyn, Qorsheyn, iyo Daahfurnaan.</h4>

                <!-- Description -->
               <p class="lead mb-4" style="color: #2f3b52;">
                  Hoggaanka Saadka Booliska Soomaaliyeed wuxuu masuul ka yahay qorsheynta, maaraynta, iyo qaybinta saadka ay u baahan yihiin cutubyada Booliiska dalka oo dhan.
Ujeeddadu waa in la hubiyo helitaanka agabka, qalabka iyo adeegyada lagama maarmaanka u ah fulinta howlaha amniga iyo adeegyada bulshada iyadoo la adeegsanayo nidaam casri ah oo hufan.
                </p>

                <hr class="mx-auto" style="width: 60px; border: 2px solid #0f3b70;">
            </div>
        </div>

        <!-- RIGHT SIDE (Login Form) -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0f3b70 0%, #1a5aa3 100%); color: #fff;">
            <div class="w-100 bg-white rounded-4 shadow-lg p-5" style="max-width: 420px; color: #000;">
                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="color: #0f3b70;">Soo gal Nidaamka</h3>
                    <p class="text-muted">Fadlan geli xogtaada sirta ah</p>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <!-- Email or Username -->
                    <div class="mb-3">
                        <label for="login" class="form-label fw-semibold">Email ama Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ti ti-user" style="color:#0f3b70;"></i></span>
                            <input type="text" name="login" id="login" class="form-control border-start-0" value="{{ old('login') }}" required placeholder="Geli email ama username">
                        </div>
                        @error('login') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="ti ti-lock" style="color:#0f3b70;"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0" required placeholder="Geli password-ka">
                        </div>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label for="remember" class="form-check-label">Xasuuso</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #0f3b70;">Hilmaantay Password?</a>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid">
                        <button type="submit" class="btn" style="background-color: #0f3b70; color: #fff;">Soo gal</button>
                    </div>
                </form>

                <footer class="text-center mt-5 text-muted small">
                    &copy; {{ date('Y') }} Hoggaanka Saadka Booliska Soomaaliyeed
                </footer>
            </div>
        </div>
    </div>
</div>
@endsection
