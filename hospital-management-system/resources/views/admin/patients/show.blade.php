@extends('layouts.admin')
@section('title', 'ملف المريض')
@section('page-title', $patient->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">المرضى</a></li>
    <li class="breadcrumb-item active">{{ $patient->name }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-success btn-sm">
            <i class="fas fa-calendar-plus me-1"></i>حجز موعد
        </a>
        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>تعديل
        </a>
    </div>
@endsection
@section('content')
<div class="row g-3">
    <!-- Patient Profile Card -->
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:90px;height:90px;font-size:2rem;font-weight:700;">
                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $patient->name }}</h5>
                <p class="text-muted mb-3 small">
                    رقم المريض: #{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}
                </p>
                @if($patient->blood_group)
                    <span class="badge bg-danger me-1">{{ $patient->blood_group }}</span>
                @endif
                <span class="badge bg-{{ $patient->gender == 'male' ? 'primary' : 'info' }}">{{ ucfirst($patient->gender) }}</span>
            </div>
            <div class="card-body border-top pt-3">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center mb-2">
                        <i class="fas fa-birthday-cake text-muted me-2" style="width:18px;"></i>
                        <span class="small">
                            {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}
                            @if($patient->age)
                                <span class="text-muted">({{ $patient->age }} سنة)</span>
                            @endif
                        </span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone text-muted me-2" style="width:18px;"></i>
                        <span class="small">{{ $patient->phone }}</span>
                    </li>
                    @if($patient->email)
                    <li class="d-flex align-items-center mb-2">
                        <i class="fas fa-envelope text-muted me-2" style="width:18px;"></i>
                        <span class="small">{{ $patient->email }}</span>
                    </li>
                    @endif
                    @if($patient->address)
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-map-marker-alt text-muted me-2 mt-1" style="width:18px;"></i>
                        <span class="small">{{ $patient->address }}</span>
                    </li>
                    @endif
                    @if($patient->emergency_contact)
                    <li class="d-flex align-items-start mb-2">
                        <i class="fas fa-phone-alt text-danger me-2 mt-1" style="width:18px;"></i>
                        <div>
                            <div class="small fw-semibold text-danger">جهة الاتصال في الطوارئ</div>
                            <div class="small">{{ $patient->emergency_contact }}</div>
                        </div>
                    </li>
                    @endif
                    <li class="d-flex align-items-center mb-2">
                        <i class="fas fa-calendar text-muted me-2" style="width:18px;"></i>
                        <span class="small text-muted">تاريخ التسجيل: {{ $patient->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if($patient->allergies || $patient->medical_history)
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-notes-medical me-2 text-warning"></i>ملاحظات طبية</h6>
            </div>
            <div class="card-body">
                @if($patient->allergies)
                <div class="mb-3">
                    <div class="fw-semibold small text-danger mb-1"><i class="fas fa-exclamation-triangle me-1"></i>الحساسية</div>
                    <p class="small mb-0">{{ $patient->allergies }}</p>
                </div>
                @endif
                @if($patient->medical_history)
                <div>
                    <div class="fw-semibold small text-info mb-1"><i class="fas fa-history me-1"></i>التاريخ المرضي</div>
                    <p class="small mb-0">{{ $patient->medical_history }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Stats -->
        <div class="card mt-3">
            <div class="card-body p-3">
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-primary">{{ $patient->appointments->count() }}</div>
                        <small class="text-muted">الزيارات</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-info">{{ $patient->medicalRecords->count() }}</div>
                        <small class="text-muted">السجلات</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold fs-5 text-success">{{ $patient->invoices->count() }}</div>
                        <small class="text-muted">الفواتير</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="col-12 col-lg-8">
        <ul class="nav nav-tabs mb-3" id="patientTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#appointments-tab" type="button">
                    <i class="fas fa-calendar-check me-1"></i>المواعيد
                    <span class="badge bg-primary ms-1">{{ $patient->appointments->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#records-tab" type="button">
                    <i class="fas fa-file-medical me-1"></i>السجلات الطبية
                    <span class="badge bg-info ms-1">{{ $patient->medicalRecords->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#prescriptions-tab" type="button">
                    <i class="fas fa-prescription-bottle-alt me-1"></i>الوصفات الطبية
                    <span class="badge bg-warning ms-1">{{ $patient->prescriptions->count() }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#invoices-tab" type="button">
                    <i class="fas fa-file-invoice-dollar me-1"></i>الفواتير
                    <span class="badge bg-success ms-1">{{ $patient->invoices->count() }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Appointments Tab -->
            <div class="tab-pane fade show active" id="appointments-tab">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">سجل المواعيد</h6>
                        <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>حجز
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>التاريخ والوقت</th>
                                        <th>طبيب</th>
                                        <th>السبب</th>
                                        <th>الحالة</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patient->appointments->sortByDesc('appointment_date') as $appt)
                                    <tr>
                                        <td>
                                            <div class="small fw-semibold">{{ $appt->appointment_date->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $appt->appointment_time }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $appt->doctor->user->name ?? 'N/A' }}</small><br>
                                            <small class="text-muted">{{ $appt->doctor->specialization ?? '' }}</small>
                                        </td>
                                        <td><small>{{ Str::limit($appt->reason, 40) ?? '-' }}</small></td>
                                        <td>
                                            @php
                                                $colors = ['pending' => 'warning', 'approved' => 'info', 'completed' => 'success', 'cancelled' => 'danger'];
                                            @endphp
                                            <span class="badge bg-{{ $colors[$appt->status] ?? 'secondary' }}">
                                                {{ ucfirst($appt->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">لا توجد مواعيد</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medical Records Tab -->
            <div class="tab-pane fade" id="records-tab">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">السجلات الطبية</h6>
                        <a href="{{ route('admin.medical-records.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>إضافة سجل
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>التشخيص</th>
                                        <th>طبيب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patient->medicalRecords->sortByDesc('visit_date') as $record)
                                    <tr>
                                        <td><small>{{ $record->visit_date->format('M d, Y') }}</small></td>
                                        <td><small>{{ Str::limit($record->diagnosis, 60) }}</small></td>
                                        <td><small>{{ $record->doctor->user->name ?? 'N/A' }}</small></td>
                                        <td>
                                            <a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">لا توجد سجلات طبية</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions Tab -->
            <div class="tab-pane fade" id="prescriptions-tab">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">الوصفات الطبية</h6>
                        <a href="{{ route('admin.prescriptions.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>إضافة وصفة
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>طبيب</th>
                                        <th>الأدوية</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patient->prescriptions->sortByDesc('prescribed_date') as $rx)
                                    <tr>
                                        <td><small>{{ $rx->prescribed_date->format('M d, Y') }}</small></td>
                                        <td><small>{{ $rx->doctor->user->name ?? 'N/A' }}</small></td>
                                        <td><small>{{ Str::limit($rx->medications, 60) }}</small></td>
                                        <td>
                                            <a href="{{ route('admin.prescriptions.show', $rx) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">لا توجد وصفات طبية</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoices Tab -->
            <div class="tab-pane fade" id="invoices-tab">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">الفواتير والمدفوعات</h6>
                        <a href="{{ route('admin.invoices.create', ['patient_id' => $patient->id]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus me-1"></i>إنشاء فاتورة
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>التاريخ</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patient->invoices->sortByDesc('invoice_date') as $inv)
                                    <tr>
                                        <td><small class="fw-semibold">{{ $inv->invoice_number }}</small></td>
                                        <td><small>{{ $inv->invoice_date->format('M d, Y') }}</small></td>
                                        <td><small class="fw-semibold">${{ number_format($inv->total_amount, 2) }}</small></td>
                                        <td>
                                            @php
                                                $statusColors = ['unpaid' => 'warning', 'paid' => 'success', 'partial' => 'info', 'cancelled' => 'danger'];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$inv->status] ?? 'secondary' }}">
                                                {{ ucfirst($inv->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.invoices.show', $inv) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">لا توجد فواتير</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if($patient->invoices->count())
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <span class="text-muted small">إجمالي المبلغ المفوتر:</span>
                        <span class="fw-bold">${{ number_format($patient->invoices->sum('total_amount'), 2) }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
