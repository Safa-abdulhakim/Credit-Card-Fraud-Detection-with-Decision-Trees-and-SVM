<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller {
    private function getPatient() {
        return auth()->user()->patient;
    }

    public function index() {
        $patient = $this->getPatient();
        if (!$patient) {
            return view('patient.no-profile');
        }
        $stats = [
            'total_appointments' => Appointment::where('patient_id', $patient->id)->count(),
            'upcoming_appointments' => Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>=', today())->where('status', '!=', 'cancelled')->count(),
            'total_prescriptions' => Prescription::where('patient_id', $patient->id)->count(),
            'pending_invoices' => Invoice::where('patient_id', $patient->id)->whereIn('status', ['unpaid', 'partial'])->count(),
        ];
        $recentAppointments = Appointment::with('doctor.user')
            ->where('patient_id', $patient->id)->latest()->take(5)->get();
        $recentPrescriptions = Prescription::with('doctor.user')
            ->where('patient_id', $patient->id)->latest()->take(5)->get();
        return view('patient.dashboard', compact('patient', 'stats', 'recentAppointments', 'recentPrescriptions'));
    }

    public function appointments(Request $request) {
        $patient = $this->getPatient();
        $query = Appointment::with('doctor.user')->where('patient_id', $patient->id);
        if ($request->filled('status')) $query->where('status', $request->status);
        $appointments = $query->latest()->paginate(10);
        return view('patient.appointments', compact('appointments'));
    }

    public function bookAppointment() {
        $doctors = Doctor::with(['user', 'department'])->where('is_available', true)->get();
        return view('patient.book-appointment', compact('doctors'));
    }

    public function storeAppointment(Request $request) {
        $patient = $this->getPatient();
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'symptoms' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'symptoms' => $request->symptoms,
            'status' => 'pending',
        ]);

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully! Please wait for approval.');
    }

    public function medicalRecords() {
        $patient = $this->getPatient();
        $records = MedicalRecord::with('doctor.user')->where('patient_id', $patient->id)->latest()->paginate(10);
        return view('patient.medical-records', compact('records'));
    }

    public function prescriptions() {
        $patient = $this->getPatient();
        $prescriptions = Prescription::with('doctor.user')->where('patient_id', $patient->id)->latest()->paginate(10);
        return view('patient.prescriptions', compact('prescriptions'));
    }

    public function invoices() {
        $patient = $this->getPatient();
        $invoices = Invoice::where('patient_id', $patient->id)->latest()->paginate(10);
        return view('patient.invoices', compact('invoices'));
    }
}
