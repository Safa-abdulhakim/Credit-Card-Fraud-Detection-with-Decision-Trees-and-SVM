@extends('layouts.patient')
@section('title', 'حجز موعد')
@section('page-title', 'حجز موعد جديد')
@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0">اختر الطبيب وحدد موعد زيارتك</h6></div>
    <div class="card-body">
        <form action="{{ route('patient.appointments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label fw-semibold">اختر طبيباً <span class="text-danger">*</span></label>
                <div class="row g-2">
                    @foreach($doctors as $doc)
                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="d-block h-100">
                            <input type="radio" name="doctor_id" value="{{ $doc->id }}" class="d-none doctor-radio" {{ old('doctor_id') == $doc->id ? 'checked' : '' }}>
                            <div class="card doctor-card border-2 {{ old('doctor_id') == $doc->id ? 'border-primary' : '' }} h-100" style="cursor:pointer;transition:all 0.2s;">
                                <div class="card-body text-center p-3">
                                    @if($doc->photo)
                                        <img src="{{ asset('storage/' . $doc->photo) }}" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:60px;height:60px;font-size:1.2rem;font-weight:700;">
                                            {{ strtoupper(substr($doc->user->name ?? 'D', 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="fw-semibold small">{{ $doc->user->name ?? 'N/A' }}</div>
                                    <div class="text-primary small">{{ $doc->specialization }}</div>
                                    <div class="text-muted small">{{ $doc->department->name ?? '' }}</div>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-dark">${{ number_format($doc->consultation_fee, 2) }}</span>
                                        <span class="badge bg-light text-dark">{{ $doc->experience_years }} سنة خبرة</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
                @error('doctor_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">التاريخ المفضل <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الوقت المفضل <span class="text-danger">*</span></label>
                    <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time', '09:00') }}" required>
                    @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">صف أعراضك</label>
                    <textarea name="symptoms" class="form-control" rows="3" placeholder="ما الذي تشعر به؟ يرجى وصف أعراضك...">{{ old('symptoms') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-2"></i>
                        سيتم تقديم موعدك بحالة <strong>معلق</strong>. سيقوم فريق الاستقبال بتأكيده قريباً.
                    </div>
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-calendar-check me-2"></i>حجز موعد</button>
                    <a href="{{ route('patient.dashboard') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.querySelectorAll('.doctor-radio').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.doctor-card').forEach(c => { c.classList.remove('border-primary'); c.style.background = ''; });
        if (this.checked) { const card = this.nextElementSibling; card.classList.add('border-primary'); card.style.background = '#f0f7ff'; }
    });
    if (radio.checked) { const card = radio.nextElementSibling; card.classList.add('border-primary'); card.style.background = '#f0f7ff'; }
});
</script>
@endpush
