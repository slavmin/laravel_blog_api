<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UserAssignRoleAction
{
    public function handle(User $user, string $role): bool
    {
        $actor = Auth::user();

        if ($actor instanceof User && $actor->isAdmin()) {
            $user->assignRole($role);

            return true;
        }

        return false;
    }
}
