<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller {
    public function index() {
        $departments = Department::withCount('doctors')->paginate(15);
        return view('admin.departments.index', compact('departments'));
    }

    public function create() {
        return view('admin.departments.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'description' => 'nullable|string',
            'head_doctor' => 'nullable|string|max:255',
        ]);
        Department::create($request->all());
        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    public function show(Department $department) {
        $department->load('doctors.user');
        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department) {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department) {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string',
            'head_doctor' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);
        $department->update($request->all());
        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department) {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }
}
