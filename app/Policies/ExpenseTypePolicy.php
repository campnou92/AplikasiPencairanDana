<?php

namespace App\Policies;

use App\Models\User;

class ExpenseTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->status === 'aktif';
    }

    public function view(User $user, $model): bool
    {
        return $user->status === 'aktif';
    }

    public function create(User $user): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }

    public function update(User $user, $model): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }

    public function delete(User $user, $model): bool
    {
        return $user->status === 'aktif' && $user->hasRole('admin_it');
    }
}

