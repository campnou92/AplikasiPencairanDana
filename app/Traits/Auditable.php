<?php

namespace App\Traits;

use App\Services\AuditService;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function ($model) {
            $after = $model->getAttributes();
            unset($after['created_at'], $after['updated_at']);
            if (isset($after['password'])) {
                $after['password'] = '********';
            }

            AuditService::log(
                action: 'created',
                entity: class_basename($model),
                entityId: (string) $model->getKey(),
                before: null,
                after: $after,
                reason: request()?->input('audit_reason')
            );
        });

        static::updated(function ($model) {
            $dirty = $model->getDirty();
            unset($dirty['created_at'], $dirty['updated_at']);
            if (empty($dirty)) {
                return;
            }

            $before = [];
            $after = [];
            foreach ($dirty as $key => $newValue) {
                $oldValue = $model->getOriginal($key);
                if ($key === 'password') {
                    $oldValue = '********';
                    $newValue = '********';
                }
                $before[$key] = $oldValue;
                $after[$key] = $newValue;
            }

            AuditService::log(
                action: 'updated',
                entity: class_basename($model),
                entityId: (string) $model->getKey(),
                before: $before,
                after: $after,
                reason: request()?->input('audit_reason')
            );
        });

        static::deleted(function ($model) {
            $before = $model->getOriginal();
            unset($before['created_at'], $before['updated_at']);
            if (isset($before['password'])) {
                $before['password'] = '********';
            }

            AuditService::log(
                action: 'deleted',
                entity: class_basename($model),
                entityId: (string) $model->getKey(),
                before: $before,
                after: null,
                reason: request()?->input('audit_reason')
            );
        });
    }

    public function recordCustomAudit(string $action, ?string $reason = null, ?array $before = null, ?array $after = null): void
    {
        AuditService::log(
            action: $action,
            entity: class_basename($this),
            entityId: (string) $this->getKey(),
            before: $before,
            after: $after,
            reason: $reason
        );
    }
}

