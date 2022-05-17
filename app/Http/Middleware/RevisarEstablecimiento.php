<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RevisarEstablecimiento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $establecimiento = auth()->user()->establecimiento;
        if ($establecimiento) {
            return  redirect(route(
                'establecimiento.edit',
                ['establecimiento' => $establecimiento->id]
            ));
        }

        return $next($request);
    }
}
