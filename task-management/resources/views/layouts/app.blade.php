<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name','Task Manager') }} — @yield('title','لوحة التحكم')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family:'Cairo',sans-serif;background:#f0f2f5}
        .sidebar{width:260px;min-height:100vh;background:linear-gradient(180deg,#1a1f36,#2d3561);position:fixed;top:0;right:0;z-index:1000;box-shadow:-4px 0 15px rgba(0,0,0,.2)}
        .sidebar-brand{padding:1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,.1)}
        .sidebar-brand h5{color:#fff;font-weight:700;margin:0}
        .sidebar-brand small{color:rgba(255,255,255,.5);font-size:.75rem}
        .nav-section-title{color:rgba(255,255,255,.4);font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;padding:.5rem 1.25rem;margin-top:.5rem}
        .sidebar .nav-link{color:rgba(255,255,255,.7);padding:.65rem 1.25rem;border-radius:.5rem;margin:.15rem .75rem;font-size:.9rem;transition:all .2s;display:flex;align-items:center;gap:.6rem}
        .sidebar .nav-link:hover,.sidebar .nav-link.active{color:#fff;background:rgba(255,255,255,.15)}
        .sidebar .nav-link.active{font-weight:600}
        .sidebar .nav-link i{font-size:1.1rem;width:1.3rem}
        .main-content{margin-right:260px;min-height:100vh;display:flex;flex-direction:column}
        .topbar{background:#fff;border-bottom:1px solid #e9ecef;padding:.75rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:999;box-shadow:0 1px 4px rgba(0,0,0,.06)}
        .topbar .page-title{font-size:1.1rem;font-weight:600;color:#2d3561;margin:0}
        .user-avatar{width:38px;height:38px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem}
        .content-area{flex:1;padding:1.5rem}
        .stat-card{border:none;border-radius:1rem;box-shadow:0 2px 12px rgba(0,0,0,.07);transition:transform .2s,box-shadow .2s;overflow:hidden}
        .stat-card:hover{transform:translateY(-3px);box-shadow:0 6px 20px rgba(0,0,0,.1)}
        .stat-icon{width:56px;height:56px;border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:1.5rem}
        .stat-value{font-size:2rem;font-weight:700;line-height:1}
        .stat-label{color:#6c757d;font-size:.85rem;margin-top:.25rem}
        .table-card{border:none;border-radius:1rem;box-shadow:0 2px 12px rgba(0,0,0,.07);overflow:hidden}
        .table-card .card-header{background:#fff;border-bottom:1px solid #f0f0f0;padding:1rem 1.25rem;font-weight:600}
        .table th{background:#f8f9fa;font-size:.8rem;text-transform:uppercase;letter-spacing:.5px;color:#6c757d;border-top:none}
        .table td{vertical-align:middle}
        .form-card{border:none;border-radius:1rem;box-shadow:0 2px 12px rgba(0,0,0,.07)}
        .form-label{font-weight:500;color:#374151;font-size:.9rem}
        .form-control,.form-select{border-radius:.5rem;border:1.5px solid #e5e7eb;padding:.5rem .9rem;transition:border-color .2s,box-shadow .2s;font-family:'Cairo',sans-serif}
        .form-control:focus,.form-select:focus{border-color:#667eea;box-shadow:0 0 0 3px rgba(102,126,234,.15)}
        .btn{border-radius:.5rem;font-weight:500;font-family:'Cairo',sans-serif}
        .btn-primary{background:linear-gradient(135deg,#667eea,#764ba2);border:none}
        .btn-primary:hover{background:linear-gradient(135deg,#5a6fd6,#6a3d92)}
        .badge{font-size:.75rem;padding:.4em .7em;border-radius:.5rem;font-weight:500}
        @media(max-width:768px){.sidebar{transform:translateX(100%)}.sidebar.show{transform:translateX(0)}.main-content{margin-right:0}}
    </style>
    @stack('styles')
</head>
<body>
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2">
            <div style="width:40px;height:40px;border-radius:.75rem;background:rgba(102,126,234,.25);display:flex;align-items:center;justify-content:center">
                <i class="bi bi-check2-square text-primary fs-5"></i>
            </div>
            <div><h5 class="mb-0">Task Manager</h5><small>نظام إدارة المهام</small></div>
        </div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section-title">القائمة الرئيسية</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> لوحة التحكم
        </a>
        <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
            <i class="bi bi-list-task"></i> جميع المهام
        </a>
        <a href="{{ route('tasks.create') }}" class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> إضافة مهمة
        </a>
        <div class="nav-section-title mt-2">الحساب</div>
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> الملف الشخصي
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="cursor:pointer">
                <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</nav>
<div class="main-content">
    <div class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle"><i class="bi bi-list fs-5"></i></button>
            <h6 class="page-title">@yield('page-title','لوحة التحكم')</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-md-block">
                <div class="fw-semibold small text-dark">{{ auth()->user()->name }}</div>
                <div class="text-muted" style="font-size:.75rem">{{ auth()->user()->email }}</div>
            </div>
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
        </div>
    </div>
    <div class="px-4 pt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" style="border-radius:.75rem;border:none">
                <i class="bi bi-check-circle-fill fs-5"></i><span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" style="border-radius:.75rem;border:none">
                <i class="bi bi-exclamation-circle-fill fs-5"></i><span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    <main class="content-area">@yield('content')</main>
    <footer class="text-center py-3 text-muted small border-top bg-white">
        &copy; {{ date('Y') }} Task Manager — جميع الحقوق محفوظة
    </footer>
</div>
<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:1rem;border:none;box-shadow:0 20px 60px rgba(0,0,0,.2)">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div id="confirmModalIcon" class="d-flex align-items-center justify-content-center rounded-circle mx-auto mb-2" style="width:64px;height:64px;font-size:1.8rem"></div>
            </div>
            <div class="modal-body text-center px-4 py-2">
                <h5 class="fw-bold mb-2" id="confirmModalTitle"></h5>
                <p class="text-muted mb-0" id="confirmModalMessage"></p>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 justify-content-center gap-2">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn px-4" id="confirmModalBtn"></button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('sidebarToggle')?.addEventListener('click',()=>document.getElementById('sidebar').classList.toggle('show'));
document.querySelectorAll('.alert').forEach(el=>setTimeout(()=>bootstrap.Alert.getOrCreateInstance(el)?.close(),4000));

const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
let pendingForm = null;

function showConfirm({ title, message, btnText, btnClass, iconClass, iconBg, form }) {
    document.getElementById('confirmModalTitle').textContent = title;
    document.getElementById('confirmModalMessage').textContent = message;
    const btn = document.getElementById('confirmModalBtn');
    btn.textContent = btnText;
    btn.className = 'btn px-4 ' + btnClass;
    const icon = document.getElementById('confirmModalIcon');
    icon.innerHTML = '<i class="bi ' + iconClass + '"></i>';
    icon.style.background = iconBg;
    icon.style.color = '#fff';
    pendingForm = form;
    confirmModal.show();
}

document.getElementById('confirmModalBtn').addEventListener('click', () => {
    confirmModal.hide();
    if (pendingForm) pendingForm.submit();
});

document.addEventListener('click', function(e) {
    const deleteBtn = e.target.closest('[data-confirm-delete]');
    if (deleteBtn) {
        e.preventDefault();
        const form = deleteBtn.closest('form') || document.querySelector(deleteBtn.dataset.form);
        showConfirm({
            title: 'حذف المهمة',
            message: deleteBtn.dataset.confirmDelete || 'هل أنت متأكد من حذف هذه المهمة؟ لا يمكن التراجع عن هذا الإجراء.',
            btnText: 'نعم، احذف',
            btnClass: 'btn-danger',
            iconClass: 'bi-trash3-fill',
            iconBg: '#ef4444',
            form: form,
        });
    }

    const saveBtn = e.target.closest('[data-confirm-save]');
    if (saveBtn) {
        e.preventDefault();
        const formId = saveBtn.getAttribute('form');
        const form = formId ? document.getElementById(formId) : saveBtn.closest('form');
        showConfirm({
            title: 'حفظ التعديلات',
            message: 'هل أنت متأكد من حفظ التعديلات على هذه المهمة؟',
            btnText: 'نعم، احفظ',
            btnClass: 'btn-warning text-white',
            iconClass: 'bi-pencil-square',
            iconBg: '#f59e0b',
            form: form,
        });
    }
});
</script>
@stack('scripts')
</body>
</html>
