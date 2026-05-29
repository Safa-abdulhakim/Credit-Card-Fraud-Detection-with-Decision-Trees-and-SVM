<?php
namespace App\Http\Middleware;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class EnsureTaskOwner {
    public function handle(Request $request, Closure $next): Response {
        $taskId = $request->route('task');
        $task = $taskId instanceof Task ? $taskId : Task::find($taskId);
        if (!$task) abort(404, 'المهمة غير موجودة.');
        if ($task->user_id != $request->user()->id) abort(403, 'ليس لديك صلاحية الوصول لهذه المهمة.');
        return $next($request);
    }
}
