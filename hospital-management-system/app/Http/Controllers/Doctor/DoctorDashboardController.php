<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Patient;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller {
    private function getDoctor() {
        return auth()->user()->doctor;
    }

    public function index() {
        $doctor = $this->getDoctor();
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->count(),
            'total_patients' => Appointment::where('doctor_id', $doctor->id)->distinct('patient_id')->count('patient_id'),
            'pending_appointments' => Appointment::where('doctor_id', $doctor->id)->where('status', 'pending')->count(),
            'completed_today' => Appointment::where('doctor_id', $doctor->id)->whereDate('appointment_date', today())->where('status', 'completed')->count(),
        ];
        $todayAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_time')
            ->get();
        $upcomingAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>', today())
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->take(5)->get();
        return view('doctor.dashboard', compact('doctor', 'stats', 'todayAppointments', 'upcomingAppointments'));
    }

    public function appointments(Request $request) {
        $doctor = $this->getDoctor();
        $query = Appointment::with('patient')->where('doctor_id', $doctor->id);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('date')) $query->whereDate('appointment_date', $request->date);
        $appointments = $query->latest()->paginate(15);
        return view('doctor.appointments', compact('appointments'));
    }

    public function patients() {
        $doctor = $this->getDoctor();
        $patientIds = Appointment::where('doctor_id', $doctor->id)->pluck('patient_id')->unique();
        $patients = Patient::whereIn('id', $patientIds)->paginate(15);
        return view('doctor.patients', compact('patients'));
    }

    public function prescriptions() {
        $doctor = $this->getDoctor();
        $prescriptions = Prescription::with('patient')
            ->where('doctor_id', $doctor->id)->latest()->paginate(15);
        return view('doctor.prescriptions', compact('prescriptions'));
    }

    public function medicalRecords() {
        $doctor = $this->getDoctor();
        $records = MedicalRecord::with('patient')
            ->where('doctor_id', $doctor->id)->latest()->paginate(15);
        return view('doctor.medical-records', compact('records'));
    }

    public function createRecord(Appointment $appointment) {
        $appointment->load(['patient', 'doctor.user']);
        return view('doctor.create-record', compact('appointment'));
    }

    public function storeRecord(Request $request, Appointment $appointment) {
        $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'medicines' => 'nullable|array',
            'medicines.*.name' => 'required_with:medicines|string',
            'medicines.*.dosage' => 'required_with:medicines|string',
            'medicines.*.frequency' => 'required_with:medicines|string',
            'medicines.*.duration' => 'required_with:medicines|integer|min:1',
            'medicines.*.instructions' => 'nullable|string',
        ]);

        $record = MedicalRecord::create([
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'notes' => $request->notes,
            'record_date' => today(),
        ]);

        if ($request->medicines) {
            foreach ($request->medicines as $med) {
                if (!empty($med['name'])) {
                    Prescription::create([
                        'medical_record_id' => $record->id,
                        'patient_id' => $appointment->patient_id,
                        'doctor_id' => $appointment->doctor_id,
                        'medicine_name' => $med['name'],
                        'dosage' => $med['dosage'],
                        'frequency' => $med['frequency'],
                        'duration_days' => $med['duration'],
                        'instructions' => $med['instructions'] ?? null,
                    ]);
                }
            }
        }

        $appointment->update(['status' => 'completed']);
        return redirect()->route('doctor.appointments')->with('success', 'Medical record and prescriptions saved successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment) {
        $request->validate(['status' => 'required|in:approved,cancelled,completed']);
        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Appointment status updated.');
    }
}
