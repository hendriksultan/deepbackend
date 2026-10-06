<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Menentukan siapa yang bisa mengedit user.
     */
    public function update(User $user, User $model): bool
    {
        // Izinkan admin mengedit Guru atau Santri
        if (in_array($model->role, ['teacher', 'student'])) {
            return true;
        }

        // Jika sesama Admin, hanya boleh edit akunnya sendiri
        if ($model->role === 'admin') {
            return $user->id === $model->id;
        }

        return false;
    }

    /**
     * Menentukan siapa yang bisa menghapus user.
     */
    public function delete(User $user, User $model): bool
    {
        // Izinkan admin menghapus Guru atau Santri
        if (in_array($model->role, ['teacher', 'student'])) {
            return true;
        }

        // Admin dilarang menghapus sesama Admin atau dirinya sendiri
        return false;
    }

    public function deleteAny(User $user): bool
    {
        return $user->role === 'admin';
    }
}