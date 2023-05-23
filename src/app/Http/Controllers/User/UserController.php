<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

use App\Actions\User\UserAssignRoleAction;
use App\Actions\User\UserRemoveRoleAction;
use App\Http\Requests\User\UserRoleAssignRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::withTrashed()->get();

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // $this->authorize(UserPolicy::CREATE, User::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $this->authorize(UserPolicy::UPDATE, $user);

        // $user->update();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize(UserPolicy::DELETE, $user);

        // $user->delete();

        return response()->json($user);
    }

    /**
     * Restore the specified resource to storage.
     * @throws AuthorizationException
     */
    public function restore(int $userID): JsonResponse
    {
        $user = User::onlyTrashed()->findOrFail($userID);

        $this->authorize(UserPolicy::DELETE, $user);

        if ($user instanceof User) {
            $user->restore();
        }

        return response()->json($user);
    }

    /**
     * Remove the specified resource forever.
     * @throws AuthorizationException
     */
    public function delete(int $userID): JsonResponse
    {
        $user = User::onlyTrashed()->findOrFail($userID);

        $this->authorize(UserPolicy::FORCE_DELETE, $user);

        // $user->forceDelete();

        return response()->json(['message' => 'Rest in peace...']);
    }

    /**
     * Assign role to user
     */
    public function assignRole(UserRoleAssignRequest $request, User $user, UserAssignRoleAction $assignRoleAction): JsonResponse
    {
        $assignRoleAction->handle($user, $request->input('role'));

        return response()->json($user);
    }

    /**
     * Remove role from user
     */
    public function removeRole(UserRoleAssignRequest $request, User $user, UserRemoveRoleAction $removeRoleAction): JsonResponse
    {
        $removeRoleAction->handle($user, $request->input('role'));

        return response()->json($user);
    }
}
