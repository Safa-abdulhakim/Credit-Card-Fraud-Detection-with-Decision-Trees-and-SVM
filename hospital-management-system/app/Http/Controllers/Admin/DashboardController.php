<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_appointments' => Appointment::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
            'total_departments' => Department::count(),
            'monthly_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', now()->month)->sum('total_amount'),
        ];

        // Monthly appointments for chart (last 6 months)
        $monthlyAppointments = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            $monthlyAppointments[] = Appointment::whereYear('appointment_date', $month->year)
                ->whereMonth('appointment_date', $month->month)->count();
        }

        // Monthly revenue for chart
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyRevenue[] = Invoice::where('status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total_amount');
        }

        $recentAppointments = Appointment::with(['patient', 'doctor.user'])
            ->latest()->take(10)->get();

        $recentPatients = Patient::latest()->take(5)->get();

        $appointmentsByStatus = [
            'pending' => Appointment::where('status', 'pending')->count(),
            'approved' => Appointment::where('status', 'approved')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', compact(
            'stats', 'monthlyLabels', 'monthlyAppointments', 'monthlyRevenue',
            'recentAppointments', 'recentPatients', 'appointmentsByStatus'
        ));
    }
}
