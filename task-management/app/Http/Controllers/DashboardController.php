<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $total     = $user->tasks()->count();
        $completed = $user->tasks()->where('status', 'completed')->count();
        $pending   = $user->tasks()->where('status', 'pending')->count();
        $inProgress = $user->tasks()->where('status', 'in_progress')->count();

        $recentTasks = $user->tasks()
            ->latest()
            ->limit(5)
            ->get();

        $overdueTasks = $user->tasks()
            ->whereNotNull('due_date')
            ->where('due_date', '<', today())
            ->where('status', '!=', 'completed')
            ->count();

        return view('dashboard', compact(
            'total', 'completed', 'pending', 'inProgress', 'recentTasks', 'overdueTasks'
        ));
    }
}
