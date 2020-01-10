<?php


namespace Codwelt\Blog\Http\Middlewares;


use Closure;
use Illuminate\Http\Request;

class APIMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if($request->wantsJson())
        {
            return $next($request);
        }

        return response()->json(["message" => "Debe especificar el header de Accept en application/json"],500);

    }
}