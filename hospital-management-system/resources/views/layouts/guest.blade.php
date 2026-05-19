<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MediCare HMS') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #12263f 0%, #1a3a5c 50%, #0f4c75 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .auth-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .auth-logo {
            background: linear-gradient(135deg, #2c7be5, #1a56c4);
            width: 70px; height: 70px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem; color: white;
        }
        .btn-primary { background: #2c7be5; border-color: #2c7be5; }
        .btn-primary:hover { background: #1a56c4; border-color: #1a56c4; }
        .form-control:focus { border-color: #2c7be5; box-shadow: 0 0 0 0.2rem rgba(44,123,229,.25); }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-4 px-3">
        <div style="width: 100%; max-width: 440px;">
            <div class="text-center mb-4">
                <div class="auth-logo">
                    <i class="fas fa-hospital-alt"></i>
                </div>
                <h3 class="text-white fw-bold mb-0">MediCare HMS</h3>
                <p class="text-white-50 small">Hospital Management System</p>
            </div>
            <div class="card auth-card">
                <div class="card-body p-4 p-md-5">
                    {{ $slot }}
                </div>
            </div>
            <p class="text-center text-white-50 small mt-3">
                &copy; {{ date('Y') }} MediCare Hospital. All rights reserved.
            </p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
