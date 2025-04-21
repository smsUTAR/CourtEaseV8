<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockRevisitToPayment
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
        if ($request->session()->has('payment_completed')) {
            $bookingId = $request->session()->get('completed_booking_id');
            if ($bookingId) {
                return redirect()->route('booking-confirmation', ['booking' => $bookingId]);
            }
    
            return redirect('/court-listing'); // fallback if no booking ID is available
        }
    
        return $next($request);
    }
}
