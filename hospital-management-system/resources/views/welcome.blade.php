<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare HMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #12263f, #1a3a5c); min-height: 100vh; font-family: 'Cairo', sans-serif; text-align: right; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center text-white px-4">
        <i class="fas fa-hospital-alt fa-4x text-primary mb-4"></i>
        <h1 class="fw-bold mb-2">MediCare HMS</h1>
        <p class="text-white-50 mb-4">نظام إدارة المستشفى</p>
        <div class="d-flex gap-3 justify-content-center">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">الذهاب إلى لوحة التحكم</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary px-4"><i class="fas fa-sign-in-alt ms-2"></i>تسجيل الدخول</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light px-4">إنشاء حساب</a>
            @endauth
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
