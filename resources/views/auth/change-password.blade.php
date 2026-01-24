<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-3">Change Password</h3>

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf

                        <div class="mb-3">
                            <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
                            @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                            @error('new_password')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="mb-3">
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm New Password" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Update Password</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('dashboard') }}">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
