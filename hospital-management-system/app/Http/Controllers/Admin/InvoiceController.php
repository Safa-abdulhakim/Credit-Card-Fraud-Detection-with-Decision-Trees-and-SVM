<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class InvoiceController extends Controller {
    public function index(Request $request) {
        $query = Invoice::with(['patient', 'appointment']);
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%')
                ->orWhereHas('patient', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $invoices = $query->latest()->paginate(15);
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create() {
        $patients = Patient::all();
        $appointments = Appointment::with(['patient', 'doctor.user'])->where('status', 'completed')->get();
        return view('admin.invoices.create', compact('patients', 'appointments'));
    }

    public function store(Request $request) {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_fee' => 'nullable|numeric|min:0',
            'medicine_fee' => 'nullable|numeric|min:0',
            'test_fee' => 'nullable|numeric|min:0',
            'other_fee' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $totalAmount = ($request->consultation_fee ?? 0) + ($request->medicine_fee ?? 0)
            + ($request->test_fee ?? 0) + ($request->other_fee ?? 0)
            - ($request->discount ?? 0);

        Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'medicine_fee' => $request->medicine_fee ?? 0,
            'test_fee' => $request->test_fee ?? 0,
            'other_fee' => $request->other_fee ?? 0,
            'total_amount' => max(0, $totalAmount),
            'discount' => $request->discount ?? 0,
            'paid_amount' => 0,
            'status' => 'unpaid',
            'notes' => $request->notes,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice) {
        $invoice->load(['patient', 'appointment.doctor.user', 'payments']);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice) {
        $patients = Patient::all();
        $appointments = Appointment::with(['patient', 'doctor.user'])->get();
        return view('admin.invoices.edit', compact('invoice', 'patients', 'appointments'));
    }

    public function update(Request $request, Invoice $invoice) {
        $request->validate([
            'consultation_fee' => 'nullable|numeric|min:0',
            'medicine_fee' => 'nullable|numeric|min:0',
            'test_fee' => 'nullable|numeric|min:0',
            'other_fee' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $totalAmount = ($request->consultation_fee ?? 0) + ($request->medicine_fee ?? 0)
            + ($request->test_fee ?? 0) + ($request->other_fee ?? 0)
            - ($request->discount ?? 0);

        $invoice->update([
            'consultation_fee' => $request->consultation_fee ?? 0,
            'medicine_fee' => $request->medicine_fee ?? 0,
            'test_fee' => $request->test_fee ?? 0,
            'other_fee' => $request->other_fee ?? 0,
            'total_amount' => max(0, $totalAmount),
            'discount' => $request->discount ?? 0,
            'notes' => $request->notes,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice) {
        $invoice->delete();
        return redirect()->route('admin.invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    public function print(Invoice $invoice) {
        $invoice->load(['patient', 'appointment.doctor.user', 'payments']);
        return view('admin.invoices.print', compact('invoice'));
    }
}
