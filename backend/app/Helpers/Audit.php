<?php

namespace App\Helpers;

use App\Models\AuditLog;

class Audit
{
    public static function log($user, $action, $meta = [])
    {
        AuditLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'meta' => $meta
        ]);
    }
}