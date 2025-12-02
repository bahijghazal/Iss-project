<?php

namespace App\Helpers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogHelper
{
    /**
     * Log a user event
     *
     * @param string $event
     * @param array|string|null $meta
     */
    public static function log($event, $meta = null)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'meta' => is_array($meta) ? json_encode($meta) : $meta,
            'ip' => Request::ip(),
        ]);
    }
}
