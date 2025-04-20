<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Court;

class CheckCourtAvailability
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
        $courtId = $request->route('id'); // assuming your route is something like court-details/{id}
        $court = Court::find($courtId);

        if (!$court || $court->status === 'not_available') {
            return redirect()->route('court-listing')->with('error', 'Court is not available.');
        }

        return $next($request);
    }
}
