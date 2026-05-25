<?php
namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function log(string $action, ?int $userId = null, ?string $modelType = null, ?int $modelId = null, array $oldValues = [], array $newValues = []): void
    {
        ActivityLog::create([
            'user_id'    => $userId ?? auth()->id(),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'old_values' => empty($oldValues) ? null : $oldValues,
            'new_values' => empty($newValues) ? null : $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
