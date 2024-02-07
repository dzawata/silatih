<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user_role = auth()->user()->role;
        if (in_array($user_role, explode('|', $role))) {
            if ($user_role ==  3 and auth()->user()->email_verified_at == null) {
                return redirect('operator/not_verified');
            }
            return $next($request);
        } else {
            return $this->reditecting($user_role);;
        }
    }

    public function reditecting($role)
    {
        if ($role == 1 or $role == 2) {
            return redirect('/');
        } else if ($role == 3) {

            return redirect("operator/dashboard");
        }
    }
}
