<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller {
    public function index() {
        $records = MedicalRecord::with(['patient', 'doctor.user'])->latest()->paginate(15);
        $doctors = Doctor::with('user')->get();
        return view('admin.medical-records.index', compact('records', 'doctors'));
    }

    public function create() {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $appointments = Appointment::with(['patient', 'doctor.user'])->where('status', 'approved')->get();
        return view('admin.medical-records.create', compact('patients', 'doctors', 'appointments'));
    }

    public function store(Request $request) {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
        ]);
        $record = MedicalRecord::create($request->all());
        if ($request->appointment_id) {
            Appointment::find($request->appointment_id)->update(['status' => 'completed']);
        }
        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record created successfully.');
    }

    public function show(MedicalRecord $medicalRecord) {
        $medicalRecord->load(['patient', 'doctor.user', 'appointment', 'prescriptions']);
        return view('admin.medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord) {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        return view('admin.medical-records.edit', compact('medicalRecord', 'patients', 'doctors'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord) {
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'record_date' => 'required|date',
        ]);
        $medicalRecord->update($request->all());
        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord) {
        $medicalRecord->delete();
        return redirect()->route('admin.medical-records.index')->with('success', 'Medical record deleted successfully.');
    }
}
