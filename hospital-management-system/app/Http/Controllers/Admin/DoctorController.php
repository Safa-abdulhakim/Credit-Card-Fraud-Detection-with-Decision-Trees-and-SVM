<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller {
    public function index(Request $request) {
        $query = Doctor::with(['user', 'department']);
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                ->orWhere('specialization', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }
        $doctors = $query->paginate(15);
        $departments = Department::all();
        return view('admin.doctors.index', compact('doctors', 'departments'));
    }

    public function create() {
        $departments = Department::where('is_active', true)->get();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'phone' => 'nullable|string|max:20',
            'consultation_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('doctor');

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'phone' => $request->phone,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'bio' => $request->bio,
            'photo' => $photoPath,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor) {
        $doctor->load(['user', 'department', 'appointments.patient']);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor) {
        $departments = Department::where('is_active', true)->get();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'department_id' => 'required|exists:departments,id',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'phone' => 'nullable|string|max:20',
            'consultation_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $doctor->user->update(['name' => $request->name, 'email' => $request->email]);

        if ($request->hasFile('photo')) {
            if ($doctor->photo) Storage::disk('public')->delete($doctor->photo);
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $doctor->photo = $photoPath;
        }

        $doctor->update([
            'department_id' => $request->department_id,
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'phone' => $request->phone,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'bio' => $request->bio,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor) {
        if ($doctor->photo) Storage::disk('public')->delete($doctor->photo);
        $doctor->user->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
