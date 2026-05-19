<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller {
    public function index(Request $request) {
        $query = Patient::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        $patients = $query->latest()->paginate(15);
        return view('admin.patients.index', compact('patients'));
    }

    public function create() {
        return view('admin.patients.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients',
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        Patient::create($request->all());
        return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient) {
        $patient->load(['appointments.doctor.user', 'medicalRecords.doctor.user', 'prescriptions', 'invoices']);
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient) {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient) {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:patients,email,' . $patient->id,
            'address' => 'nullable|string',
            'blood_group' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
        ]);

        $patient->update($request->all());
        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient) {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }

    public function records(Patient $patient) {
        $patient->load(['medicalRecords.doctor.user', 'prescriptions.doctor.user']);
        return view('admin.patients.records', compact('patient'));
    }
}
