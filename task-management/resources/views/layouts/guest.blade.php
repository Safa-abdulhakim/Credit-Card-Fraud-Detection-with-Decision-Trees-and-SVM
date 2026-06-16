<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name','Task Manager') }} — @yield('title','تسجيل الدخول')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Cairo',sans-serif;min-height:100vh;background:linear-gradient(135deg,#1a1f36,#2d3561 50%,#667eea);display:flex;align-items:center;justify-content:center;padding:2rem 1rem}
        .auth-card{width:100%;max-width:440px;background:#fff;border-radius:1.25rem;box-shadow:0 20px 60px rgba(0,0,0,.3);overflow:hidden}
        .auth-header{background:linear-gradient(135deg,#667eea,#764ba2);padding:2rem;text-align:center;color:#fff}
        .brand-icon{width:64px;height:64px;border-radius:1rem;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:2rem}
        .auth-body{padding:2rem}
        .form-label{font-weight:500;color:#374151}
        .form-control{border-radius:.6rem;border:1.5px solid #e5e7eb;padding:.6rem 1rem;font-family:'Cairo',sans-serif}
        .form-control:focus{border-color:#667eea;box-shadow:0 0 0 3px rgba(102,126,234,.15)}
        .btn-primary{border-radius:.6rem;padding:.7rem 1.5rem;background:linear-gradient(135deg,#667eea,#764ba2);border:none;font-weight:600;font-family:'Cairo',sans-serif}
        .btn-primary:hover{background:linear-gradient(135deg,#5a6fd6,#6a3d92)}
        .auth-link{color:#667eea;text-decoration:none;font-weight:500}
        .auth-link:hover{text-decoration:underline}
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-header">
        <div class="brand-icon"><i class="bi bi-check2-square"></i></div>
        <h4 class="mb-1 fw-bold">Task Manager</h4>
        <p class="mb-0 opacity-75 small">نظام إدارة المهام الاحترافي</p>
    </div>
    <div class="auth-body">@yield('content')</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
