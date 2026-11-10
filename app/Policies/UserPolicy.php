<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }

    public function view(User $user, User $model): bool
    {
        return $user->status === 'aktif' && ($user->hasRole('admin_it') || $user->user_id === $model->user_id);
    }

    public function create(User $user): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }

    public function update(User $user, User $model): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it') && $user->user_id !== $model->user_id;
    }
}

