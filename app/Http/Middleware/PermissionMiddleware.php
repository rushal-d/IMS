<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_DEBUG') == true) {
            return $next($request);
        }
        $user = Auth::user();
        $permission = \Illuminate\Support\Facades\Route::currentRouteName();


        if ($user->can($permission)) {
            return $next($request);
        } else {
            if($request->header('x-requested-with')==='XMLHttpRequest'){
                return response()->json('No Permission',403);
            }else{
                $notification = array(
                    'message' => 'You Dont Have Permission',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }

        }


    }
}