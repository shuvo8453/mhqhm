<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $guard
     */
    public function handle(Request $request, Closure $next,$guard)
    {
        $route = Route::current();
        $permission = $this->getNameRoute($route->action["as"]);

        if(!empty($guard) && !empty($permission)){
            if(!Auth::guard($guard)->user()->can($permission)){
                if($request->ajax()){
                    return response("You Dont Have Enough permission",403);
                }
                return abort('403',"You Dont Have Enough permission");
            }
        }else{
            if($request->ajax()){
                return response("You Dont Have Enough permission",403);
            }
            return abort('403',"You Dont Have Enough permission");

        }
        return $next($request);
    }

    private function getNameRoute(string $name = ""): string
    {
        $names = explode(".",$name);
        $action = $names[1] ?? "";
        $module = $names[0] ?? "";
        return $action  . " " . $module ;
    }
}
