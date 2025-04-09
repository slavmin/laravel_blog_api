<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\JsonHttpException;

class EnsureUserHasPublisherRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     * @throws JsonHttpException
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $user = auth()->user();

        if ($user instanceof User && $user->isPublisher()) {
            return $next($request);
        }

        throw new JsonHttpException('', 403);
    }
}
