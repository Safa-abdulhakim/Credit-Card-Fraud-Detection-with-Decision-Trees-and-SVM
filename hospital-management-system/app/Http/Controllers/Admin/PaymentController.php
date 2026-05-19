<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    public function index() {
        $payments = Payment::with('invoice.patient')->latest()->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function create() {
        $invoices = Invoice::with('patient')->whereIn('status', ['unpaid', 'partial'])->get();
        return view('admin.payments.create', compact('invoices'));
    }

    public function store(Request $request) {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,bank_transfer,insurance',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::find($request->invoice_id);

        if ($request->amount > $invoice->remaining_amount) {
            return back()->withErrors(['amount' => 'Payment amount exceeds remaining balance.'])->withInput();
        }

        Payment::create($request->all());

        $newPaidAmount = $invoice->paid_amount + $request->amount;
        $status = $newPaidAmount >= $invoice->total_amount ? 'paid' : 'partial';
        $invoice->update(['paid_amount' => $newPaidAmount, 'status' => $status]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment) {
        $payment->load('invoice.patient');
        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment) {
        $invoices = Invoice::with('patient')->get();
        return view('admin.payments.edit', compact('payment', 'invoices'));
    }

    public function update(Request $request, Payment $payment) {
        $request->validate([
            'payment_method' => 'required|in:cash,card,bank_transfer,insurance',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $payment->update($request->only(['payment_method', 'payment_date', 'notes', 'transaction_id']));
        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment) {
        $invoice = $payment->invoice;
        $invoice->update([
            'paid_amount' => max(0, $invoice->paid_amount - $payment->amount),
            'status' => $invoice->paid_amount - $payment->amount <= 0 ? 'unpaid' : 'partial',
        ]);
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
