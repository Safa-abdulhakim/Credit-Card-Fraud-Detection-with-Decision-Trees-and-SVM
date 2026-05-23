<?php
namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
class TaskController extends Controller {
    public function index(Request $request) {
        $query = $request->user()->tasks();
        if ($search = $request->input('search')) $query->where('title','like',"%{$search}%");
        if ($status = $request->input('status')) $query->where('status',$status);
        if ($priority = $request->input('priority')) $query->where('priority',$priority);
        $tasks = $query->latest()->paginate(10)->withQueryString();
        return view('tasks.index', compact('tasks'));
    }
    public function create() { return view('tasks.create'); }
    public function store(Request $request) {
        $validated = $request->validate(['title'=>'required|string|max:255','description'=>'nullable|string','status'=>'required|in:pending,in_progress,completed','priority'=>'required|in:low,medium,high','due_date'=>'nullable|date|after_or_equal:today']);
        $request->user()->tasks()->create($validated);
        return redirect()->route('tasks.index')->with('success','تم إضافة المهمة بنجاح!');
    }
    public function show(Task $task) { return view('tasks.show', compact('task')); }
    public function edit(Task $task) { return view('tasks.edit', compact('task')); }
    public function update(Request $request, Task $task) {
        $validated = $request->validate(['title'=>'required|string|max:255','description'=>'nullable|string','status'=>'required|in:pending,in_progress,completed','priority'=>'required|in:low,medium,high','due_date'=>'nullable|date']);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success','تم تعديل المهمة بنجاح!');
    }
    public function destroy(Task $task) {
        $task->delete();
        return redirect()->route('tasks.index')->with('success','تم حذف المهمة بنجاح!');
    }
}
