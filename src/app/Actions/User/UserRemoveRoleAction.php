<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class UserRemoveRoleAction
{
    public function handle(User $user, string $role): bool
    {
        $actor = Auth::user();

        if ($actor instanceof User && $actor->isAdmin()) {
            $user->removeRole($user);

            return true;
        }

        return false;
    }
}
