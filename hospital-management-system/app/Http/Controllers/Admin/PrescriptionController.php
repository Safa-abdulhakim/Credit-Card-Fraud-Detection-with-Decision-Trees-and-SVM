<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PrescriptionController extends Controller {
    public function index() {
        $prescriptions = Prescription::with(['patient', 'doctor.user', 'medicalRecord'])->latest()->paginate(15);
        $doctors = Doctor::with('user')->get();
        return view('admin.prescriptions.index', compact('prescriptions', 'doctors'));
    }

    public function create() {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $medicalRecords = MedicalRecord::with('patient')->latest()->get();
        return view('admin.prescriptions.create', compact('patients', 'doctors', 'medicalRecords'));
    }

    public function store(Request $request) {
        $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'frequency' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
        ]);
        Prescription::create($request->all());
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription created successfully.');
    }

    public function show(Prescription $prescription) {
        $prescription->load(['patient', 'doctor.user', 'medicalRecord']);
        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription) {
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        $medicalRecords = MedicalRecord::with('patient')->latest()->get();
        return view('admin.prescriptions.edit', compact('prescription', 'patients', 'doctors', 'medicalRecords'));
    }

    public function update(Request $request, Prescription $prescription) {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'frequency' => 'required|string|max:100',
            'duration_days' => 'required|integer|min:1',
            'instructions' => 'nullable|string',
        ]);
        $prescription->update($request->all());
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription updated successfully.');
    }

    public function destroy(Prescription $prescription) {
        $prescription->delete();
        return redirect()->route('admin.prescriptions.index')->with('success', 'Prescription deleted successfully.');
    }
}
