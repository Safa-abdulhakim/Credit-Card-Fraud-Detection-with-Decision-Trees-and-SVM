<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare HMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: linear-gradient(135deg, #12263f, #1a3a5c); min-height: 100vh; font-family: 'Segoe UI', sans-serif; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center text-white px-4">
        <i class="fas fa-hospital-alt fa-4x text-primary mb-4"></i>
        <h1 class="fw-bold mb-2">MediCare HMS</h1>
        <p class="text-white-50 mb-4">Hospital Management System</p>
        <div class="d-flex gap-3 justify-content-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary px-4"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light px-4">Register</a>
            @endauth
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
