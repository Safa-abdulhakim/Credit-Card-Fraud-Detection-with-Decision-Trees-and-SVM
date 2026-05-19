@extends('layouts.doctor')
@section('title', 'Add Medical Record')
@section('page-title', 'Add Medical Record')
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Appointment Info</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;font-size:1rem;font-weight:700;">
                        {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $appointment->patient->name ?? 'N/A' }}</div>
                        <small class="text-muted">{{ $appointment->patient->phone ?? '' }}</small>
                    </div>
                </div>
                <hr>
                <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">Date:</span><strong class="small">{{ $appointment->appointment_date->format('M d, Y') }}</strong></div>
                <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">Time:</span><strong class="small">{{ $appointment->appointment_time }}</strong></div>
                <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">Type:</span><span class="badge bg-light text-dark">{{ ucfirst($appointment->type) }}</span></div>
                @if($appointment->symptoms)
                <div class="mt-2"><p class="text-muted small mb-1">Symptoms:</p><p class="small bg-light p-2 rounded">{{ $appointment->symptoms }}</p></div>
                @endif
                @if($appointment->patient->allergies)
                <div class="mt-2"><p class="text-danger small mb-1"><i class="fas fa-exclamation-triangle me-1"></i>Allergies:</p><p class="small">{{ $appointment->patient->allergies }}</p></div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header"><h6 class="mb-0">Medical Record & Prescriptions</h6></div>
            <div class="card-body">
                <form action="{{ route('doctor.appointments.record.store', $appointment) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Diagnosis <span class="text-danger">*</span></label>
                        <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3" required>{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Treatment Plan <span class="text-danger">*</span></label>
                        <textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror" rows="3" required>{{ old('treatment') }}</textarea>
                        @error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                    </div>
                    <hr>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-semibold mb-0"><i class="fas fa-prescription-bottle-alt me-2 text-primary"></i>Prescriptions <small class="text-muted fw-normal">(optional)</small></h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPrescription()"><i class="fas fa-plus me-1"></i>Add Medicine</button>
                    </div>
                    <div id="prescriptions-container">
                        <div class="prescription-row border rounded p-3 mb-2 bg-light">
                            <div class="row g-2">
                                <div class="col-md-6"><label class="form-label small">Medicine Name</label><input type="text" name="medicines[0][name]" class="form-control form-control-sm" placeholder="e.g. Amoxicillin"></div>
                                <div class="col-md-3"><label class="form-label small">Dosage</label><input type="text" name="medicines[0][dosage]" class="form-control form-control-sm" placeholder="e.g. 1 tab"></div>
                                <div class="col-md-3"><label class="form-label small">Frequency</label><input type="text" name="medicines[0][frequency]" class="form-control form-control-sm" placeholder="3x daily"></div>
                                <div class="col-md-3"><label class="form-label small">Duration (days)</label><input type="number" name="medicines[0][duration]" class="form-control form-control-sm" placeholder="7" min="1"></div>
                                <div class="col-md-9"><label class="form-label small">Instructions</label><input type="text" name="medicines[0][instructions]" class="form-control form-control-sm" placeholder="Take after meals"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save & Complete Appointment</button>
                        <a href="{{ route('doctor.appointments') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
let rxCount = 1;
function addPrescription() {
    const c = document.getElementById('prescriptions-container');
    const d = document.createElement('div');
    d.className = 'prescription-row border rounded p-3 mb-2 bg-light position-relative';
    d.innerHTML = `<button type="button" class="btn-close position-absolute top-0 end-0 m-2" onclick="this.closest('.prescription-row').remove()"></button>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label small">Medicine Name</label><input type="text" name="medicines[${rxCount}][name]" class="form-control form-control-sm" placeholder="Medicine name"></div>
            <div class="col-md-3"><label class="form-label small">Dosage</label><input type="text" name="medicines[${rxCount}][dosage]" class="form-control form-control-sm" placeholder="Dosage"></div>
            <div class="col-md-3"><label class="form-label small">Frequency</label><input type="text" name="medicines[${rxCount}][frequency]" class="form-control form-control-sm" placeholder="Frequency"></div>
            <div class="col-md-3"><label class="form-label small">Duration (days)</label><input type="number" name="medicines[${rxCount}][duration]" class="form-control form-control-sm" min="1"></div>
            <div class="col-md-9"><label class="form-label small">Instructions</label><input type="text" name="medicines[${rxCount}][instructions]" class="form-control form-control-sm"></div>
        </div>`;
    c.appendChild(d); rxCount++;
}
</script>
@endpush
