<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public static function log(
        string $action,
        string $entity,
        ?string $entityId = null,
        ?array $before = null,
        ?array $after = null,
        ?string $reason = null,
        ?string $actor = null
    ): AuditLog {
        $actorName = $actor ?? (Auth::check() ? (Auth::user()->username ?? Auth::user()->nama ?? 'user_'.Auth::id()) : 'system');

        return AuditLog::create([
            'actor' => $actorName,
            'action' => $action,
            'entity' => $entity,
            'entity_id' => (string) $entityId,
            'timestamp' => now('Asia/Jakarta'),
            'before_after' => [
                'before' => $before,
                'after' => $after,
            ],
            'reason' => $reason,
        ]);
    }
}

