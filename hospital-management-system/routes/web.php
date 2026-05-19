<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\PrescriptionController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\Patient\PatientDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect to role-based dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        if ($user->hasRole('doctor')) return redirect()->route('doctor.dashboard');
        if ($user->hasRole('receptionist')) return redirect()->route('admin.dashboard');
        return redirect()->route('patient.dashboard');
    })->name('dashboard');
});

// Admin & Receptionist Routes
Route::middleware(['auth', 'role:admin|receptionist'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Departments
    Route::resource('departments', DepartmentController::class);

    // Doctors
    Route::resource('doctors', DoctorController::class);

    // Patients
    Route::resource('patients', PatientController::class);
    Route::get('patients/{patient}/records', [PatientController::class, 'records'])->name('patients.records');

    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.status');

    // Medical Records
    Route::resource('medical-records', MedicalRecordController::class);

    // Prescriptions
    Route::resource('prescriptions', PrescriptionController::class);

    // Invoices
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');

    // Payments
    Route::resource('payments', PaymentController::class);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/patients', [ReportController::class, 'patients'])->name('reports.patients');
    Route::get('reports/appointments', [ReportController::class, 'appointments'])->name('reports.appointments');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DoctorDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/patients', [DoctorDashboardController::class, 'patients'])->name('patients');
    Route::get('/prescriptions', [DoctorDashboardController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/medical-records', [DoctorDashboardController::class, 'medicalRecords'])->name('medical-records');
    Route::get('/appointments/{appointment}/record', [DoctorDashboardController::class, 'createRecord'])->name('appointments.record');
    Route::post('/appointments/{appointment}/record', [DoctorDashboardController::class, 'storeRecord'])->name('appointments.record.store');
    Route::patch('/appointments/{appointment}/status', [DoctorDashboardController::class, 'updateStatus'])->name('appointments.status');
});

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [PatientDashboardController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/book', [PatientDashboardController::class, 'bookAppointment'])->name('appointments.book');
    Route::post('/appointments/book', [PatientDashboardController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/medical-records', [PatientDashboardController::class, 'medicalRecords'])->name('medical-records');
    Route::get('/prescriptions', [PatientDashboardController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/invoices', [PatientDashboardController::class, 'invoices'])->name('invoices');
});

require __DIR__.'/auth.php';
