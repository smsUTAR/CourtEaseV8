<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show Payment Page
    public function showPayment(Court $court)
    {
        return view('payment', [
            'court' => $court,
            'price' => $court->price,
        ]);
    }

    // Process Payment and Show Confirmation
    public function processPayment(Request $request)
    {
        $request->validate([
            'court_id' => 'required|exists:courts,id',
            'payment_method' => 'required|in:credit_debit,e_wallet',
        ]);
    
        // Create a booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'court_id' => $request->court_id,
            'booking_date' => now(),
            'payment_method' => $request->payment_method,
            'status' => 'confirmed',
            'totalPrice' => $request->total,
            'hours' => $request->hours,
        ]);
    
        // Return the booking details to the confirmation page
        return redirect()->route('booking-confirmation', ['booking' => $booking->id]);
    }
    

    public function showConfirmation(Booking $booking)
    {
        // Eager load the related Court and User
        $booking->load('court', 'user');
    
        return view('booking-confirmation', [
            'booking' => $booking,
        ]);
    }
}
