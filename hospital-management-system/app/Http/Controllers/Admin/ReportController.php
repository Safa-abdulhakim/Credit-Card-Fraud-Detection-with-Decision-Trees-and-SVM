<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index() {
        return view('admin.reports.index');
    }

    public function patients(Request $request) {
        $query = Patient::query();
        if ($request->filled('from')) $query->whereDate('created_at', '>=', $request->from);
        if ($request->filled('to')) $query->whereDate('created_at', '<=', $request->to);
        $patients = $query->paginate(20);
        $totalPatients = $query->count();
        $genderStats = Patient::selectRaw('gender, COUNT(*) as count')->groupBy('gender')->pluck('count', 'gender');
        return view('admin.reports.patients', compact('patients', 'totalPatients', 'genderStats'));
    }

    public function appointments(Request $request) {
        $query = Appointment::with(['patient', 'doctor.user']);
        if ($request->filled('from')) $query->whereDate('appointment_date', '>=', $request->from);
        if ($request->filled('to')) $query->whereDate('appointment_date', '<=', $request->to);
        if ($request->filled('status')) $query->where('status', $request->status);
        $appointments = $query->latest()->paginate(20);
        $statusStats = Appointment::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');
        return view('admin.reports.appointments', compact('appointments', 'statusStats'));
    }

    public function revenue(Request $request) {
        $from = $request->from ? Carbon::parse($request->from) : Carbon::now()->startOfMonth();
        $to = $request->to ? Carbon::parse($request->to) : Carbon::now()->endOfMonth();

        $totalRevenue = Invoice::where('status', 'paid')->whereBetween('created_at', [$from, $to])->sum('total_amount');
        $pendingRevenue = Invoice::whereIn('status', ['unpaid', 'partial'])->sum('remaining_amount');

        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('total_amount'),
            ];
        }

        $invoices = Invoice::with('patient')->whereBetween('created_at', [$from, $to])->latest()->paginate(20);

        return view('admin.reports.revenue', compact('totalRevenue', 'pendingRevenue', 'monthlyData', 'invoices', 'from', 'to'));
    }
}
