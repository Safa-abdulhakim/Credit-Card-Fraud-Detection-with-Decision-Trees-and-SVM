<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller {
    public function index(Request $request) {
        $query = Appointment::with(['patient', 'doctor.user']);
        if ($request->filled('search')) {
            $query->whereHas('patient', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }
        if ($request->filled('doctor')) {
            $query->where('doctor_id', $request->doctor);
        }
        $appointments = $query->latest()->paginate(15);
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.index', compact('appointments', 'doctors'));
    }

    public function create() {
        $patients = Patient::all();
        $doctors = Doctor::with(['user', 'department'])->where('is_available', true)->get();
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request) {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
            'type' => 'nullable|string',
        ]);

        Appointment::create($request->all());
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment) {
        $appointment->load(['patient', 'doctor.user', 'medicalRecord.prescriptions']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment) {
        $patients = Patient::all();
        $doctors = Doctor::with(['user', 'department'])->get();
        return view('admin.appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment) {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($request->all());
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment) {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment) {
        $request->validate(['status' => 'required|in:pending,approved,completed,cancelled']);
        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Appointment status updated.');
    }
}
