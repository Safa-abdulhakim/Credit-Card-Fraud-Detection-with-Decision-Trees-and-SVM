@extends('layouts.admin')
@section('title','Settings')
@section('page-title','System Settings')
@section('content')
<div style="max-width:700px;">
    <div class="table-card">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            <h6 class="fw-bold mb-3 border-bottom pb-2">Store Settings</h6>
            <div class="mb-3"><label class="form-label">Store Name</label><input type="text" name="store_name" class="form-control" value="{{ config('app.name') }}"></div>
            <div class="mb-3"><label class="form-label">Store Email</label><input type="email" name="store_email" class="form-control" value="{{ config('mail.from.address') }}"></div>
            <div class="mb-3"><label class="form-label">Currency</label><select name="currency" class="form-select"><option value="USD">USD ($)</option><option value="EUR">EUR (€)</option><option value="GBP">GBP (£)</option></select></div>
            <h6 class="fw-bold mb-3 mt-4 border-bottom pb-2">Tax Settings</h6>
            <div class="mb-3"><label class="form-label">Default Tax Rate (%)</label><input type="number" name="tax_rate" class="form-control" value="15" step="0.1"></div>
            <h6 class="fw-bold mb-3 mt-4 border-bottom pb-2">Commission</h6>
            <div class="mb-4"><label class="form-label">Default Vendor Commission (%)</label><input type="number" name="commission_rate" class="form-control" value="10" step="0.1"></div>
            <button type="submit" class="btn btn-primary px-5">Save Settings</button>
        </form>
    </div>
</div>
@endsection
