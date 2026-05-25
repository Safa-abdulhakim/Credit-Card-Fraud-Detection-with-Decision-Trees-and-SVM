<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;

class InventoryLogController extends Controller
{
    public function index()
    {
        $logs = InventoryLog::with(['product'])->latest()->paginate(50);
        return view('admin.logs.inventory', compact('logs'));
    }
}
