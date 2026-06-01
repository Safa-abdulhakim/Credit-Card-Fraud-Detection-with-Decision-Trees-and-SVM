@php $isAr = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'ShopMart') }}</title>
        @if($isAr)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
        @else
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: {{ $isAr ? "'Cairo', 'Segoe UI', sans-serif" : "'Segoe UI', sans-serif" }}; background: #f0f2f5; }
        </style>
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4 px-3">
            <div class="mb-4 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none">
                    <h3 class="fw-bold text-primary"><i class="fas fa-shopping-bag me-2"></i>ShopMart</h3>
                </a>
            </div>
            <div class="w-100 bg-white shadow-sm rounded-3 p-4" style="max-width:400px;">
                {{ $slot }}
            </div>
            <div class="mt-3">
                <form action="{{ route('locale.switch') }}" method="POST" class="d-inline">
                    @csrf
                    @if($isAr)
                        <input type="hidden" name="locale" value="en">
                        <button type="submit" class="btn btn-link text-muted small text-decoration-none p-0"><i class="fas fa-globe me-1"></i>English</button>
                    @else
                        <input type="hidden" name="locale" value="ar">
                        <button type="submit" class="btn btn-link text-muted small text-decoration-none p-0"><i class="fas fa-globe me-1"></i>العربية</button>
                    @endif
                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
