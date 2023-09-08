<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseFormatter;
use Closure;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Http\Request;

class RoleAuthorization
{
    protected $auth;

    public function __construct(AuthFactory $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next, $guard = null, ...$roles)
    {
        $authGuard = $this->auth->guard($guard);

        $roleAuth = $authGuard->user()->role;

        if (count($roles) > 0) {
            if (in_array($roleAuth->slug, $roles)) {
                return $next($request);
            } else {
                return ResponseFormatter::error(null, 'Hak akses ' . $roleAuth->name . ' tidak diizinkan mengakses url ini!', 403);
            }
        } else {
            return $next($request);
        }
    }
}
