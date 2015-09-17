<?php

namespace Jakjr\Keeper\Middleware;

use Closure;

class KeepFilters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( $request->has('filter') ) {

            $keeper = \App::make('keeper');

            $keeper->keep( array_dot( $request->only(['filter']) ) );

            //sempre que houver submit de filters,
            //reinicio a paginação do contexto.
            if ($keeper->has('page')) {
                $keeper->keep(['page' => 1]);
            }
        }

        return $next($request);
    }
}
