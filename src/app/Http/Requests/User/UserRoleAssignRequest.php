<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Http\Requests\Request;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Validation\Rule;
use App\Enums\Roles;

class UserRoleAssignRequest extends Request
{
    use InteractsWithInput;

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', Rule::in(Roles::rolesList())],
        ];
    }
}
