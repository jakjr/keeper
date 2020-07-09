<?php

namespace Jakjr\Keeper\Middleware;

use Closure;
use Illuminate\Support\Arr;

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

            $keeper->keep(
                Arr::dot(
                    $request->only(['filter'])
                )
            );

            //sempre que houver submit de filters,
            //reinicio a paginação do contexto.
            if ($keeper->has('page')) {
                $keeper->keep(['page' => 1]);
            }
        }

        return $next($request);
    }
}
